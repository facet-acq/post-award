/**
 * Setup basic Axios AJAX headers and settings
 */
import axios from 'axios';
window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// Setup CSRF token
let token = document.head.querySelector('meta[name="csrf-token"]');
if (token) {
  window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
}

/**
 * Setup Vue for the project
 */
import Vue from 'vue';
window.Vue = Vue;

// Vue Component
const FacetLandingPage = Vue.component('facet-landing-page', require('./components/FacetLandingPage.vue'));

const app = new Vue({
  component: { FacetLandingPage }
}).$mount('#app');
