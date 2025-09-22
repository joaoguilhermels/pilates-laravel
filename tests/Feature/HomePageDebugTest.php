<?php

use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
});

test('debug home page error', function () {
    try {
        $response = $this->get('/home');
        
        if ($response->status() !== 200) {
            // Get the actual error content
            $content = $response->getContent();
            echo "Response status: " . $response->status() . "\n";
            echo "Response content: " . substr($content, 0, 1000) . "\n";
        }
        
        expect($response->status())->toBe(200);
    } catch (\Exception $e) {
        echo "Exception: " . $e->getMessage() . "\n";
        echo "File: " . $e->getFile() . "\n";
        echo "Line: " . $e->getLine() . "\n";
        throw $e;
    }
});

test('check if route exists', function () {
    $routes = collect(\Illuminate\Support\Facades\Route::getRoutes())->map(function ($route) {
        return $route->getName();
    })->filter();
    
    expect($routes->contains('home'))->toBeTrue();
});

test('check if middleware is causing issues', function () {
    // Test without any middleware
    $this->withoutMiddleware();
    
    $response = $this->get('/home');
    
    if ($response->status() !== 200) {
        echo "Even without middleware, status is: " . $response->status() . "\n";
        echo "Content: " . substr($response->getContent(), 0, 500) . "\n";
    }
    
    expect($response->status())->toBe(200);
});
