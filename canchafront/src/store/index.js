import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    vToken: "",
    vClub: "",
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
    }
  },

  actions: {
  },
  modules: {
  }
});