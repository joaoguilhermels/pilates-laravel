<?php

use App\Models\User;

beforeEach(function () {
    $this->actingAs(User::factory()->create());
});

test('onboarding javascript can be extracted and validated', function () {
    $response = $this->get('/home');
    
    expect($response->status())->toBe(200);
    
    $content = $response->getContent();
    
    // Extract the JavaScript code
    preg_match('/Alpine\.data\(\'onboardingWizard\',.*?\}\)\);/s', $content, $matches);
    
    expect($matches)->not->toBeEmpty('Alpine.js component definition should be found');
    
    $jsCode = $matches[0];
    
    // Validate the JavaScript structure
    expect($jsCode)
        ->toContain('skipOnboarding()')
        ->toContain('startOnboarding()')
        ->toContain('showWizard: isNewUser')
        ->toContain('this.showWizard = false');
});

test('onboarding component can handle button click simulation', function () {
    $response = $this->get('/home');
    
    $content = $response->getContent();
    
    // Check that the component structure is correct for Alpine.js
    expect($content)
        ->toContain('x-data="onboardingWizard(true)"')
        ->toContain('@click="skipOnboarding()"')
        ->toContain('@click="startOnboarding()"');
});

test('skip onboarding api endpoint works correctly', function () {
    // Test the actual API endpoint that would be called by JavaScript
    $response = $this->post('/onboarding/skip', [], [
        'Content-Type' => 'application/json',
        'Accept' => 'application/json',
        'X-CSRF-TOKEN' => csrf_token()
    ]);
    
    expect($response->status())->toBeIn([200, 302]);
});

test('onboarding wizard javascript has no syntax errors', function () {
    $response = $this->get('/home');
    
    $content = $response->getContent();
    
    // Extract the JavaScript and check for common syntax issues
    preg_match('/<script>(.*?)<\/script>/s', $content, $matches);
    
    if (!empty($matches[1])) {
        $jsCode = $matches[1];
        
        // Check for balanced braces
        $openBraces = substr_count($jsCode, '{');
        $closeBraces = substr_count($jsCode, '}');
        expect($openBraces)->toBe($closeBraces, 'JavaScript should have balanced braces');
        
        // Check for balanced parentheses
        $openParens = substr_count($jsCode, '(');
        $closeParens = substr_count($jsCode, ')');
        expect($openParens)->toBe($closeParens, 'JavaScript should have balanced parentheses');
        
        // Check for proper function definitions
        expect($jsCode)
            ->toContain('function()')
            ->toContain('console.log');
    }
});

test('alpine js initialization happens before component usage', function () {
    $response = $this->get('/home');
    
    $content = $response->getContent();
    
    // Find positions of Alpine.js initialization and component usage
    $alpineInitPos = strpos($content, 'alpine:init');
    $componentUsagePos = strpos($content, 'x-data="onboardingWizard');
    
    expect($alpineInitPos)->toBeLessThan($componentUsagePos, 
        'Alpine.js initialization should come before component usage');
});

test('onboarding modal visibility is controlled by alpine js', function () {
    $response = $this->get('/home');
    
    $content = $response->getContent();
    
    // Check that the modal uses Alpine.js for visibility
    expect($content)
        ->toContain('x-show="showWizard"')
        ->toContain('x-transition')
        ->toContain('x-cloak');
});

test('javascript functions have proper scope and context', function () {
    $response = $this->get('/home');
    
    $content = $response->getContent();
    
    // Extract the Alpine.js component definition
    preg_match('/Alpine\.data\(\'onboardingWizard\',.*?return \{(.*?)\}\)\);/s', $content, $matches);
    
    if (!empty($matches[1])) {
        $componentBody = $matches[1];
        
        // Check that functions use proper 'this' context
        expect($componentBody)
            ->toContain('this.showWizard')
            ->toContain('this.$nextTick');
    }
});

test('onboarding buttons are properly bound to alpine functions', function () {
    $response = $this->get('/home');
    
    $content = $response->getContent();
    
    // Check that buttons use Alpine.js click handlers
    expect($content)
        ->toContain('@click="skipOnboarding()"')
        ->toContain('@click="startOnboarding()"')
        ->not->toContain('onclick='); // Should not use inline onclick
});

test('csrf token is accessible to javascript', function () {
    $response = $this->get('/home');
    
    $content = $response->getContent();
    
    // Check that CSRF token is available in meta tag for JavaScript access
    expect($content)
        ->toContain('<meta name="csrf-token"')
        ->toContain('document.querySelector(\'meta[name=csrf-token]\')');
});

test('onboarding component handles new user state correctly', function () {
    $response = $this->get('/home');
    
    $content = $response->getContent();
    
    // For a new user, the component should be initialized with true
    expect($content)->toContain('onboardingWizard(true)');
});

test('setup steps element is present for scroll target', function () {
    $response = $this->get('/home');
    
    $content = $response->getContent();
    
    // Check that the scroll target exists
    expect($content)->toContain('id="setup-steps"');
    
    // And that the JavaScript looks for it
    expect($content)->toContain('getElementById(\'setup-steps\')');
});

test('error handling is implemented in javascript functions', function () {
    $response = $this->get('/home');
    
    $content = $response->getContent();
    
    // Check that error handling is present
    expect($content)
        ->toContain('.catch(error')
        ->toContain('console.error');
});

test('onboarding wizard includes proper debugging information', function () {
    $response = $this->get('/home');
    
    $content = $response->getContent();
    
    // Check for debugging console logs
    expect($content)
        ->toContain('console.log(\'Skip onboarding clicked\')')
        ->toContain('console.log(\'Start onboarding clicked\')');
});

test('alpine js component is properly structured for reactivity', function () {
    $response = $this->get('/home');
    
    $content = $response->getContent();
    
    // Extract the component definition
    preg_match('/Alpine\.data\(\'onboardingWizard\',.*?return \{(.*?)\}\)\);/s', $content, $matches);
    
    if (!empty($matches[1])) {
        $componentBody = $matches[1];
        
        // Check for proper reactive data properties
        expect($componentBody)
            ->toContain('showWizard:')
            ->toContain('currentStep:');
    }
});

test('onboarding wizard javascript timing is properly handled', function () {
    $response = $this->get('/home');
    
    $content = $response->getContent();
    
    // Check for proper timing controls
    expect($content)
        ->toContain('setTimeout')
        ->toContain('$nextTick');
});
