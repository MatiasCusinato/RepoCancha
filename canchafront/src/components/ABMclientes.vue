<template>
    <div>
        <hr>
            <form>
                <div class="contenedor" v-if="accion=='Crear' || accion=='Editar'">
                    <div :class="this.accion=='Crear' ? 'VentanaModalCrear' : 'VentanaModalEditar'">
                        <div class="cabecera tituloventana">
                        <button class="cierre btn btn-danger" @click="Cancelar()"><font color="#ff0000"><i class="bi bi-x-circle-fill"></i></font></button>
                        <p>{{accion}} Clientes</p>
                        </div>
                        <div class="contenido">
                            <div class="mb-3">
                                <label for="" class="form-label campo"><i class="bi bi-person"> Nombre: </i></label>
                                <input type="text" class="form-control form-control-sm" v-model="datosClientes.nombre">
                            </div>

                            <div class="mb-3">
                                <label for="" class="form-label campo" ><i class="bi bi-person"> Apellido: </i></label>
                                <input type="text" class="form-control form-control-sm" v-model="datosClientes.apellido">
                            </div>

                            <div class="mb-3">
                                <label for="" class="form-label campo"><i class="bi bi-telephone"> Telefono: </i></label>
                                <input type="text" class="form-control form-control-sm" v-model="datosClientes.telefono">
                            </div>

                            <div class="mb-3">
                                <label for="" class="form-label campo"><i class="bi bi-calendar2-date"> Edad: </i></label>
                                <input type="text" class="form-control form-control-sm" v-model="datosClientes.edad">
                            </div>

                            <div class="mb-3">
                                <label for="" class="form-label campo"><i class="bi bi-envelope"> Email: </i></label>
                                <input type="text" class="form-control form-control-sm" v-model="datosClientes.email">
                            </div>
                            <button class="btn btn-primary divBotones" @click="Aceptar()"><i class="bi bi-check2-circle"> Guardar </i></button>
                            <button class="btn btn-danger divBotones" @click="Cancelar()"><i class="bi bi-x-circle-fill"> Cancelar </i></button>
                        </div>
                    </div>
                </div>


                <div v-if="accion=='Borrar'" class="contenedor">
                    <div class="VentanaModalBorrar">
                        <div class="alert alert-danger" role="alert" v-if="accion === 'Borrar'">
                            <p>{{accion}} Clientes</p>
                            <hr>
                            <table class="table-bordered light-blue darken-2">
                                <thead>
                                    <tr class="bg-primary text-light">
                                        <th scope="col">ID</th>
                                        <th scope="col">Nombre</th>
                                        <th scope="col">Apellido</th>
                                        <th scope="col">Telefono</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th scope="row">{{datosClientes.id}}</th>
                                        <td> {{datosClientes.nombre}} </td>
                                        <td> {{datosClientes.apellido}} </td>
                                        <td> {{datosClientes.telefono}} </td>
                                    </tr>
                                </tbody>
                            </table>

                            <strong>Atención!</strong> ¿Esta seguro de borrar este CLIENTE?.
                            <div >
                                <button @click="Aceptar()" class="btn btn-danger btn-sm divBotones">Si, borrar cliente</button>
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
            datosClientes: {
                //id:0,
                nombre: '',
                apellido:"",
                edad: "",
                telefono: "",
                email: "",
                club_configuracion_id: localStorage.getItem('club'),
            },

            alertaFormulario: [],
        }
    },

    created() {
        console.log("evento created")
        if (this.accion != 'Crear') {
            this.ObtenerDatos(`clientes/${this.datosClientes.club_configuracion_id}/show/${this.id}`)
                .then (res => {
                    this.datosClientes = res
                })

        }
    },

    methods: {
        Aceptar() {
            if(!this.validarCampos(this.datosClientes)){
                
                if (this.accion == 'Crear') {
                    console.log(JSON.stringify(this.datosClientes))

                    this.InsertarDatos ('clientes/guardar', this.datosClientes)
                        .then(res => {
                            if(res.msj=="Error"){
                                this.$swal({
                                    title: '¡Error!',
                                    text: ''+res.razon,
                                    icon: 'error',
                                    confirmButtonText: 'Ok'
                                })

                                this.$emit('SalirDeABMclientes', true)
                            } else {
                                this.$swal({
                                    title: '¡Cliente creado!',
                                    icon: 'success',
                                    confirmButtonText: 'Ok'
                                })

                                this.$emit('SalirDeABMclientes', true)  
                            }
                        })
                }

                if (this.accion == 'Editar') {
                    console.log(JSON.stringify(this.datosClientes))
                    this.EditarDatos(`clientes/editar`, this.id, this.datosClientes)
                        .then(res => {
                            //this.datosClientes = res
                            if(res.msj=='Error'){
                                this.$swal({
                                        title: `${res.msj}`,
                                        text: `${res.razon}`,
                                        icon: 'error',
                                        confirmButtonText: 'Ok'
                                    })
                            } else {
                                this.$swal({
                                        title: `${res.msj}`,
                                        text: `${res.razon}`,
                                        icon: 'success',
                                        confirmButtonText: 'Ok'
                                    })
                            }

                            this.$emit('SalirDeABMclientes', true)
                        })
                }
                
                if (this.accion == 'Borrar') {
                    let club = localStorage.getItem('club')
                    this.EliminarDatos(`clientes/eliminar/${club}`, this.id)
                        .then(res => {
                            //this.datosClientes = res
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
                                    text: `El cliente ha sido eliminado`,
                                    icon: 'success',
                                    confirmButtonText: 'Ok'
                                })
                            }
                            
                            this.$emit('SalirDeABMclientes', true)
                        })
                }
            } else {
                this.$swal({
                    title: '¡Formulario incompleto!',
                    text: 'Los siguientes campos estan vacios: '+ this.alertaFormulario,
                    icon: 'warning',
                    confirmButtonText: 'Ok'
                })
            }
            
        },
        
        Cancelar() {
            this.$emit("SalirDeABMclientes", false)
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