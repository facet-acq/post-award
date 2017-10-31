// External Setup
require('./axios');
// require('./echo');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const FacetLandingPage = Vue.component('facet-landing-page', require('./components/FacetLandingPage.vue'));

const app = new Vue({
    el: '#app',
    component: { FacetLandingPage }
});