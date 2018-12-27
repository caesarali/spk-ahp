// Vendor
require('./bootstrap');
window.Vue = require('vue');
axios.defaults.baseURL = '/api';

// Examples
// Vue.component('example-component', require('./components/ExampleComponent.vue'));
// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => {
//     return Vue.component(_.last(key.split('/')).split('.')[0], files(key))
// })

// Third Party
import { Form, HasError, AlertError } from 'vform';
window.Form = Form;
Vue.component(HasError.name, HasError);
Vue.component(AlertError.name, AlertError);
import swal from 'sweetalert2';
window.swal = swal;
const toast = swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
});
window.toast = toast;


// App
import router from './routes';
import Confirm from './commons/Confirm';
Vue.prototype.$confirm = new Confirm;

// Global Components
Vue.component('btn-default', require('./components/ui/buttons/BtnDefault'));
Vue.component('btn-fly', require('./components/ui/buttons/BtnFly'));
Vue.component('link-back', require('./components/ui/buttons/LinkBack'));
Vue.component('row-empty', require('./components/ui/table/RowEmpty'));
Vue.component('maintenance', require('./components/MaintenanceComponent'));
Vue.component('chart-bar', require('./components/ui/chart/BarChart'));

const app = new Vue({
    el: '#app',
    router
});
