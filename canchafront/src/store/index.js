import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    vToken: "",
    vClub: "",
    loggedIn: false,
  },

  mutations: {
    guardarDatosUsuario(state, objDatos){
      localStorage.setItem('laravelToken', objDatos.token);
      localStorage.setItem('club', objDatos.numeroClub);

      state.vToken= objDatos.token;
      state.vClub= objDatos.numeroClub;
      console.log(state.vToken)
      console.log(state.vClub)
    },
    
    borrarToken(state){
      console.log("borrando datos usuario del LS")
      localStorage.removeItem('laravelToken');
      localStorage.removeItem('club');

      state.vToken= "";
      state.vClub= "";
    },

    loggedIn(state) {
      state.loggedIn = true
    },
  },

  actions: {
    mocklogin (context) {
      setTimeout(function() {
        context.commit('loggedIn')
      }, 1000)
    }
  },
  modules: {
  }
});