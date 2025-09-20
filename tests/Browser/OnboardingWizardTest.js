const { test, expect } = require('@playwright/test');

test.describe('Onboarding Wizard', () => {
  test.beforeEach(async ({ page }) => {
    // Navigate to the home page
    await page.goto('http://localhost/home');
    
    // Wait for the page to load
    await page.waitForLoadState('networkidle');
  });

  test('should display onboarding modal for new users', async ({ page }) => {
    // Check if the onboarding modal is visible
    const modal = page.locator('[x-show="showWizard"]');
    await expect(modal).toBeVisible();
    
    // Check if the welcome message is present
    await expect(page.locator('text=Welcome to Your Pilates Studio Management System!')).toBeVisible();
    
    // Check if both buttons are present
    await expect(page.locator('text=I\'ll Set Up Later')).toBeVisible();
    await expect(page.locator('text=Let\'s Get Started!')).toBeVisible();
  });

  test('should close modal when "I\'ll Set Up Later" is clicked', async ({ page }) => {
    // Wait for modal to be visible
    const modal = page.locator('[x-show="showWizard"]');
    await expect(modal).toBeVisible();
    
    // Click the "I'll Set Up Later" button
    const skipButton = page.locator('text=I\'ll Set Up Later');
    await skipButton.click();
    
    // Modal should close (become hidden)
    await expect(modal).toBeHidden();
    
    // Page should reload (we can check for this by waiting for navigation)
    await page.waitForLoadState('networkidle');
  });

  test('should close modal and scroll when "Let\'s Get Started!" is clicked', async ({ page }) => {
    // Wait for modal to be visible
    const modal = page.locator('[x-show="showWizard"]');
    await expect(modal).toBeVisible();
    
    // Click the "Let's Get Started!" button
    const startButton = page.locator('text=Let\'s Get Started!');
    await startButton.click();
    
    // Modal should close (become hidden)
    await expect(modal).toBeHidden();
    
    // Wait a moment for scrolling to complete
    await page.waitForTimeout(500);
    
    // Check if we scrolled to the setup steps or bottom of page
    // We can verify this by checking if setup-steps element is in viewport
    const setupSteps = page.locator('#setup-steps');
    if (await setupSteps.isVisible()) {
      // If setup-steps exists, it should be in viewport
      await expect(setupSteps).toBeInViewport();
    } else {
      // If no setup-steps, should have scrolled to bottom
      const scrollPosition = await page.evaluate(() => window.pageYOffset);
      expect(scrollPosition).toBeGreaterThan(0);
    }
  });

  test('should not show JavaScript errors in console', async ({ page }) => {
    const consoleErrors = [];
    
    // Listen for console errors
    page.on('console', msg => {
      if (msg.type() === 'error') {
        consoleErrors.push(msg.text());
      }
    });
    
    // Wait for modal to be visible
    const modal = page.locator('[x-show="showWizard"]');
    await expect(modal).toBeVisible();
    
    // Test both buttons
    const skipButton = page.locator('text=I\'ll Set Up Later');
    await skipButton.click();
    
    // Wait a moment for any errors to appear
    await page.waitForTimeout(1000);
    
    // Check that no JavaScript errors occurred
    const relevantErrors = consoleErrors.filter(error => 
      error.includes('TypeError') || 
      error.includes('undefined') || 
      error.includes('not a function')
    );
    
    expect(relevantErrors).toHaveLength(0);
  });

  test('should make API call when skipping onboarding', async ({ page }) => {
    // Set up request interception
    const apiCalls = [];
    
    page.on('request', request => {
      if (request.url().includes('/onboarding/skip')) {
        apiCalls.push({
          url: request.url(),
          method: request.method(),
          headers: request.headers()
        });
      }
    });
    
    // Wait for modal to be visible
    const modal = page.locator('[x-show="showWizard"]');
    await expect(modal).toBeVisible();
    
    // Click the skip button
    const skipButton = page.locator('text=I\'ll Set Up Later');
    await skipButton.click();
    
    // Wait for API call to be made
    await page.waitForTimeout(2000);
    
    // Verify API call was made
    expect(apiCalls).toHaveLength(1);
    expect(apiCalls[0].method).toBe('POST');
    expect(apiCalls[0].headers['content-type']).toBe('application/json');
    expect(apiCalls[0].headers['x-csrf-token']).toBeDefined();
  });

  test('should handle CSRF token correctly', async ({ page }) => {
    // Check if CSRF token meta tag exists
    const csrfMeta = page.locator('meta[name="csrf-token"]');
    await expect(csrfMeta).toHaveAttribute('content');
    
    // Get the CSRF token value
    const csrfToken = await csrfMeta.getAttribute('content');
    expect(csrfToken).toBeTruthy();
    expect(csrfToken.length).toBeGreaterThan(10);
  });

  test('should work with Alpine.js properly', async ({ page }) => {
    // Check if Alpine.js is loaded
    const alpineLoaded = await page.evaluate(() => {
      return typeof window.Alpine !== 'undefined';
    });
    expect(alpineLoaded).toBe(true);
    
    // Check if x-data is properly initialized
    const xDataElement = page.locator('[x-data]');
    await expect(xDataElement).toBeVisible();
    
    // Test Alpine.js reactivity by checking showWizard property
    const showWizardValue = await page.evaluate(() => {
      const element = document.querySelector('[x-data]');
      return element._x_dataStack && element._x_dataStack[0].showWizard;
    });
    
    expect(showWizardValue).toBe(true);
  });

  test('should handle network errors gracefully', async ({ page }) => {
    // Intercept and fail the skip API call
    await page.route('**/onboarding/skip', route => {
      route.abort('failed');
    });
    
    // Wait for modal to be visible
    const modal = page.locator('[x-show="showWizard"]');
    await expect(modal).toBeVisible();
    
    // Click the skip button
    const skipButton = page.locator('text=I\'ll Set Up Later');
    await skipButton.click();
    
    // Modal should still close even if API fails
    await expect(modal).toBeHidden();
    
    // Page should still reload after timeout
    await page.waitForTimeout(2000);
  });

  test('should scroll to setup steps if element exists', async ({ page }) => {
    // First, ensure we have setup steps on the page by adding them
    await page.evaluate(() => {
      const setupSteps = document.createElement('div');
      setupSteps.id = 'setup-steps';
      setupSteps.innerHTML = '<h2>Setup Steps</h2>';
      setupSteps.style.marginTop = '1000px'; // Add some space to test scrolling
      document.body.appendChild(setupSteps);
    });
    
    // Wait for modal to be visible
    const modal = page.locator('[x-show="showWizard"]');
    await expect(modal).toBeVisible();
    
    // Click the start button
    const startButton = page.locator('text=Let\'s Get Started!');
    await startButton.click();
    
    // Wait for scrolling to complete
    await page.waitForTimeout(1000);
    
    // Check if setup-steps element is in viewport
    const setupSteps = page.locator('#setup-steps');
    await expect(setupSteps).toBeInViewport();
  });

  test('should scroll to bottom if setup steps element does not exist', async ({ page }) => {
    // Ensure no setup-steps element exists
    await page.evaluate(() => {
      const existing = document.getElementById('setup-steps');
      if (existing) existing.remove();
      
      // Add some content to make the page scrollable
      const content = document.createElement('div');
      content.style.height = '2000px';
      content.innerHTML = '<p>Long content to make page scrollable</p>';
      document.body.appendChild(content);
    });
    
    // Wait for modal to be visible
    const modal = page.locator('[x-show="showWizard"]');
    await expect(modal).toBeVisible();
    
    // Get initial scroll position
    const initialScroll = await page.evaluate(() => window.pageYOffset);
    
    // Click the start button
    const startButton = page.locator('text=Let\'s Get Started!');
    await startButton.click();
    
    // Wait for scrolling to complete
    await page.waitForTimeout(1000);
    
    // Check if we scrolled down
    const finalScroll = await page.evaluate(() => window.pageYOffset);
    expect(finalScroll).toBeGreaterThan(initialScroll);
  });
});

// Helper test to debug Alpine.js and DOM state
test.describe('Debug Onboarding Issues', () => {
  test('debug Alpine.js and DOM state', async ({ page }) => {
    await page.goto('http://localhost/home');
    await page.waitForLoadState('networkidle');
    
    // Check what's available in the global scope
    const globalObjects = await page.evaluate(() => {
      return {
        hasWindow: typeof window !== 'undefined',
        hasDocument: typeof document !== 'undefined',
        hasSetTimeout: typeof setTimeout !== 'undefined',
        hasFetch: typeof fetch !== 'undefined',
        hasAlpine: typeof Alpine !== 'undefined',
        windowHasDocument: typeof window.document !== 'undefined',
        windowHasSetTimeout: typeof window.setTimeout !== 'undefined',
        windowHasFetch: typeof window.fetch !== 'undefined'
      };
    });
    
    console.log('Global objects availability:', globalObjects);
    
    // Check Alpine.js data
    const alpineData = await page.evaluate(() => {
      const element = document.querySelector('[x-data]');
      if (element && element._x_dataStack) {
        return element._x_dataStack[0];
      }
      return null;
    });
    
    console.log('Alpine.js data:', alpineData);
    
    // Check CSRF token
    const csrfToken = await page.evaluate(() => {
      const meta = document.querySelector('meta[name="csrf-token"]');
      return meta ? meta.getAttribute('content') : null;
    });
    
    console.log('CSRF token:', csrfToken);
    
    // All checks should pass
    expect(globalObjects.hasWindow).toBe(true);
    expect(globalObjects.hasDocument).toBe(true);
    expect(globalObjects.hasSetTimeout).toBe(true);
    expect(globalObjects.hasFetch).toBe(true);
    expect(csrfToken).toBeTruthy();
  });
});
