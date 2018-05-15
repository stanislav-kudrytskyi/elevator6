import Vue from 'vue'
import Vuex from 'vuex'
import elevator from './modules/elevator'
//import products from './modules/products'
import createLogger from 'vuex/dist/logger'

Vue.use(Vuex);

const debug = process.env.NODE_ENV !== 'production';

export default new Vuex.Store({
  modules: {
    elevator
  },
  strict: debug,
  //plugins: debug ? [createLogger()] : []
  plugins: [createLogger()]
})