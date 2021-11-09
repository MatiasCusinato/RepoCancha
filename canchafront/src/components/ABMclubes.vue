<template>
    <div>
        <hr>
            <form>
                <div class="contenedor" v-if="accion=='Crear' || accion=='Editar'">
                    <div :class="this.accion=='Crear' ? 'VentanaModalCrear' : 'VentanaModalEditar'">
                        <div class="cabecera tituloventana">
                        <button class="cierre btn btn-danger" @click="Cancelar()"><font color="#ff0000"><i class="bi bi-x-circle-fill"></i></font></button>
                        <p>{{accion}} Clubes</p>
                        </div>
                        <div class="contenido">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="" class="form-label campo">
                                        <i class="bi bi-person"> Nombre: </i>
                                    </label>

                                    <input type="text" class="form-control form-control-sm"
                                            v-model="datosClubes.nombre_club" maxlength="30">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="" class="form-label campo" >
                                        <i class="bi bi-person"> Razon Social: </i>
                                    </label>

                                    <input type="text" class="form-control form-control-sm"  
                                            v-model="datosClubes.razon_social">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="" class="form-label campo">
                                        <i class="bi bi-telephone"> Ubicacion: </i>
                                    </label>

                                    <input type="text" v-model="datosClubes.ubicacion" 
                                            class="form-control form-control-sm">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="" class="form-label campo">
                                        <i class="bi bi-calendar2-date"> Contacto: </i>
                                    </label>

                                    <input type="text" v-model="datosClubes.contacto" placeholder="3446 ..."
                                            class="form-control form-control-sm" >
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="" class="form-label campo">
                                        <i class="bi bi-calendar2-date"> CUIT: </i>
                                    </label>

                                    <input type="text" v-model="datosClubes.cuit"
                                            class="form-control form-control-sm" >
                                </div>
                            </div>

                            <button class="btn btn-primary divBotones" @click="Aceptar()">
                                <i class="bi bi-check2-circle"> Guardar </i>
                            </button>

                            <button class="btn btn-danger divBotones" @click="Cancelar()">
                                <i class="bi bi-x-circle-fill"> Cancelar </i>
                            </button>
                        </div>
                    </div>
                </div>


                <div v-if="accion=='Borrar'" class="contenedor">
                    <div class="VentanaModalBorrar">
                        <div class="alert alert-danger" role="alert" v-if="accion === 'Borrar'">
                            <p>{{accion}} clubes</p>
                            <hr>
                            <table class="table-bordered light-blue darken-2">
                                <thead>
                                    <tr class="bg-primary text-light">
                                        <th scope="col">ID</th>
                                        <th scope="col">Nombre</th>
                                        <th scope="col">Ubicacion</th>
                                        <th scope="col">Contacto</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th scope="row">{{datosClubes.id}}</th>
                                        <td> {{datosClubes.nombre_club}} </td>
                                        <td> {{datosClubes.ubicacion}} </td>
                                        <td> {{datosClubes.contacto}} </td>
                                    </tr>
                                </tbody>
                            </table>

                            <strong>Atención!</strong> ¿Esta seguro de borrar este CLUB?.
                            <div >
                                <button @click="Aceptar()" class="btn btn-danger btn-sm divBotones">Si, borrar club</button>
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
            //accion: 'Editar',
            //id: 0,

            datosClubes: {
                nombre_club: '',
                razon_social:"",
                ubicacion: "",
                contacto: "",
                ultimo_grupo: "",
                cuit: "",
                token: this.$store.state.vToken,
            },

            alertaFormulario: [],
        }
    },

    created() {
        if (this.accion != 'Crear') {
            this.ObtenerDatos(`clubes/show/${this.id}`)
                .then (res => {
                    this.datosClubes = res.club[0]
                    //this.datosClubes['token']= this.$store.state.vToken;
                })

        }
    },

    methods: {
        Aceptar() {
            if(!this.validarCampos(this.datosClubes)){
                
                if (this.accion == 'Crear') {
                    //console.log(JSON.stringify(this.datosClubes))

                    this.InsertarDatos('clubes/guardar', this.datosClubes)
                        .then(res => {
                            if(res.msj=="Error"){
                                this.$swal({
                                    title: '¡Error!',
                                    text: ''+res.razon,
                                    icon: 'error',
                                    confirmButtonText: 'Ok',
                                    position: 'top-end',
                                    backdrop:false,
                                })
                            } else {
                                this.$swal({
                                    title: `${res.msj}`,
                                    icon: 'success',
                                    confirmButtonText: 'Ok',
                                    timer: 2500 ,
                                    position: 'top-end',
                                    backdrop:false,                          
                                })

                                this.$emit('SalirDeABMclubes', true)
                            }
                        })
                }

                if (this.accion == 'Editar') {
                    //console.log(JSON.stringify(this.datosClubes))
                    this.EditarDatos(`clubes/editar`, this.id, this.datosClubes)
                        .then(res => {
                            //this.datosClubes = res
                            console.log(res)
                            if(res.Peticion=='Error'){
                                this.$swal({
                                    title: `${res.msj}`,
                                    text: `${res.razon}`,
                                    icon: 'error',
                                    confirmButtonText: 'Ok',
                                })
                            } else {
                                this.$swal({
                                    title: `${res.msj}`,
                                    icon: 'success',
                                    confirmButtonText: 'Ok',
                                    timer: 2500,
                                    position: 'top-end',
                                    backdrop: false,
                                })

                                this.$emit('SalirDeABMclubes', true)
                            }
                        })
                }
                
                if (this.accion == 'Borrar') {
                    this.EliminarDatos(`clubes/eliminar`, this.id, this.datosClubes)
                        .then(res => {
                            //this.datosClubes = res
                            if (res.msj == 'Error') {
                                this.$swal({
                                    title: `¡${res.msj}!`,
                                    text: `Razon : ${res.razon}`,
                                    icon: 'error',
                                    confirmButtonText: 'Ok',
                                })
                            } else {
                                this.$swal({
                                    title: `¡Club eliminado exitosamente!`,
                                    icon: 'success',
                                    confirmButtonText: 'Ok',
                                    timer: 2500,
                                    position: 'top-end',
                                    backdrop: false,
                                })

                                this.$emit('SalirDeABMclubes', true)
                            }
                        })
                }
            } else {
                this.$swal({
                    title: '¡Formulario incompleto!',
                    text: 'Los siguientes campos estan vacios: '+ this.alertaFormulario,
                    icon: 'warning',
                    confirmButtonText: 'Ok',
                })
            }
            
        },
        
        Cancelar() {
            this.$emit("SalirDeABMclubes", false)
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

p{
    font-size: 25px;
    font-family: "Times New Roman", Times, serif;
} 

.pBorrar{
    font: 20px;
    font-weight: bold;
    color: black;
}

.divBotones{
    margin: 10px 25px 0px;
    position: relative;
    left: 20px;
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