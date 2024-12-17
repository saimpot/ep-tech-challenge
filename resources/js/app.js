require('./bootstrap');

import Vue from 'vue';
import ClientsList from './components/ClientsList.vue';
import ClientForm from  './components/ClientForm.vue';
import ClientShow from  './components/ClientShow.vue';

Vue.component('clients-list', ClientsList);
Vue.component('client-form', ClientForm);
Vue.component('client-show', ClientShow);

const app = new Vue({
    el: '#app',
});
