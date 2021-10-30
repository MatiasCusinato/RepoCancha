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
        </div>
</template>

<script>
import apiRest from "../mixins/apiRest.vue";
//import axios from "axios";

export default {

name: 'Registro',
        mixins:[apiRest],
        
        data() {
                return {
                        datosRegistroUser: {
                                nombre: "",
                                apellido: "",
                                email: "",
                                telefono: "",
                                password: "",
                                club_configuracion_id: "",
                        },
                        
                        alertaRegistrado: [],
                };
        },

        methods: {
                registrarUsuario() {
                        if(!this.validarCampos()){
                                this.InsertarDatos("registro", this.datosRegistroUser)
                                        .then((res) => {
                                                //console.log(res)

                                                if (res.msj == "Error") {
                                                        this.$swal({
                                                                title: 'Error!',
                                                                text: ''+res.razon,
                                                                icon: 'error',
                                                                confirmButtonText: 'Ok',
                                                                timer: 2500
                                                        })
                                                } else {
                                                        this.$router.push("/login");
                                                }

                                        })
                                        .catch((err) => console.log("Error fetch:", err));
                        } else {
                                this.$swal({
                                        title: '¡Error!',
                                        text: 'Los siguientes campos estan vacios: '+ this.alertaRegistrado,
                                        icon: 'warning',
                                        confirmButtonText: 'Ok',
                                        timer: 2500
                                })
                        }    

                },

                validarCampos(){
                        this.alertaRegistrado= [];
                        for (let key in this.datosRegistroUser) {
                                if(this.datosRegistroUser[key] == ""){
                                        this.alertaRegistrado.push(key.charAt(0).toUpperCase()+ key.slice(1))
                                }
                        }

                        if(this.alertaRegistrado.length > 0){
                                return true
                        } else {
                                return false
                        }
                },
        },
};
</script>