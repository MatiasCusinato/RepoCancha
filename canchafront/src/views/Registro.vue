<template>
  <form @submit.prevent="registrarUsuario">
    <h1 class="h3 mb-3 fw-normal">Please register</h1>

    <input v-model="datosRegistroUser.nombre" 
            class="form-control" placeholder="Nombre" required>

    <input v-model="datosRegistroUser.apellido" 
            class="form-control" placeholder="Apellido" required>

    <input v-model="datosRegistroUser.email" type="email" 
            class="form-control" placeholder="Email" required>

    <input v-model="datosRegistroUser.telefono" type="telefono" 
            class="form-control" placeholder="Telefono" required>
    
    <input v-model="datosRegistroUser.password" type="password" 
            class="form-control" placeholder="Password" required>

    <input v-model="datosRegistroUser.club_configuracion_id" type="club_configuracion_id" 
            class="form-control" placeholder="club_configuracion_id" required>

    <button class="w-100 btn btn-lg btn-primary" type="registrarUsuario" > Submit
    </button>
  </form>
</template>

<script>
import apiRest from '../mixins/apiRest.vue'
//import axios from "axios";
export default {
name: 'Registro',
        mixins:[apiRest],
        data(){
                return {
                        datosRegistroUser: {
                        nombre: "usuario",
                        apellido: "falso",
                        email: "usuario@gmail.com",
                        telefono: "12313212",
                        password: "usuario",
                        token_actual: "null",
                        club_configuracion_id:"2",
                        },
                }
        },

        methods: {  
                registrarUsuario(){
                        this.InsertarDatos("registro", this.datosRegistroUser)
                                .then(res => {
                                console.log(res)
                                })
                        this.$router.push('/login') 
                }, 
                /* async registrarUsuario(){
                        const url = 'http://localhost:8000/api/registro';
                        axios.post(url, this.datosRegistroUser, {
                                withCredentials: true,
                                headers: {
                                        Accept: 'application/json',
                                        'Content-Type': 'application/json',
                                },
                        }).then(res =>{
                                console.log(res.data)
                                this.$router.push('/login') 
                        });
                }, */
        },
    
}
</script>