<template>
        <div>
                <form @submit.prevent="registrarUsuario">
                        <h1 class="h3 mb-3 fw-normal">Por favor, registrese</h1>

                        <input v-model="datosRegistroUser.nombre" class="form-control"
                                placeholder="Nombre" required />

                        <input v-model="datosRegistroUser.apellido" class="form-control"
                                placeholder="Apellido" required />

                        <input v-model="datosRegistroUser.email" type="email" 
                                class="form-control" placeholder="Email" required />

                        <input v-model="datosRegistroUser.telefono" type="telefono" 
                                class="form-control" placeholder="Telefono" required />

                        <input v-model="datosRegistroUser.password" type="password" minlength="6"
                                class="form-control"  placeholder="Password" required />

                        <input v-model="datosRegistroUser.club_configuracion_id"
                                class="form-control" placeholder="ID club" required />
                        
                        <br> 

                        <button class="w-100 btn btn-lg btn-primary" type="registrarUsuario">
                                Registrar
                        </button>
                </form>

                <br>

                <div class="alert alert-danger" role="alert"
                        v-if="this.alertaRegistrado == true">
                        ¡El usuario ya se encuentra logueado!
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
            this.InsertarDatos("registro", this.datosRegistroUser)
                .then((res) => {
                    if (res.msj == "Error") {
                        this.alertaRegistrado = true
                    } else {
                        this.$router.push("/login");
                    }
                })
                .catch((err) => console.log("Error fetch:", err));
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