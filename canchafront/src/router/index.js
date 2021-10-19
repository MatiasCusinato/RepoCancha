import Vue from 'vue'
import VueRouter from 'vue-router'
import Home from '../views/Home.vue'
import INFOclientes from '@/views/INFOclientes.vue'
import INFOturnosADMIN from '@/views/INFOturnosADMIN.vue'
import INFOturnosDISPONIBLES from '@/views/INFOturnosDISPONIBLES.vue'
import INFOcanchas from '@/views/INFOcanchas.vue'
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
    path: '/INFOturnosADMIN',
    name: 'INFOturnosADMIN',
    component: INFOturnosADMIN,
  },

  {
    path: '/INFOturnosDISPONIBLES/club/:club',
    name: 'INFOturnosDISPONIBLES',
    component: INFOturnosDISPONIBLES,
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
