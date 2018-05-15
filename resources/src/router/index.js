import Vue from 'vue'
import Router from 'vue-router'
import HelloWorld from '../components/HelloWorld'
import Elevator from '../components/Elevator'
import NotFound from '../components/NotFound'

Vue.use(Router);

export default new Router({
  mode: 'history',
  routes: [
    {path: '*', component: NotFound},
    {
      path: '/',
      name: 'HelloWorld',
      component: HelloWorld
    },
    {
      path: '/elevator',
      name: 'Elevator',
      component: Elevator
    }
  ]
})
