<template>
    <div>
        <hr>
            <form>
                <div class="contenedor" v-if="accion=='Crear' || accion=='Editar'">
                    <div class="VentanaModal" >
                        <div class="cabecera tituloventana">
                        <button class="cierre btn btn-primary" @click="Cancelar()"><font color="#35586F">X</font></button>
                        <p>{{accion}} Clientes</p>
                        </div>
                        <div class="contenido">
                            <div class="mb-3">
                                <label for="" class="form-label campo"> Nombre: </label>
                                <input type="text" class="form-control form-control-sm" v-model="datosClientes.nombre">
                            </div>

                            <div class="mb-3">
                                <label for="" class="form-label campo" > Apellido: </label>
                                <input type="text" class="form-control form-control-sm" v-model="datosClientes.apellido">
                            </div>

                            <div class="mb-3">
                                <label for="" class="form-label campo"> Telefono: </label>
                                <input type="text" class="form-control form-control-sm" v-model="datosClientes.telefono">
                            </div>

                            <div class="mb-3">
                                <label for="" class="form-label campo"> Edad: </label>
                                <input type="text" class="form-control form-control-sm" v-model="datosClientes.edad">
                            </div>

                            <div class="mb-3">
                                <label for="" class="form-label campo"> Email:</label>
                                <input type="text" class="form-control form-control-sm" v-model="datosClientes.email">
                            </div>
                            <button class="btn  btn-outline-primary" @click="Aceptar()">Ingresar Articulo</button>
                            <button class="btn btn-outline-danger" @click="Cancelar()">Cancelar</button>
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
                            <button @click="Aceptar()" class="btn btn-danger btn-sm">Si, borrar cliente</button>
                            <button @click="Cancelar()" class="btn btn-primary btn-sm">No, volver</button> 
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
                id:0,
                nombre: '',
                apellido:"",
                edad: "",
                telefono: "",
                email: "",
                club_configuracion_id: "",
            },

            modal: false,
        }
    },

    created() {
        console.log("evento created")
        if (this.accion != 'Crear') {
            let club=  localStorage.getItem('club')
            this.datosClientes.club_configuracion_id= club;
            this.ObtenerDatos(`clientes/${club}/${this.id}`)
                .then (res => {
                    this.datosClientes = res
                })
        }
    },

    methods: {
        Aceptar() {
            if (this.accion == 'Crear') {
                let club= localStorage.getItem('club')
                this.datosClientes.club_configuracion_id= club;
                console.log(JSON.stringify(this.datosClientes))

                this.InsertarDatos ('clientes/guardar', this.datosClientes)
                    .then(res => {
                        console.log(res)
                        if(res.msj == "Error"){
                            alert(""+ res.razon)
                        }
                        this.$emit('SalirDeABMclientes', true)
                    })
            }

            if (this.accion == 'Editar') {
                console.log(JSON.stringify(this.datosClientes))
                this.EditarDatos(`clientes/editar`, this.id, this.datosClientes)
                    .then(res => {
                        this.datosClientes = res
                        this.$emit('SalirDeABMclientes', true)
                    })
            }
            
            if (this.accion == 'Borrar') {
                this.EliminarDatos(`clientes/eliminar`, this.id, this.datosClientes)
                    .then(res => {
                        this.datosClientes = res
                        this.$emit('SalirDeABMclientes', true)
                    })
            }
        },
        
        Cancelar() {
            this.$emit("SalirDeABMclientes", false)
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
    margin: 20px 10px
}

.contenedor{
	position: fixed;
	top:0;
	left:0;
	width: 100%;
	height: 100%;
	background: rgba(0,0,0,0.5);
}

.VentanaModal {
  background-color: rgb(85, 84, 167);
  border-radius: 10px;
  padding: 35px;
  width: 400px;
  margin: 25px auto;
}

table{
    background-color: whitesmoke;
    margin: 0px 40px 10px;
}

.VentanaModalBorrar {
  background-color: rgb(156, 170, 78);
  border-radius: 10px;
  padding: 30px;
  width: 400px;
  margin: 96px auto;
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