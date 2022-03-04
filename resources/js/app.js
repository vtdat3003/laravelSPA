/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import 'es6-promise/auto'
import axios from 'axios'
import Vue from 'vue'
import VueAuth from '@websanova/vue-auth'
//import auth from '@websanova/vue-auth/dist/v2/vue-auth.esm.js';
import VueAxios from 'vue-axios'
import VueRouter from 'vue-router'
import ExampleComonent from './components/ExampleComponent.vue'
import authentication from '../authentication'
import router from '../router.js'
import store from './store';

window.Vue = require('vue').default;

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

Vue.component('users-component', require('./components/UsersComponent.vue').default);

Vue.component('notis-component', require('./components/NotisComponent.vue').default);

Vue.component('login-component', require('./vue/Auth/login.vue').default);
Vue.component('register-component', require('./vue/Auth/register.vue').default);
Vue.component('unauthorize-component', require('./vue/Auth/unauthorize.vue').default);

Vue.prototype.$user = document.querySelector("meta[name='user']").getAttribute('content');

Vue.router = router
Vue.use(VueRouter)

Vue.use(VueAxios, axios)
axios.defaults.baseURL = `/`

Vue.config.productionTip = false

Vue.use(VueAuth, authentication)

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    store,
    el: '#app',
});
