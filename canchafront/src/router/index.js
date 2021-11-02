import Vue from 'vue'
import VueRouter from 'vue-router'
import Home from '../views/Home.vue'
import INFOclientes from '@/views/INFOclientes.vue'
import INFOturnosADMIN from '@/views/INFOturnosADMIN.vue'
import INFOturnosDISPONIBLES from '@/views/INFOturnosDISPONIBLES.vue'
import INFOcanchas from '@/views/INFOcanchas.vue'
import Login from '@/views/Login.vue'
import Registro from '@/views/Registro.vue'
import Soporte from '@/views/Soporte.vue'



Vue.use(VueRouter)

const routes = [
  {
    path: '/',
    name: 'Home',
    component: Home,
    //meta: { requiresAuth: true }
  },

  {
    path: '/INFOclientes',
    name: 'INFOclientes',
    component: INFOclientes,
    meta: { requiresAuth: true }
  },

  {
    path: '/INFOturnosADMIN',
    name: 'INFOturnosADMIN',
    component: INFOturnosADMIN,
    meta: { requiresAuth: true }
  },

  {
    path: '/INFOturnosDISPONIBLES/club/:club',
    name: 'INFOturnosDISPONIBLES',
    component: INFOturnosDISPONIBLES,
    /* meta: { requiresAuth: true } */ 
  },

  {
    path: '/INFOcanchas',
    name: 'INFOcanchas',
    component: INFOcanchas,
    meta: { requiresAuth: true }
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
    path: '/soporte',
    name: 'Soporte',
    component: Soporte,
  },

  {
    path: '/about',
    name: 'About',
    // route level code-splitting
    // this generates a separate chunk (about.[hash].js) for this route
    // which is lazy-loaded when the route is visited.
    component: () => import(/* webpackChunkName: "about" */ '../views/About.vue'),
    meta: { requiresAuth: true }
  }
]

const router = new VueRouter({
  routes
})

//Esta funcion nos permite agregar logica y en este caso impedir de que se pueda ingresar a ciertas vistas si no hay un permiso determinado, to: a la ruta que queremos ir, from de la ruta que venimos y next es la funcion que se va a ejecutar despues de que hagamos las operaciones respectivas//
router.beforeEach((to, from, next) => {
  console.log("local",localStorage.getItem('laravelToken'))
  if (to.matched.some(record => record.meta.requiresAuth)) {
    if (localStorage.getItem('laravelToken') != null) {
      next()
    } else {
      next("/login")
    }
  } else {
    next();
  }
});

export default router
