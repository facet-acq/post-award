import './axios';
import './echo';
import 'typeface-fira-sans';

/**
 * Setup Vue for the project
 */
import Vue from 'vue';
window.Vue = Vue;
window.eventHub = new Vue();
window.flash = function (message) {
  window.eventHub.$emit('flash', message);
};

/**
 * Setup Vue Router
 */
import VueRouter from 'vue-router';
import routes from './routes';
Vue.use(VueRouter);
const router = new VueRouter({
  mode: 'history',
  routes,
  linkActiveClass: 'is-active'
});

/**
 * Basic App Setup
 */
import App from './components/App.vue';
new Vue({
  components: { App },
  router
}).$mount('#app');
