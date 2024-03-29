import '../css/app.css';

/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('sweetalert2');
require('jquery-datetimepicker');
require('multiselect');
require('fullcalendar');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the body of the page. From here, you may begin adding components to
 * the application, or feel free to tweak this setup for your needs.
 */

Vue.component('professionalClassesPercentageValue', require('./components/professionalClassesPercentageValue.vue')); 
Vue.component('classProfessionalRoom', require('./components/classProfessionalRoom.vue'));
Vue.component('classProfessionalRoomStatus', require('./components/classProfessionalRoomStatus.vue'));
Vue.component('planPayment', require('./components/planPayment.vue'));
Vue.component('calendar', require('./components/calendar.vue'));
Vue.component('startAt', require('./components/startAt.vue'));
Vue.component('modal', require('./components/modal.vue'));
Vue.component('plans', require('./components/plans.vue'));

Vue.directive('confirm', require('./directives/confirm.vue'));
Vue.directive('ajax', require('./directives/ajaxForm.vue'));

const app = new Vue({
    el: '#app'
});
