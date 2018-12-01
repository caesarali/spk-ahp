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
// App
import router from './routes';

// Global Components
Vue.component('btn-default', require('./components/ui/buttons/BtnDefault'));
Vue.component('maintenance', require('./components/MaintenanceComponent'));

const app = new Vue({
    el: '#app',
    router
});
