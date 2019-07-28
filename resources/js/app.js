
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
window.Vuetify = require('vuetify');
import VueRouter from 'vue-router'
import VueSignaturePad from 'vue-signature-pad';
 
Vue.use(VueRouter);
Vue.use(Vuetify);
Vue.use(VueSignaturePad);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
Vue.component('stepper-component', require('./components/StepperComponent.vue'));

import router from './router'


const app = new Vue({
    el: '#app',
    router,
});
