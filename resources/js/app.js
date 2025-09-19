// Application JavaScript
import './bootstrap';

import { createApp } from 'vue';
import PlanPayment from './components/PlanPayment.vue';

const app = createApp({});

app.component('plan-payment', PlanPayment);

app.mount('#app');