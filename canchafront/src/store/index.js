import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    vClub: localStorage.getItem('club') || "null",
    vToken: localStorage.getItem('laravelToken') || "null",
    vRol: localStorage.getItem('rol') || "null",
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
      localStorage.setItem('rol', objToken.rol);

      state.vToken= objDatos.token.slice(1,-1);
      state.vClub= objToken.club;
      state.vRol= objToken.rol;

      console.log(state.vToken)
      console.log(state.vClub)
    },
    
    borrarToken(state){
      console.log("borrando datos usuario del LS")
      localStorage.removeItem('laravelToken');
      localStorage.removeItem('club');
      localStorage.removeItem('rol');

      state.vToken= "";
      state.vClub= "";
      state.vRol= "";
    },
  },

  actions: {
  },
  modules: {
  }
});