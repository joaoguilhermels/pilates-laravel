<?php

use App\Models\SaasPlans;

test('registration page loads successfully with plans', function () {
    // Create test plans
    SaasPlans::factory()->create([
        'name' => 'Test Plan',
        'is_active' => true,
        'is_popular' => true,
    ]);

    $response = $this->get('/register');

    $response->assertStatus(200);
    $response->assertSee('Test Plan');
});

test('registration page handles no plans gracefully', function () {
    // Ensure no plans exist
    \App\Models\SaasPlans::query()->delete();
    
    $response = $this->get('/register');

    $response->assertStatus(200);
    $response->assertSee('Nenhum plano disponível');
});

test('registration page shows popular plan indicator', function () {
    SaasPlans::factory()->create([
        'name' => 'Regular Plan',
        'is_active' => true,
        'is_popular' => false,
    ]);

    SaasPlans::factory()->create([
        'name' => 'Popular Plan',
        'is_active' => true,
        'is_popular' => true,
    ]);

    $response = $this->get('/register');

    $response->assertStatus(200);
    $response->assertSee('Popular Plan');
    $response->assertSee('⭐');
});
