import Vue from 'vue'
import VueRouter from 'vue-router'
import Home from '../views/Home.vue'
import INFOclientes from '@/components/INFOclientes.vue'
import INFOturnos from '@/components/INFOturnos.vue'
import INFOcanchas from '@/components/INFOcanchas.vue'
import Login from '@/views/Login.vue'
import Registro from '@/views/Registro.vue'



Vue.use(VueRouter)

const routes = [
  {
    path: '/',
    name: 'Home',
    component: Home,
  },

  {
    path: '/INFOclientes',
    name: 'INFOclientes',
    component: INFOclientes,
  },

  {
    path: '/INFOturnos',
    name: 'INFOturnos',
    component: INFOturnos,
  },

  {
    path: '/INFOcanchas',
    name: 'INFOcanchas',
    component: INFOcanchas,
  },

  {
    path: '/login',
    name: 'Login',
    component: Login,
  },

  {
    path: '/registro',
    name: 'Registro',
    component: Registro,
  },

  {
    path: '/about',
    name: 'About',
    // route level code-splitting
    // this generates a separate chunk (about.[hash].js) for this route
    // which is lazy-loaded when the route is visited.
    component: () => import(/* webpackChunkName: "about" */ '../views/About.vue')
  }
]

const router = new VueRouter({
  routes
})

export default router
