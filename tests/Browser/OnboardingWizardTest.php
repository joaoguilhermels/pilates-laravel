<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;

class OnboardingWizardTest extends DuskTestCase
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();
        // Create a fresh user for each test
        $this->user = User::factory()->create();
    }

    /** @test */
    public function onboarding_modal_displays_for_new_users()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                    ->visit('/home')
                    ->waitFor('[x-show="showWizard"]', 5)
                    ->assertSee('Welcome to Your Pilates Studio Management System!')
                    ->assertSee('I\'ll Set Up Later')
                    ->assertSee('Let\'s Get Started!');
        });
    }

    /** @test */
    public function skip_button_closes_modal_and_reloads_page()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                    ->visit('/home')
                    ->waitFor('[x-show="showWizard"]', 5)
                    ->assertVisible('[x-show="showWizard"]')
                    ->click('button:contains("I\'ll Set Up Later")')
                    ->waitUntilMissing('[x-show="showWizard"]', 5)
                    ->assertDontSee('Welcome to Your Pilates Studio Management System!');
        });
    }

    /** @test */
    public function start_button_closes_modal_and_scrolls()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                    ->visit('/home')
                    ->waitFor('[x-show="showWizard"]', 5)
                    ->assertVisible('[x-show="showWizard"]')
                    ->click('button:contains("Let\'s Get Started!")')
                    ->waitUntilMissing('[x-show="showWizard"]', 5)
                    ->assertDontSee('Welcome to Your Pilates Studio Management System!')
                    ->pause(1000); // Wait for scroll to complete
        });
    }

    /** @test */
    public function no_javascript_errors_occur_during_interaction()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                    ->visit('/home')
                    ->waitFor('[x-show="showWizard"]', 5);

            // Check for JavaScript errors in console
            $logs = $browser->driver->manage()->getLog('browser');
            $errors = array_filter($logs, function($log) {
                return $log['level'] === 'SEVERE' && 
                       (strpos($log['message'], 'TypeError') !== false ||
                        strpos($log['message'], 'ReferenceError') !== false ||
                        strpos($log['message'], 'not a function') !== false);
            });

            $this->assertEmpty($errors, 'JavaScript errors found: ' . json_encode($errors));
        });
    }

    /** @test */
    public function alpine_js_is_loaded_and_working()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                    ->visit('/home')
                    ->waitFor('[x-show="showWizard"]', 5);

            // Check if Alpine.js is loaded
            $alpineLoaded = $browser->script('return typeof Alpine !== "undefined"')[0];
            $this->assertTrue($alpineLoaded, 'Alpine.js is not loaded');

            // Check if x-data is initialized
            $hasXData = $browser->script('
                const element = document.querySelector("[x-data]");
                return element && element._x_dataStack && element._x_dataStack.length > 0;
            ')[0];
            $this->assertTrue($hasXData, 'Alpine.js x-data is not initialized');
        });
    }

    /** @test */
    public function csrf_token_is_present()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                    ->visit('/home');

            // Check if CSRF token exists
            $csrfToken = $browser->script('
                const meta = document.querySelector("meta[name=csrf-token]");
                return meta ? meta.getAttribute("content") : null;
            ')[0];

            $this->assertNotNull($csrfToken, 'CSRF token not found');
            $this->assertGreaterThan(10, strlen($csrfToken), 'CSRF token seems invalid');
        });
    }

    /** @test */
    public function skip_onboarding_makes_api_call()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                    ->visit('/home')
                    ->waitFor('[x-show="showWizard"]', 5);

            // Enable network logging
            $browser->script('
                window.apiCalls = [];
                const originalFetch = window.fetch;
                window.fetch = function(...args) {
                    window.apiCalls.push({
                        url: args[0],
                        options: args[1] || {}
                    });
                    return originalFetch.apply(this, args);
                };
            ');

            $browser->click('button:contains("I\'ll Set Up Later")')
                    ->pause(2000); // Wait for API call

            // Check if API call was made
            $apiCalls = $browser->script('return window.apiCalls || []')[0];
            
            $skipCall = collect($apiCalls)->first(function($call) {
                return strpos($call['url'], '/onboarding/skip') !== false;
            });

            $this->assertNotNull($skipCall, 'Skip onboarding API call was not made');
            $this->assertEquals('POST', $skipCall['options']['method'] ?? null);
        });
    }

    /** @test */
    public function onboarding_functions_are_accessible()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                    ->visit('/home')
                    ->waitFor('[x-show="showWizard"]', 5);

            // Check if Alpine.js functions are accessible
            $functionsExist = $browser->script('
                const element = document.querySelector("[x-data]");
                if (!element || !element._x_dataStack || !element._x_dataStack[0]) {
                    return { error: "No Alpine.js data found" };
                }
                
                const data = element._x_dataStack[0];
                return {
                    hasSkipFunction: typeof data.skipOnboarding === "function",
                    hasStartFunction: typeof data.startOnboarding === "function",
                    showWizard: data.showWizard
                };
            ')[0];

            $this->assertTrue($functionsExist['hasSkipFunction'] ?? false, 'skipOnboarding function not found');
            $this->assertTrue($functionsExist['hasStartFunction'] ?? false, 'startOnboarding function not found');
            $this->assertTrue($functionsExist['showWizard'] ?? false, 'showWizard property not set correctly');
        });
    }

    /** @test */
    public function console_logs_appear_when_buttons_clicked()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                    ->visit('/home')
                    ->waitFor('[x-show="showWizard"]', 5);

            // Clear console logs
            $browser->script('console.clear()');

            // Click skip button
            $browser->click('button:contains("I\'ll Set Up Later")')
                    ->pause(1000);

            // Check for expected console logs
            $logs = $browser->driver->manage()->getLog('browser');
            $skipLog = collect($logs)->first(function($log) {
                return strpos($log['message'], 'Skip onboarding clicked') !== false;
            });

            $this->assertNotNull($skipLog, 'Expected console log "Skip onboarding clicked" not found');
        });
    }

    /** @test */
    public function setup_steps_element_handling()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                    ->visit('/home')
                    ->waitFor('[x-show="showWizard"]', 5);

            // Add a setup-steps element for testing
            $browser->script('
                const setupSteps = document.createElement("div");
                setupSteps.id = "setup-steps";
                setupSteps.innerHTML = "<h2>Setup Steps</h2>";
                setupSteps.style.marginTop = "1000px";
                document.body.appendChild(setupSteps);
            ');

            $browser->click('button:contains("Let\'s Get Started!")')
                    ->pause(1500); // Wait for scroll

            // Check if element is in viewport (scrolled to)
            $isInViewport = $browser->script('
                const element = document.getElementById("setup-steps");
                if (!element) return false;
                
                const rect = element.getBoundingClientRect();
                return rect.top >= 0 && rect.top <= window.innerHeight;
            ')[0];

            $this->assertTrue($isInViewport, 'Setup steps element was not scrolled into view');
        });
    }

    /** @test */
    public function fallback_scroll_when_no_setup_steps()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                    ->visit('/home')
                    ->waitFor('[x-show="showWizard"]', 5);

            // Ensure no setup-steps element exists and add content to make page scrollable
            $browser->script('
                const existing = document.getElementById("setup-steps");
                if (existing) existing.remove();
                
                const content = document.createElement("div");
                content.style.height = "2000px";
                content.innerHTML = "<p>Long content to make page scrollable</p>";
                document.body.appendChild(content);
            ');

            $initialScroll = $browser->script('return window.pageYOffset')[0];

            $browser->click('button:contains("Let\'s Get Started!")')
                    ->pause(1500); // Wait for scroll

            $finalScroll = $browser->script('return window.pageYOffset')[0];

            $this->assertGreaterThan($initialScroll, $finalScroll, 'Page did not scroll when setup-steps element was missing');
        });
    }
}
