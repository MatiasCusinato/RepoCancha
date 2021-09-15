<template>
        <div>
                <form @submit.prevent="registrarUsuario">
                        <h1 class="h3 mb-3 fw-normal">Por favor, registrese</h1>

                        <input v-model="datosRegistroUser.nombre" class="form-control"
                                placeholder="Nombre" />

                        <input v-model="datosRegistroUser.apellido" class="form-control"
                                placeholder="Apellido" />

                        <input v-model="datosRegistroUser.email" type="email" 
                                class="form-control" placeholder="Email" />

                        <input v-model="datosRegistroUser.telefono" type="telefono" 
                                class="form-control" placeholder="Telefono" />

                        <input v-model="datosRegistroUser.password" type="password" minlength="6"
                                class="form-control"  placeholder="Password" />

                        <input v-model="datosRegistroUser.club_configuracion_id"
                                class="form-control" placeholder="ID club" />
                        
                        <br> 

                        <button class="w-100 btn btn-lg btn-primary" type="registrarUsuario">
                                Registrar
                        </button>
                </form>

                <br>

                <div class="alert alert-danger" role="alert"
                        v-if="this.alertaRegistrado == true">
                        ¡Ese usuario ya se encuentra registrado!
                </div>
        </div>
</template>

<script>
import apiRest from "../mixins/apiRest.vue";
//import axios from "axios";

export default {
    name: "Registro",

    mixins: [apiRest],

    data() {
        return {
                datosRegistroUser: {
                        nombre: "usuario",
                        apellido: "falso",
                        email: "usuario@gmail.com",
                        telefono: "12313212",
                        password: "usuario",
                        club_configuracion_id: "2",
                },
                
                alertaRegistrado: false,
        };
    },

    methods: {
        registrarUsuario() {
                for (let key in this.datosRegistroUser) {
                        if(this.datosRegistroUser[key] == ""){
                                console.log("Uno de los campos estan vacios")
                        }
                        /* console.log("Key: " + key);
                        console.log("Value: " + this.datosRegistroUser[key]); */
                }

            /* this.InsertarDatos("registro", this.datosRegistroUser)
                .then((res) => {
                        console.log(res)

                        if (res.msj == "Error") {
                                this.alertaRegistrado = true
                        } else {
                                this.$router.push("/login");
                        }
                })
                .catch((err) => console.log("Error fetch:", err)); */
        },

        validarCampos(){
                for (var key in this.datosRegistroUser) {
                        console.log("Key: " + key);
                        console.log("Value: " + this.datosRegistroUser[key]);
                }
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
                                this.$router.push('/login')
                        });
                },  */
    },
};
</script>