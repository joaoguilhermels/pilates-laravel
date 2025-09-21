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
            fetch(window.location.origin + '/onboarding/skip', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').getAttribute('content')
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

window.Alpine = Alpine;
Alpine.start();

import { createApp } from 'vue';
import PlanPayment from './components/PlanPayment.vue';

const app = createApp({});

app.component('plan-payment', PlanPayment);

app.mount('#app');