require('./bootstrap');
window.Vue = require('vue').default;

import router from './router';
import { store } from './store';
import Vuelidate from 'vuelidate';
import 'bootstrap/dist/css/bootstrap.css';
import { TablePlugin } from 'bootstrap-vue';
import 'bootstrap-vue/dist/bootstrap-vue.css';
import VueFlashMessage from '@smartweb/vue-flash-message';
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue';

import shared from "./shared"

Vue.use(IconsPlugin);
Vue.use(TablePlugin);
Vue.use(BootstrapVue);
Vue.use(VueFlashMessage);
Vue.use(Vuelidate)

Vue.mixin(shared)

Vue.component('app',require('./components/app').default)
const app = new Vue({
    el : '#app',
    router,
    store : store,
})
