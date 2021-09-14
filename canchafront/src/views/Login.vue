<template>
  <form @submit.prevent="logearUsuario">
    <h1 class="h3 mb-3 fw-normal">Please sign in</h1>

    <input v-model="datosLoginUser.email" type="email" class="form-control" placeholder="Email" required>

    <input v-model="datosLoginUser.password" type="password" class="form-control" placeholder="Password" required>

    <button class="w-100 btn btn-lg btn-primary" type="logearUsuario">Sign in</button>
  </form>
</template>

<script>
import apiRest from '../mixins/apiRest.vue'
//import axios from "axios";
export default {
    name: 'Login',
    mixins:[apiRest],
    
    data(){
        return {
            datosLoginUser: {
              email: "usuario@gmail.com",
              password: "usuario",
            },
        }
    },
    methods: {
      logearUsuario(){
        this.InsertarDatos("login", this.datosLoginUser)
          .then(res => {
            console.log(res)
            let token = JSON.stringify(res.user.token_actual);
            let numeroClub = JSON.stringify(res.user.club_configuracion_id)
            this.$store.commit("guardarDatosUsuario", {
              token,
              numeroClub,
            });
          })
        this.$router.push('/') 
      },
      /* async logearUsuario(){
        const url = 'http://localhost:8000/api/login';
        axios.post(url, this.datosLoginUser, {
          withCredentials: true,
          headers: {
                  Accept: 'application/json',
                  'Content-Type': 'application/json',
          },
        }).then(res =>{
          console.log(res.data)
          let tkn = JSON.stringify(res.data.user.token_actual);
          this.$store.commit("guardarToken", tkn);
          this.$router.push('/') 
        });
      }, */
    },
}
</script>