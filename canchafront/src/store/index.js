import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    vClub:  localStorage.getItem('club') || "null",
    vToken:  localStorage.getItem('laravelToken') || "null",
    jsonToken: {
      "token": localStorage.getItem('laravelToken')
    }
  },

  mutations: {
    guardarDatosUsuario(state, objDatos){
      let tokenRaw= atob(objDatos.token.slice(1,-1));//descifro el token en base64 a un string
      console.log(tokenRaw)
      let objToken= JSON.parse(tokenRaw); //lo transformo en un objeto javascript
      console.log(objToken)
      
      localStorage.setItem('laravelToken', objDatos.token.slice(1,-1));
      localStorage.setItem('club', objToken.club);

      state.vToken= objDatos.token.slice(1,-1);
      state.vClub= objToken.club;

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
  },

  actions: {
  },
  modules: {
  }
});