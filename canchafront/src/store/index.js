import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    vToken: "",
  },

  mutations: {
    guardarToken(state, token){
      localStorage.setItem('laravelToken', token);

      state.vToken= token;
      console.log(state.vToken)
    },
    
    borrarToken(state){
      console.log("borrando token del LS")
      localStorage.removeItem('laravelToken');

      state.vToken= "";
    }
  },
  actions: {
  },
  modules: {
  }
});