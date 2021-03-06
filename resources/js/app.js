/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

Vue.component('app', require('./components/App.vue').default);

/**
 * Import addon components
 */
Vue.component('animated-integer', require('./components/addons/AnimatedInteger.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
import './google-maps.js'
import router from './router.js'
import vuetify from './vuetify.js'
import store from './store'

const app = new Vue({ vuetify, router, store }).$mount('#app');
