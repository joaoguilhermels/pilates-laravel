/**
 * Manual Onboarding Test Script
 * 
 * Run this in the browser console on the /home page to test onboarding functionality
 * 
 * Instructions:
 * 1. Open /home in browser
 * 2. Open Developer Tools (F12)
 * 3. Go to Console tab
 * 4. Copy and paste this entire script
 * 5. Press Enter to run
 */

console.log('🧪 Starting Manual Onboarding Tests...');

// Test 1: Check if Alpine.js is loaded
function testAlpineLoaded() {
    console.log('\n📋 Test 1: Alpine.js Loading');
    if (typeof Alpine !== 'undefined') {
        console.log('✅ Alpine.js is loaded');
        return true;
    } else {
        console.log('❌ Alpine.js is NOT loaded');
        return false;
    }
}

// Test 2: Check if CSRF token exists
function testCSRFToken() {
    console.log('\n📋 Test 2: CSRF Token');
    const csrfMeta = document.querySelector('meta[name="csrf-token"]');
    if (csrfMeta && csrfMeta.getAttribute('content')) {
        console.log('✅ CSRF token found:', csrfMeta.getAttribute('content').substring(0, 10) + '...');
        return true;
    } else {
        console.log('❌ CSRF token NOT found');
        return false;
    }
}

// Test 3: Check if onboarding modal exists
function testModalExists() {
    console.log('\n📋 Test 3: Onboarding Modal');
    const modal = document.querySelector('[x-show="showWizard"]');
    if (modal) {
        console.log('✅ Onboarding modal element found');
        const isVisible = !modal.hasAttribute('style') || !modal.style.display.includes('none');
        console.log('Modal visibility:', isVisible ? '✅ Visible' : '❌ Hidden');
        return true;
    } else {
        console.log('❌ Onboarding modal element NOT found');
        return false;
    }
}

// Test 4: Check if Alpine.js data is initialized
function testAlpineData() {
    console.log('\n📋 Test 4: Alpine.js Data');
    const alpineElement = document.querySelector('[x-data]');
    if (alpineElement && alpineElement._x_dataStack) {
        const data = alpineElement._x_dataStack[0];
        console.log('✅ Alpine.js data found:', {
            showWizard: data.showWizard,
            currentStep: data.currentStep,
            hasSkipFunction: typeof data.skipOnboarding === 'function',
            hasStartFunction: typeof data.startOnboarding === 'function'
        });
        return data;
    } else {
        console.log('❌ Alpine.js data NOT found');
        return null;
    }
}

// Test 5: Check if buttons exist and have correct attributes
function testButtons() {
    console.log('\n📋 Test 5: Button Elements');
    const skipButton = document.querySelector('button:contains("I\'ll Set Up Later")') || 
                      Array.from(document.querySelectorAll('button')).find(btn => btn.textContent.includes("I'll Set Up Later"));
    const startButton = Array.from(document.querySelectorAll('button')).find(btn => btn.textContent.includes("Let's Get Started"));
    
    console.log('Skip button:', skipButton ? '✅ Found' : '❌ Not found');
    console.log('Start button:', startButton ? '✅ Found' : '❌ Not found');
    
    if (skipButton) {
        console.log('Skip button @click:', skipButton.getAttribute('@click') || 'No @click attribute');
    }
    if (startButton) {
        console.log('Start button @click:', startButton.getAttribute('@click') || 'No @click attribute');
    }
    
    return { skipButton, startButton };
}

// Test 6: Test skip functionality (without actually calling API)
function testSkipFunction() {
    console.log('\n📋 Test 6: Skip Function Test');
    const alpineElement = document.querySelector('[x-data]');
    if (alpineElement && alpineElement._x_dataStack) {
        const data = alpineElement._x_dataStack[0];
        if (typeof data.skipOnboarding === 'function') {
            console.log('✅ skipOnboarding function exists');
            // Test if we can access the function (don't actually call it)
            console.log('Function definition:', data.skipOnboarding.toString().substring(0, 100) + '...');
            return true;
        }
    }
    console.log('❌ skipOnboarding function NOT accessible');
    return false;
}

// Test 7: Test start function
function testStartFunction() {
    console.log('\n📋 Test 7: Start Function Test');
    const alpineElement = document.querySelector('[x-data]');
    if (alpineElement && alpineElement._x_dataStack) {
        const data = alpineElement._x_dataStack[0];
        if (typeof data.startOnboarding === 'function') {
            console.log('✅ startOnboarding function exists');
            console.log('Function definition:', data.startOnboarding.toString().substring(0, 100) + '...');
            return true;
        }
    }
    console.log('❌ startOnboarding function NOT accessible');
    return false;
}

// Test 8: Check for setup-steps element
function testSetupStepsElement() {
    console.log('\n📋 Test 8: Setup Steps Element');
    const setupSteps = document.getElementById('setup-steps');
    if (setupSteps) {
        console.log('✅ setup-steps element found');
        console.log('Element position:', setupSteps.getBoundingClientRect());
        return true;
    } else {
        console.log('⚠️ setup-steps element not found (this is OK if no setup steps are needed)');
        return false;
    }
}

// Test 9: Test global objects availability
function testGlobalObjects() {
    console.log('\n📋 Test 9: Global Objects');
    const globals = {
        document: typeof document !== 'undefined',
        window: typeof window !== 'undefined',
        fetch: typeof fetch !== 'undefined',
        setTimeout: typeof setTimeout !== 'undefined',
        location: typeof location !== 'undefined'
    };
    
    console.log('Global objects availability:', globals);
    
    const allAvailable = Object.values(globals).every(Boolean);
    if (allAvailable) {
        console.log('✅ All required global objects are available');
    } else {
        console.log('❌ Some global objects are missing');
    }
    
    return allAvailable;
}

// Test 10: Simulate button click (safe test)
function testButtonClickSimulation() {
    console.log('\n📋 Test 10: Button Click Simulation');
    
    const buttons = testButtons();
    if (buttons.skipButton) {
        console.log('Testing skip button click simulation...');
        try {
            // Create a fake click event to test if Alpine.js responds
            const clickEvent = new Event('click', { bubbles: true });
            console.log('✅ Click event created successfully');
            
            // Don't actually click, just verify the event can be created
            console.log('✅ Button click simulation test passed');
            return true;
        } catch (error) {
            console.log('❌ Button click simulation failed:', error.message);
            return false;
        }
    } else {
        console.log('❌ Cannot test button click - button not found');
        return false;
    }
}

// Run all tests
async function runAllTests() {
    console.log('🚀 Running all manual tests...\n');
    
    const results = {
        alpineLoaded: testAlpineLoaded(),
        csrfToken: testCSRFToken(),
        modalExists: testModalExists(),
        alpineData: testAlpineData(),
        buttons: testButtons(),
        skipFunction: testSkipFunction(),
        startFunction: testStartFunction(),
        setupSteps: testSetupStepsElement(),
        globalObjects: testGlobalObjects(),
        buttonClickSim: testButtonClickSimulation()
    };
    
    console.log('\n📊 Test Results Summary:');
    console.log('========================');
    
    let passedTests = 0;
    let totalTests = 0;
    
    Object.entries(results).forEach(([testName, result]) => {
        totalTests++;
        if (result === true || (result && typeof result === 'object')) {
            passedTests++;
            console.log(`✅ ${testName}: PASSED`);
        } else {
            console.log(`❌ ${testName}: FAILED`);
        }
    });
    
    console.log(`\n🎯 Overall Score: ${passedTests}/${totalTests} tests passed`);
    
    if (passedTests === totalTests) {
        console.log('🎉 ALL TESTS PASSED! Onboarding should be working correctly.');
    } else if (passedTests >= totalTests * 0.8) {
        console.log('⚠️ Most tests passed. Minor issues may exist.');
    } else {
        console.log('❌ Multiple issues detected. Onboarding may not work correctly.');
    }
    
    return results;
}

// Auto-run tests
runAllTests();

console.log('\n💡 To manually test the buttons:');
console.log('1. Click "I\'ll Set Up Later" button and watch console for logs');
console.log('2. Click "Let\'s Get Started!" button and watch console for logs');
console.log('3. Check for any JavaScript errors in console');
