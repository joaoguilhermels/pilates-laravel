// Application JavaScript
import './bootstrap';
import './deletion-protection';

// Import and initialize Alpine.js
import Alpine from 'alpinejs';

// Define onboarding wizard component
Alpine.data('onboardingWizard', (isNewUser) => ({
    showWizard: isNewUser,
    currentStep: 0,
    
    skipOnboarding() {
        console.log('Skip onboarding clicked');
        this.showWizard = false;
        
        this.$nextTick(() => {
            const csrfToken = document.querySelector('meta[name=csrf-token]');
            if (!csrfToken) {
                console.error('CSRF token not found');
                setTimeout(() => location.reload(), 1000);
                return;
            }
            
            fetch(window.location.origin + '/onboarding/skip', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken.getAttribute('content')
                },
                body: JSON.stringify({})
            })
            .then(response => {
                console.log('Skip response status:', response.status);
                setTimeout(() => location.reload(), 1000);
            })
            .catch(error => {
                console.error('Error skipping onboarding:', error);
                setTimeout(() => location.reload(), 1000);
            });
        });
    },
    
    startOnboarding() {
        console.log('Start onboarding clicked');
        this.showWizard = false;
        
        this.$nextTick(() => {
            setTimeout(() => {
                const element = document.getElementById('setup-steps');
                if (element) {
                    console.log('Scrolling to setup steps');
                    element.scrollIntoView({ behavior: 'smooth' });
                } else {
                    console.log('Setup steps element not found, scrolling to bottom');
                    window.scrollTo({ top: document.body.scrollHeight, behavior: 'smooth' });
                }
            }, 100);
        });
    }
}));

// Global functions for backward compatibility
window.startOnboarding = function() {
    const element = document.getElementById('setup-steps');
    if (element) {
        element.scrollIntoView({ behavior: 'smooth' });
    } else {
        window.scrollTo({ top: document.body.scrollHeight, behavior: 'smooth' });
    }
};

window.skipOnboarding = function() {
    const csrfToken = document.querySelector('meta[name=csrf-token]');
    if (!csrfToken) {
        console.error('CSRF token not found');
        location.reload();
        return;
    }
    
    fetch(window.location.origin + '/onboarding/skip', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrfToken.getAttribute('content')
        },
        body: JSON.stringify({})
    })
    .then(response => {
        console.log('Skip response status:', response.status);
        setTimeout(() => location.reload(), 1000);
    })
    .catch(error => {
        console.error('Error skipping onboarding:', error);
        setTimeout(() => location.reload(), 1000);
    });
};

window.Alpine = Alpine;
Alpine.start();

// Vue.js initialization with error handling - only when needed
document.addEventListener('DOMContentLoaded', () => {
    try {
        const appElement = document.getElementById('app');
        // Only initialize Vue if there are Vue components on the page
        const hasVueComponents = document.querySelector('plan-payment') || 
                                document.querySelector('[data-vue]') ||
                                (appElement && appElement.children.length > 0);
        
        if (appElement && hasVueComponents) {
            // Dynamic import to avoid compilation issues
            import('vue').then(({ createApp }) => {
                import('./components/PlanPayment.vue').then((module) => {
                    const PlanPayment = module.default;
                    const app = createApp({});
                    app.component('plan-payment', PlanPayment);
                    app.mount('#app');
                }).catch(error => {
                    console.warn('PlanPayment component failed to load:', error);
                });
            }).catch(error => {
                console.warn('Vue.js failed to load:', error);
            });
        }
    } catch (error) {
        console.warn('Vue.js initialization failed:', error);
    }
});