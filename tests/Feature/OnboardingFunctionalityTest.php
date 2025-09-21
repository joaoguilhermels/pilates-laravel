<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class OnboardingFunctionalityTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->actingAs(User::factory()->create());
    }

    /** @test */
    public function home_page_loads_successfully()
    {
        $response = $this->get('/home');
        $response->assertStatus(200);
    }

    /** @test */
    public function home_page_contains_onboarding_wizard()
    {
        $response = $this->get('/home');
        
        $response->assertStatus(200);
        $response->assertSee('Welcome to Your Pilates Studio Management System!');
        
        // Check for button text in different ways
        $content = $response->getContent();
        $this->assertStringContainsString('Set Up Later', $content);
        $this->assertStringContainsString('Get Started', $content);
    }

    /** @test */
    public function onboarding_skip_endpoint_exists()
    {
        $response = $this->post('/onboarding/skip');
        
        // Should return success (we don't care about the exact implementation)
        $this->assertTrue(in_array($response->status(), [200, 302]));
    }

    /** @test */
    public function home_page_contains_alpine_js_data()
    {
        $response = $this->get('/home');
        
        $response->assertStatus(200);
        $response->assertSee('x-data');
        $response->assertSee('showWizard');
    }

    /** @test */
    public function csrf_token_is_present_in_layout()
    {
        $response = $this->get('/home');
        
        $response->assertStatus(200);
        $response->assertSee('csrf-token');
    }

    /** @test */
    public function onboarding_component_is_included()
    {
        $response = $this->get('/home');
        
        $response->assertStatus(200);
        $response->assertSee('skipOnboarding');
        $response->assertSee('startOnboarding');
    }
}
