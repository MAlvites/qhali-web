/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('./plugins/vuetify');

window.Vue = require('vue').default;

import Vuetify from 'vuetify';
Vue.use(Vuetify)

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('create-patient', require('./components/patient/CreatePatient.vue').default);
Vue.component('edit-patient', require('./components/patient/EditPatient.vue').default);
Vue.component('list-patient', require('./components/patient/ListPatient.vue').default);
Vue.component('contact-support', require('./components/support/ContactSupport.vue').default);
Vue.component('user-component', require('./components/user/User.vue').default);
Vue.component('bot-action', require('./components/bot-action/BotAction.vue').default);
Vue.component('bot-component', require('./components/bot/Bot.vue').default);
Vue.component('medical-appointment', require('./components/medical-appointment/MedicalAppointment.vue').default);
Vue.component('patient-managment', require('./components/medical-appointment/PatientManagment.vue').default);
Vue.component('medical-attention', require('./components/medical-appointment/MedicalAttention.vue').default);
Vue.component('bot-dashboard', require('./components/dashboard/BotDashboard.vue').default);
Vue.component('create-quiz', require('./components/quiz/CreateQuiz.vue').default);
Vue.component('edit-quiz', require('./components/quiz/EditQuiz.vue').default);
Vue.component('list-quiz', require('./components/quiz/ListQuiz.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    vuetify: new Vuetify()
});
