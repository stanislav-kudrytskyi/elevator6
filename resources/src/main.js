// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import VueResource from 'vue-resource';
//import Vuex from 'vuex'
import App from './App'
import router from './router/index'
import store from './store/index'

Vue.use(VueResource);

Vue.config.productionTip = false;

Vue.http.options.root = process.env.API_BASE_URL;
//Vue.use(Vuex);

/* eslint-disable no-new */
new Vue({
  el: '#app',
  store,
  router,
  components: { App },
  template: '<App/>'
});
