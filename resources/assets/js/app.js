
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
//window.bus = bus;
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
import Btupsvform from './components/Btupsvform.vue';
import ModalCariPpsv from './components/ModalCariPpsv.vue';

import Approval from './components/Approval/Approval.vue';
import Bbsv from './components/Bbsv/Bbsv.vue';
import Uploadkuitansi from './components/Bbsv/Uploadkuitansi.vue';
import BbsvForm from './components/Bbsv/BbsvForm.vue';

function TextBoxRupiah(param) {
    this.element  = $(param.id);
    this.pemisah = param.pemisah;
    this.init = function() {
        var pemisah = this.pemisah;
        this.element.keyup(function(event) {
            // skip for arrow keys
            if(event.which >= 37 && event.which <= 40) return;
            // format number
            $(this).val(function(index, value) {
                return value
                .replace(/\D/g, "")
                .replace(/\B(?=(\d{3})+(?!\d))/g, pemisah);
            });
        });
    };
}


Vue.http.headers.common['X-CSRF-TOKEN'] = Laravel.csrftoken;
Vue.mixin({
    methods: {
        formatCurr: function(value) {
            let val = (value/1).toFixed(2).replace('.', ',')
            return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
        },
    }
});
window.routerIsReady = false;
const app = new Vue({
    el: '#app',
    components:{
        Valas,
        Mitra,
        Penukaran,
        Ppsv,
        Approvalitem,
        Approval,
        Btupsvform,
        Bbsv,
        // Uploadkuitansi,
        //BbsvForm,
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

