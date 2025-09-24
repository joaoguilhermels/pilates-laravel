<?php

use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
});

test('home page loads successfully', function () {
    $response = $this->get('/home');
    
    expect($response->status())->toBe(200);
});

test('home page contains required elements', function () {
    $response = $this->get('/home');
    
    expect($response->status())->toBe(200);
    
    $content = $response->getContent();
    expect($content)
        ->toContain('Dashboard')
        ->toContain('app.welcome'); // This is the translation key used in the template
});

test('home page handles onboarding status correctly', function () {
    $response = $this->get('/home');
    
    expect($response->status())->toBe(200);
    
    // Should not throw any errors when calculating onboarding status
    expect($response->getContent())->toContain('html');
});

test('home controller checkOnboardingStatus method works', function () {
    $controller = new \App\Http\Controllers\HomeController();
    
    // This should not throw any errors
    $status = $controller->checkOnboardingStatus();
    
    expect($status)->toBeArray();
    expect($status)->toHaveKeys(['needsOnboarding', 'isNewUser', 'progress', 'nextSteps']);
});

test('home page works without any data', function () {
    // Test with a completely fresh user with no data
    $freshUser = User::factory()->create([
        'onboarding_completed' => false
    ]);
    
    $this->actingAs($freshUser);
    
    $response = $this->get('/home');
    
    expect($response->status())->toBe(200);
});

test('home page works with existing data', function () {
    // Create some test data
    \App\Models\Professional::factory()->create();
    \App\Models\Room::factory()->create();
    \App\Models\ClassType::factory()->create();
    
    $response = $this->get('/home');
    
    expect($response->status())->toBe(200);
});

test('onboarding middleware does not break home page', function () {
    // Test that the onboarding middleware doesn't interfere with home page
    session(['onboarding_active' => true]);
    
    $response = $this->get('/home');
    
    expect($response->status())->toBe(200);
});

test('home page session handling works correctly', function () {
    // Test various session states
    session(['onboarding_success' => 'Test message']);
    
    $response = $this->get('/home');
    
    expect($response->status())->toBe(200);
    expect($response->getContent())->toContain('Test message');
});
