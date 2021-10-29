<template>
    <div>
        <hr>
            <form>
                <div class="contenedor" v-if="accion=='Crear' || accion=='Editar'">
                    <div :class="this.accion=='Crear' ? 'VentanaModalCrear' : 'VentanaModalEditar'">
                        <div class="cabecera tituloventana">
                        <button class="cierre btn btn-danger" @click="Cancelar()"><font color="#ff0000"><i class="bi bi-x-circle-fill"></i></font></button>
                        <p>{{accion}} Canchas</p>
                        </div>
                        <div class="contenido">
                            <div class="mb-3">
                                <label for="" class="form-label campo"><i class="bi bi-flag"> Deporte: </i></label>
                                <input type="text" class="form-control form-control-sm" v-model="datosCancha.deporte" maxlength="30">
                            </div>
                            <button class="btn btn-primary divBotones" @click="Aceptar()"><i class="bi bi-check2-circle"> Guardar </i></button>
                            <button class="btn btn-danger divBotones" @click="Cancelar()"><i class="bi bi-x-circle-fill"> Cancelar </i></button>
                        </div>
                    </div>
                </div>


                <div v-if="accion=='Borrar'" class="contenedor">
                    <div class="VentanaModalBorrar">
                        <div class="alert alert-danger" role="alert" v-if="accion === 'Borrar'">
                            <p>{{accion}} Canchas</p>
                            <hr>
                            <table class="table-bordered light-blue darken-2">
                                <thead>
                                    <tr class="bg-primary text-light">
                                        <th scope="col">ID</th>
                                        <th scope="col">Club</th>
                                        <th scope="col">Deporte</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th scope="row">{{datosCancha.id}}</th>
                                        <td> {{datosCancha.club_configuracion_id}} </td>
                                        <td> {{datosCancha.deporte}} </td>
                                    </tr>
                                </tbody>
                            </table>

                            <strong><i class="bi bi-exclamation-triangle"> Atención! </i></strong> ¿Esta seguro de borrar esta CANCHA?.
                            <div >
                                <button @click="Aceptar()" class="btn btn-danger btn-sm divBotones">Si, borrar cancha</button>
                                <button @click="Cancelar()" class="btn btn-primary btn-sm divBotones">No, volver</button> 
                            </div>
                        </div>
                    </div>
                </div>
                
            </form>
    </div>
</template>

<script>
import apiRest from "@/mixins/apiRest.vue"
export default {
    props: ['accion','id'],

    mixins: [apiRest],

    data() {
        return {
            datosCancha: {
                //id: "0",
                deporte: "",
                club_configuracion_id: this.$store.state.vClub,
                token: this.$store.state.vToken,
            }
        }
    },

    created() {
        console.log("evento created")
        if (this.accion != 'Crear') {
            this.ObtenerDatos(`canchas/${this.$store.state.vClub}/show/${this.id}`)
                .then (res => {
                    this.datosCancha = res
                    this.datosCancha['token']= this.$store.state.vToken;
            })
        }
    },

    methods: {
        Aceptar() {
            if(!this.validarCampos(this.datosCancha)){
                if (this.accion == 'Crear') {
                    /* let club=localStorage.getItem('club')
                    this.datosCancha.club_configuracion_id= club; */
                    console.log(JSON.stringify(this.datosCancha))

                    this.InsertarDatos ('canchas/guardar', this.datosCancha)
                        .then(res => {
                            if (res.msj == 'Error') {
                                this.$swal({
                                    title: `¡${res.msj}!`,
                                    text: `Razon : ${res.razon}`,
                                    icon: 'warning',
                                    confirmButtonText: 'Ok'
                                })
                            } else {
                                this.$swal({
                                    title: `¡${res.msj}!`,
                                    icon: 'success',
                                    confirmButtonText: 'Ok'
                                })
                            }

                            setInterval(() => {
                                this.$emit('SalirDeABMcanchas', true)
                                this.$swal.close()
                            }, 2500);
                        })
                }

                if (this.accion == 'Editar') {
                    console.log(JSON.stringify(this.datosCancha))
                    this.EditarDatos (`canchas/editar/${this.$store.state.vClub}`, this.id, this.datosCancha)
                        .then(res => {
                            //this.datosCancha = res

                            if (res.msj == 'Error') {
                                this.$swal({
                                    title: `¡${res.msj}!`,
                                    text: `Razon : ${res.razon}`,
                                    icon: 'error',
                                    confirmButtonText: 'Ok'
                                })
                            } else {
                                this.$swal({
                                    title: `¡${res.msj}!`,
                                    text: `${res.razon}`,
                                    icon: 'success',
                                    confirmButtonText: 'Ok'
                                })
                            }

                            /* setInterval(() => {
                                this.$emit('SalirDeABMcanchas', true)
                                this.$swal.close()
                            }, 2500); */
                        })
                }

                if (this.accion == 'Borrar') {
                    this.EliminarDatos(`canchas/eliminar/${this.$store.state.vClub}`, this.id, this.datosCancha)
                        .then(res => {
                            //this.datosCancha = res
                            if (res.msj == 'Error') {
                                this.$swal({
                                    title: `¡${res.msj}!`,
                                    text: `Razon : ${res.razon}`,
                                    icon: 'error',
                                    confirmButtonText: 'Ok'
                                })
                            } else {
                                this.$swal({
                                    title: `¡Eliminacion exitosa!`,
                                    text: `La cancha ha sido eliminada`,
                                    icon: 'success',
                                    confirmButtonText: 'Ok'
                                })
                            }

                            /* setInterval(() => {
                                this.$emit('SalirDeABMcanchas', true)
                                this.$swal.close()
                            }, 2500); */
                        })
                }

                setInterval(() => {
                    this.$emit('SalirDeABMcanchas', true)
                    this.$swal.close()
                }, 2500);
            }else{
                this.$swal({
                    title: '¡Formulario incompleto!',
                    text: 'Los siguientes campos estan vacios: '+ this.alertaFormulario,
                    icon: 'warning',
                    confirmButtonText: 'Ok'
                })
            }
        },

        Cancelar() {
            this.$emit("SalirDeABMcanchas", false)
        },

        validarCampos(objFormulario){
                this.alertaFormulario= [];
                for (let key in objFormulario) {
                        if(objFormulario[key] == ""){
                                this.alertaFormulario.push(' '+key.charAt(0).toUpperCase()+ key.slice(1))
                        }
                }

                if(this.alertaFormulario.length > 0){
                    return true
                } else {
                    return false
                }
        },
    }
}
</script>

<style scoped>
.formABM {
    border: 2px solid rgb(116, 113, 113);
    border-collapse: collapse;
    padding: 15px 32px;
}
p {
    font-size: 30px;
    font-family: "Times New Roman", Times, serif;
} 
.divBotones{
    margin: 20px 10px;
    position: relative;
    left: 50px;
}
.contenedor{
	position: fixed;
	top:0;
	left:0;
	width: 100%;
	height: 100%;
	background: rgba(0,0,0,0.5);
}

.VentanaModalCrear {
    background-color: rgb(85, 84, 167);
    border-radius: 10px;
    padding: 28px;
    width: 400px;
    margin: 25px auto;
}

.VentanaModalEditar {
    background-color: rgb(84, 167, 128);
    border-radius: 10px;
    padding: 28px;
    width: 400px;
    margin: 25px auto;
}

table{
    background-color: whitesmoke;
    margin: 0px 40px 10px;
}

.VentanaModalBorrar {
    background-color: rgb(209, 113, 89);
    border-radius: 10px;
    padding: 25px;
    width: 400px;
    margin: 95px auto;
}

.cierre{
    background: white;
    float: right;
}

.tituloventana{
    text-align:center;
    color:white;
}

.campo{
	color: white;
}

.titulo{
	float:left;
	color: white;
}
</style>