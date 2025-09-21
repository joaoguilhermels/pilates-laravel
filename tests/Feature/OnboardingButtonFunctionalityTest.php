<?php

use App\Models\User;

beforeEach(function () {
    $this->actingAs(User::factory()->create());
});

test('onboarding wizard contains proper alpine js component definition', function () {
    $response = $this->get('/home');
    
    expect($response->status())->toBe(200);
    
    $content = $response->getContent();
    expect($content)
        ->toContain('Alpine.data(\'onboardingWizard\'')
        ->toContain('skipOnboarding()')
        ->toContain('startOnboarding()');
});

test('alpine js component has proper structure', function () {
    $response = $this->get('/home');
    
    $content = $response->getContent();
    expect($content)
        ->toContain('showWizard: isNewUser')
        ->toContain('currentStep: 0')
        ->toContain('this.showWizard = false');
});

test('start onboarding function includes scroll functionality', function () {
    $response = $this->get('/home');
    
    $content = $response->getContent();
    expect($content)
        ->toContain('getElementById(\'setup-steps\')')
        ->toContain('scrollIntoView')
        ->toContain('window.scrollTo');
});

test('skip onboarding function includes api call', function () {
    $response = $this->get('/home');
    
    $content = $response->getContent();
    expect($content)
        ->toContain('fetch(')
        ->toContain('/onboarding/skip')
        ->toContain('X-CSRF-TOKEN')
        ->toContain('location.reload()');
});

test('onboarding buttons use correct alpine js syntax', function () {
    $response = $this->get('/home');
    
    $content = $response->getContent();
    expect($content)
        ->toContain('@click="skipOnboarding()"')
        ->toContain('@click="startOnboarding()"');
});

test('alpine js component is properly initialized', function () {
    $response = $this->get('/home');
    
    $content = $response->getContent();
    expect($content)
        ->toContain('document.addEventListener(\'alpine:init\'')
        ->toContain('x-data="onboardingWizard(');
});

test('onboarding skip endpoint returns success', function () {
    $response = $this->post('/onboarding/skip');
    
    expect($response->status())->toBeIn([200, 302]);
});

test('csrf token is properly included in page', function () {
    $response = $this->get('/home');
    
    $content = $response->getContent();
    expect($content)
        ->toContain('name="csrf-token"')
        ->toContain('content="');
});

test('setup steps element exists for scrolling target', function () {
    $response = $this->get('/home');
    
    $content = $response->getContent();
    expect($content)->toContain('id="setup-steps"');
});

test('onboarding modal has proper visibility controls', function () {
    $response = $this->get('/home');
    
    $content = $response->getContent();
    expect($content)
        ->toContain('x-show="showWizard"')
        ->toContain('x-transition');
});

test('javascript functions have proper error handling', function () {
    $response = $this->get('/home');
    
    $content = $response->getContent();
    expect($content)
        ->toContain('.catch(error')
        ->toContain('console.error')
        ->toContain('console.log');
});

test('onboarding component receives correct parameters', function () {
    $response = $this->get('/home');
    
    $content = $response->getContent();
    
    // Should pass the isNewUser parameter to the component
    expect($content)->toContain('onboardingWizard(true)');
});

test('buttons have proper styling classes', function () {
    $response = $this->get('/home');
    
    $content = $response->getContent();
    expect($content)
        ->toContain('bg-gradient-to-r from-indigo-500 to-purple-600')
        ->toContain('hover:from-indigo-600 hover:to-purple-700');
});

test('modal overlay has proper z-index and positioning', function () {
    $response = $this->get('/home');
    
    $content = $response->getContent();
    expect($content)
        ->toContain('fixed inset-0')
        ->toContain('z-50')
        ->toContain('bg-gray-500 bg-opacity-75');
});

test('onboarding wizard includes proper timing controls', function () {
    $response = $this->get('/home');
    
    $content = $response->getContent();
    expect($content)
        ->toContain('setTimeout')
        ->toContain('this.$nextTick')
        ->toContain('pause(');
});

test('api call includes proper headers', function () {
    $response = $this->get('/home');
    
    $content = $response->getContent();
    expect($content)
        ->toContain('Content-Type')
        ->toContain('application/json')
        ->toContain('Accept');
});

test('onboarding wizard has accessibility features', function () {
    $response = $this->get('/home');
    
    $content = $response->getContent();
    expect($content)
        ->toContain('x-cloak')
        ->toContain('transition-');
});

test('javascript includes proper debugging logs', function () {
    $response = $this->get('/home');
    
    $content = $response->getContent();
    expect($content)
        ->toContain('Skip onboarding clicked')
        ->toContain('Start onboarding clicked')
        ->toContain('Scrolling to setup steps');
});

test('onboarding status data is properly passed to component', function () {
    $response = $this->get('/home');
    
    expect($response->status())->toBe(200);
    
    // The response should include the onboarding status data
    $content = $response->getContent();
    expect($content)->toContain('needsOnboarding');
});

test('alpine js component handles missing setup steps element', function () {
    $response = $this->get('/home');
    
    $content = $response->getContent();
    expect($content)
        ->toContain('Setup steps element not found')
        ->toContain('document.body.scrollHeight');
});
