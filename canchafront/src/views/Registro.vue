<template>
        <div class="divContainer">
                <form @submit.prevent="registrarUsuario">
                        <h1 class="h3 mb-3 fw-normal">Registro de usuario</h1>

                        <h5>Nombre </h5>
                        <input v-model="datosRegistroUser.nombre" class="form-control"
                                placeholder="Nombre" /><br>

                        <h5>Apellido</h5>
                        <input v-model="datosRegistroUser.apellido" class="form-control"
                                placeholder="Apellido" /><br>

                        <h5>Telefono</h5>
                        <input v-model="datosRegistroUser.telefono" type="telefono" 
                                class="form-control" placeholder="Telefono" /><br>

                        <h5>Email</h5>
                        <input v-model="datosRegistroUser.email" type="email" 
                                class="form-control" placeholder="Email" /><br>

                        <h5>Password</h5>
                        <input v-model="datosRegistroUser.password" type="password" minlength="6"
                                class="form-control"  placeholder="Password" /><br>

                        <h5>Rol</h5>
                        <select name="intervalo_hora" v-model="datosRegistroUser.rol_id" 
                              class="form-control form-select inputChico" aria-label=".form-select-sm example">
                              
                              <!-- <option value="1">
                                    Programador
                              </option> -->

                              <option value="2">
                                    Encargado de club(admin)
                              </option>
                        </select><br>

                        <h5>Club</h5>
                        <select name="intervalo_hora" v-model="datosRegistroUser.club_configuracion_id" 
                                class="form-select inputChico" aria-label=".form-select-sm example">
                                
                                <option v-for="(club, $id) in clubes" 
                                        :key="$id" :value="club.id">
                                        {{club.id}}|{{club.nombre_club}}
                                </option>
                        </select> <br>

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
                        rol_id: "2",
                },
                
                alertaRegistrado: [],
                clubes: [],
            };
        },

        created(){
                this.traerClub();
        },

        methods: {
                traerClub(){
                        this.ObtenerDatos(`clubes`)
                                .then(res => {
                                if(res.msj=="Error"){
                                        this.$swal({
                                        title: 'Error, en la peticion de conseguir clubes',
                                        text: `${res.razon}`,
                                        icon: 'error',
                                        confirmButtonText: 'Ok',
                                        timer: 2500
                                        })
                                } else {
                                        this.clubes= res.clubes.data
                                }

                        })
                },

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
                                                      })
                                                } else {
                                                      //this.$router.push("/login");
                                                      this.$swal({
                                                            title: ''+res.msj,
                                                            icon: 'success',
                                                            confirmButtonText: 'Ok',
                                                      })

                                                      this.$emit('SalirDeABMclubes', true)
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

<style scoped>
.divContainer{
        border: 3px solid black ;
        border-radius: 5%;
        padding: 5%;
        background-color: rgb(216, 213, 213);
}
</style>