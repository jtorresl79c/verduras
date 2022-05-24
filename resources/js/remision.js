require('./bootstrap');
require('./vue-asset');
window.Vue = require('vue').default;


Vue.component('create-remision', require('./components/remision/Createremision.vue').default);
Vue.component('view-remision', require('./components/remision/ViewRemision.vue').default);

var app = new Vue({

    el: '#app',
});
