import Vue from 'vue'
import router from './router'
import App from './views/App'
import VueResource from "vue-resource"
import BootstrapVue from 'bootstrap-vue'
window.Vue = Vue;
Vue.use(BootstrapVue)
// Vue.use(Vuetify)

Vue.use(VueResource);
// Vue.use(BootstrapVue)
Vue.http.options.credentials = true;

Vue.http.interceptors.push((request, next) => {
    request.headers.set('Authorization', 'Bearer '+ localStorage.getItem('token'))
    request.headers.set('Accept', 'application/json')
    request.headers.set('X-CSRF-TOKEN', 'TOKEN')
    request.headers.set('Content-Type', 'application/json;charset=UTF-8');
    request.headers.set('Access-Control-Allow-Origin', '*');
    next();
});

const app = new Vue({
    el: '#app',
    components: { App },
    router,
});