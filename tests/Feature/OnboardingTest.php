<?php

use App\Models\User;

beforeEach(function () {
    $this->actingAs(User::factory()->create());
});

test('home page loads successfully', function () {
    $response = $this->get('/home');
    
    expect($response->status())->toBe(200);
});

test('home page contains onboarding wizard', function () {
    $response = $this->get('/home');
    
    expect($response->status())->toBe(200);
    
    $content = $response->getContent();
    expect($content)
        ->toContain('Welcome to Your Pilates Studio!')
        ->toContain('Skip for now')
        ->toContain('Get Started');
});

test('onboarding skip endpoint exists', function () {
    $response = $this->post('/onboarding/skip');
    
    expect($response->status())->toBeIn([200, 302]);
});

test('home page contains alpine js data', function () {
    $response = $this->get('/home');
    
    expect($response->status())->toBe(200);
    
    $content = $response->getContent();
    expect($content)
        ->toContain('x-data')
        ->toContain('showWizard');
});

test('csrf token is present in layout', function () {
    $response = $this->get('/home');
    
    expect($response->status())->toBe(200);
    expect($response->getContent())->toContain('csrf-token');
});

test('onboarding component is included', function () {
    $response = $this->get('/home');
    
    expect($response->status())->toBe(200);
    
    $content = $response->getContent();
    expect($content)
        ->toContain('skipOnboarding')
        ->toContain('startOnboarding');
});

test('onboarding wizard has proper alpine js structure', function () {
    $response = $this->get('/home');
    
    $content = $response->getContent();
    expect($content)
        ->toContain('x-show="showWizard"')
        ->toContain('@click="skipOnboarding()"')
        ->toContain('@click="startOnboarding()"')
        ->toContain('$nextTick');
});

test('onboarding wizard includes proper error handling', function () {
    $response = $this->get('/home');
    
    $content = $response->getContent();
    expect($content)
        ->toContain('console.log')
        ->toContain('console.error')
        ->toContain('.catch(error');
});

test('onboarding wizard has proper timing controls', function () {
    $response = $this->get('/home');
    
    $content = $response->getContent();
    expect($content)
        ->toContain('setTimeout')
        ->toContain('this.$nextTick')
        ->toContain('location.reload');
});

test('onboarding wizard includes scroll functionality', function () {
    $response = $this->get('/home');
    
    $content = $response->getContent();
    expect($content)
        ->toContain('getElementById(\'setup-steps\')')
        ->toContain('scrollIntoView')
        ->toContain('window.scrollTo');
});

test('onboarding wizard has proper csrf protection', function () {
    $response = $this->get('/home');
    
    $content = $response->getContent();
    expect($content)
        ->toContain('X-CSRF-TOKEN')
        ->toContain('meta[name=csrf-token]')
        ->toContain('getAttribute(\'content\')');
});

test('onboarding wizard includes api call structure', function () {
    $response = $this->get('/home');
    
    $content = $response->getContent();
    expect($content)
        ->toContain('fetch(')
        ->toContain('method: \'POST\'')
        ->toContain('Content-Type')
        ->toContain('application/json');
});

test('onboarding wizard has proper button styling', function () {
    $response = $this->get('/home');
    
    $content = $response->getContent();
    expect($content)
        ->toContain('bg-gradient-to-r')
        ->toContain('from-indigo-500')
        ->toContain('to-purple-600')
        ->toContain('hover:from-indigo-600');
});

test('onboarding wizard includes dark mode support', function () {
    $response = $this->get('/home');
    
    $content = $response->getContent();
    expect($content)
        ->toContain('dark:bg-gray')
        ->toContain('dark:text-gray')
        ->toContain('dark:border-gray');
});

test('onboarding wizard has responsive design', function () {
    $response = $this->get('/home');
    
    $content = $response->getContent();
    expect($content)
        ->toContain('sm:')
        ->toContain('md:')
        ->toContain('lg:');
});

test('onboarding status includes all required fields', function () {
    $response = $this->get('/home');
    
    // Test that the onboarding status is properly passed to the view
    expect($response->status())->toBe(200);
    
    // The view should receive onboardingStatus data
    $content = $response->getContent();
    expect($content)->toContain('needsOnboarding');
});

test('onboarding wizard handles new user state', function () {
    $response = $this->get('/home');
    
    $content = $response->getContent();
    expect($content)
        ->toContain('isNewUser')
        ->toContain('showWizard');
});

test('onboarding wizard includes proper transitions', function () {
    $response = $this->get('/home');
    
    $content = $response->getContent();
    expect($content)
        ->toContain('x-transition')
        ->toContain('ease-out')
        ->toContain('duration-300');
});

test('onboarding wizard has accessibility features', function () {
    $response = $this->get('/home');
    
    $content = $response->getContent();
    expect($content)
        ->toContain('x-cloak')
        ->toContain('focus:')
        ->toContain('transition-');
});

test('onboarding wizard includes proper modal structure', function () {
    $response = $this->get('/home');
    
    $content = $response->getContent();
    expect($content)
        ->toContain('fixed inset-0')
        ->toContain('bg-gray-500 bg-opacity-75')
        ->toContain('flex items-center justify-center')
        ->toContain('z-50');
});
