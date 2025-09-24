<?php

use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
});

test('onboarding status contains valid step structure', function () {
    $controller = new \App\Http\Controllers\HomeController();
    $status = $controller->checkOnboardingStatus();
    
    expect($status)->toBeArray();
    expect($status)->toHaveKey('nextSteps');
    
    // Each step should have required keys for the component
    foreach ($status['nextSteps'] as $step) {
        expect($step)->toHaveKey('url');
        expect($step)->toHaveKey('title');
        expect($step)->toHaveKey('description');
        expect($step)->toHaveKey('action');
        expect($step)->toHaveKey('icon');
        expect($step)->toHaveKey('route'); // Should also have route for reference
    }
});

test('onboarding steps have valid urls', function () {
    $controller = new \App\Http\Controllers\HomeController();
    $status = $controller->checkOnboardingStatus();
    
    foreach ($status['nextSteps'] as $step) {
        expect($step['url'])->toBeString();
        expect($step['url'])->not->toBeEmpty();
        // Should be a valid route or URL
        expect($step['url'])->toMatch('/^(https?:\/\/|\/)/');
    }
});

test('onboarding component renders without errors', function () {
    // This test should pass once we fix the issue
    $response = $this->get('/home');
    
    expect($response->status())->toBe(200);
});
