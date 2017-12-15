window.Vue = require('vue');

Vue.use(require('vue-resource'));
Vue.http.headers.common['X-CSRF-TOKEN'] = Laravel.csrftoken;
import Modal from './components/Modal.vue';
const app2 = new Vue({
    el: '#app',
    components:{
        Modal
    }
});