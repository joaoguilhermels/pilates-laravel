<?php

use App\Models\User;

beforeEach(function () {
    $this->actingAs(User::factory()->create());
});

test('onboarding page loads without alpine js component definition in template', function () {
    $response = $this->get('/home');
    
    expect($response->status())->toBe(200);
    
    $content = $response->getContent();
    
    // Should NOT contain Alpine.js component definition in template anymore
    expect($content)->not->toContain('Alpine.data(\'onboardingWizard\'');
    
    // Should still contain the Alpine.js directive usage
    expect($content)->toContain('x-data="onboardingWizard(');
});

test('onboarding component usage is present in template', function () {
    $response = $this->get('/home');
    
    $content = $response->getContent();
    
    // Should contain Alpine.js directives
    expect($content)
        ->toContain('x-data="onboardingWizard(')
        ->toContain('@click="skipOnboarding()"')
        ->toContain('@click="startOnboarding()"')
        ->toContain('x-show="showWizard"');
});

test('vite assets are properly included', function () {
    $response = $this->get('/home');
    
    $content = $response->getContent();
    
    // Should contain Vite asset references
    expect($content)
        ->toContain('/build/assets/app-')
        ->toContain('.js')
        ->toContain('.css');
});

test('csrf token is available for alpine js component', function () {
    $response = $this->get('/home');
    
    $content = $response->getContent();
    
    // Should contain CSRF token meta tag
    expect($content)->toContain('<meta name="csrf-token"');
});

test('onboarding skip endpoint is accessible', function () {
    $response = $this->post('/onboarding/skip');
    
    // Should return success or redirect
    expect($response->status())->toBeIn([200, 302]);
});

test('setup steps element exists for scroll target', function () {
    $response = $this->get('/home');
    
    $content = $response->getContent();
    
    // Should contain the setup steps element
    expect($content)->toContain('id="setup-steps"');
});

test('onboarding modal has proper alpine js structure', function () {
    $response = $this->get('/home');
    
    $content = $response->getContent();
    
    // Should contain proper Alpine.js modal structure
    expect($content)
        ->toContain('x-show="showWizard"')
        ->toContain('x-transition')
        ->toContain('x-cloak');
});

test('onboarding wizard receives new user parameter', function () {
    $response = $this->get('/home');
    
    $content = $response->getContent();
    
    // Should pass true for new users
    expect($content)->toContain('onboardingWizard(true)');
});

test('onboarding buttons have proper styling and structure', function () {
    $response = $this->get('/home');
    
    $content = $response->getContent();
    
    // Should contain the styled buttons
    expect($content)
        ->toContain('Let\'s Get Started!')
        ->toContain('I\'ll Set Up Later')
        ->toContain('bg-gradient-to-r from-indigo-500 to-purple-600');
});

test('onboarding wizard is properly structured for new users', function () {
    $response = $this->get('/home');
    
    $content = $response->getContent();
    
    // Should contain the welcome message and structure
    expect($content)
        ->toContain('Welcome to Your Pilates Studio Management System!')
        ->toContain('Quick Setup Process');
});
