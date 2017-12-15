
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

Vue.use(require('vue-resource'));
Vue.use(require('vue-js-modal'));

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// Vue.component('example-component', require('./components/ExampleComponent.vue'));
import Valas from './components/Valas.vue';
import Mitra from './components/Mitra.vue';
import Penukaran from './components/Penukaran.vue';
import Ppsv from './components/Ppsv.vue';
import Approvalitem from './components/Approvalitem.vue';

import Approval from './components/Approval/Approval.vue';
Vue.http.headers.common['X-CSRF-TOKEN'] = Laravel.csrftoken;
window.routerIsReady = false;

const app = new Vue({
    el: '#app',
    components:{
        Valas,
        Mitra,
        Penukaran,
        Ppsv,
        Approvalitem,
        Approval
    },
    created() {
        this.$http.get(configURLs).then(res => {
            console.log(res.data.urls);
            Approvalitem.data().urls = res.data.urls;
            //Approvalitem.data().setRouter(true);
            Approvalitem.methods.setRouterIsReady(true);
            console.log(Approvalitem);
        });
    },
    methods: {
    }
});
