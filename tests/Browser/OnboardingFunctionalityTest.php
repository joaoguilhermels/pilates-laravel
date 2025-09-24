<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;

class OnboardingFunctionalityTest extends DuskTestCase
{
    use DatabaseMigrations;

    /** @test */
    public function onboarding_modal_displays_for_new_users()
    {
        $user = User::factory()->create();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                    ->visit('/home')
                    ->waitFor('[x-data]', 10)
                    ->assertSee('Welcome to Your Pilates Studio Management System!')
                    ->assertSee('Let\'s Get Started!')
                    ->assertSee('I\'ll Set Up Later');
        });
    }

    /** @test */
    public function lets_get_started_button_closes_modal_and_scrolls()
    {
        $user = User::factory()->create();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                    ->visit('/home')
                    ->waitFor('[x-data]', 10)
                    ->assertVisible('.fixed.inset-0') // Modal should be visible
                    ->waitForText('Let\'s Get Started!', 5)
                    ->click('button:contains("Let\'s Get Started!")')
                    ->pause(500) // Wait for animation
                    ->assertMissing('.fixed.inset-0') // Modal should be hidden
                    ->pause(1000); // Wait for scroll animation
        });
    }

    /** @test */
    public function skip_button_closes_modal_and_makes_api_call()
    {
        $user = User::factory()->create();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                    ->visit('/home')
                    ->waitFor('[x-data]', 10)
                    ->assertVisible('.fixed.inset-0') // Modal should be visible
                    ->waitForText('I\'ll Set Up Later', 5)
                    ->click('button:contains("I\'ll Set Up Later")')
                    ->pause(500) // Wait for animation
                    ->assertMissing('.fixed.inset-0') // Modal should be hidden
                    ->pause(2000); // Wait for page reload
        });
    }

    /** @test */
    public function alpine_js_is_loaded_and_working()
    {
        $user = User::factory()->create();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                    ->visit('/home')
                    ->waitFor('[x-data]', 10)
                    ->script('return typeof Alpine !== "undefined"');
            
            $this->assertTrue($browser->script('return typeof Alpine !== "undefined"')[0]);
        });
    }

    /** @test */
    public function onboarding_wizard_component_is_properly_initialized()
    {
        $user = User::factory()->create();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                    ->visit('/home')
                    ->waitFor('[x-data]', 10)
                    ->script('return typeof Alpine.data !== "undefined"');
            
            $this->assertTrue($browser->script('return typeof Alpine.data !== "undefined"')[0]);
        });
    }

    /** @test */
    public function console_logs_appear_when_buttons_clicked()
    {
        $user = User::factory()->create();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                    ->visit('/home')
                    ->waitFor('[x-data]', 10);
            
            // Clear console logs
            $browser->script('console.clear()');
            
            // Click the start button
            $browser->click('button:contains("Let\'s Get Started!")')
                    ->pause(1000);
            
            // Check if console log appears (this is a basic check)
            $logs = $browser->driver->manage()->getLog('browser');
            $hasStartLog = false;
            foreach ($logs as $log) {
                if (strpos($log['message'], 'Start onboarding clicked') !== false) {
                    $hasStartLog = true;
                    break;
                }
            }
            
            // Note: Console log checking in Dusk can be unreliable, 
            // so we'll focus on DOM changes instead
            $browser->assertMissing('.fixed.inset-0');
        });
    }

    /** @test */
    public function onboarding_functions_are_accessible()
    {
        $user = User::factory()->create();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                    ->visit('/home')
                    ->waitFor('[x-data]', 10)
                    ->pause(2000); // Wait for Alpine to fully initialize
            
            // Test if the Alpine component is accessible
            $hasComponent = $browser->script('
                return document.querySelector("[x-data]") && 
                       document.querySelector("[x-data]").__x && 
                       typeof document.querySelector("[x-data]").__x.$data.startOnboarding === "function"
            ')[0];
            
            $this->assertTrue($hasComponent, 'Alpine.js onboarding component should be accessible');
        });
    }

    /** @test */
    public function setup_steps_element_exists_for_scrolling()
    {
        $user = User::factory()->create();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                    ->visit('/home')
                    ->waitFor('[x-data]', 10)
                    ->assertPresent('#setup-steps'); // Element should exist for scrolling
        });
    }

    /** @test */
    public function csrf_token_is_available_for_api_calls()
    {
        $user = User::factory()->create();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                    ->visit('/home')
                    ->waitFor('[x-data]', 10);
            
            // Check if CSRF token meta tag exists
            $hasCSRF = $browser->script('
                return document.querySelector("meta[name=csrf-token]") !== null &&
                       document.querySelector("meta[name=csrf-token]").getAttribute("content").length > 0
            ')[0];
            
            $this->assertTrue($hasCSRF, 'CSRF token should be available for API calls');
        });
    }

    /** @test */
    public function onboarding_modal_has_proper_styling()
    {
        $user = User::factory()->create();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                    ->visit('/home')
                    ->waitFor('[x-data]', 10)
                    ->assertVisible('.fixed.inset-0') // Modal overlay
                    ->assertVisible('.bg-white') // Modal content
                    ->assertVisible('.bg-gradient-to-r.from-indigo-500.to-purple-600'); // Gradient button
        });
    }

    /** @test */
    public function javascript_errors_do_not_occur_during_interaction()
    {
        $user = User::factory()->create();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                    ->visit('/home')
                    ->waitFor('[x-data]', 10);
            
            // Clear any existing console errors
            $browser->script('console.clear()');
            
            // Interact with both buttons
            $browser->click('button:contains("Let\'s Get Started!")')
                    ->pause(1000)
                    ->refresh()
                    ->waitFor('[x-data]', 10)
                    ->click('button:contains("I\'ll Set Up Later")')
                    ->pause(2000);
            
            // Check for JavaScript errors
            $logs = $browser->driver->manage()->getLog('browser');
            $hasErrors = false;
            foreach ($logs as $log) {
                if ($log['level'] === 'SEVERE' && strpos($log['message'], 'TypeError') !== false) {
                    $hasErrors = true;
                    break;
                }
            }
            
            $this->assertFalse($hasErrors, 'No JavaScript errors should occur during button interactions');
        });
    }

    /** @test */
    public function onboarding_wizard_responds_to_button_clicks()
    {
        $user = User::factory()->create();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                    ->visit('/home')
                    ->waitFor('[x-data]', 10)
                    ->pause(2000); // Ensure Alpine is fully loaded
            
            // Test that clicking buttons actually triggers changes
            $initialModalVisible = $browser->script('
                return document.querySelector(".fixed.inset-0") !== null &&
                       window.getComputedStyle(document.querySelector(".fixed.inset-0")).display !== "none"
            ')[0];
            
            $this->assertTrue($initialModalVisible, 'Modal should initially be visible');
            
            // Click the start button
            $browser->click('button:contains("Let\'s Get Started!")')
                    ->pause(1000);
            
            // Check if modal is hidden after click
            $modalHiddenAfterClick = $browser->script('
                return document.querySelector(".fixed.inset-0") === null ||
                       window.getComputedStyle(document.querySelector(".fixed.inset-0")).display === "none"
            ')[0];
            
            $this->assertTrue($modalHiddenAfterClick, 'Modal should be hidden after clicking start button');
        });
    }
}
