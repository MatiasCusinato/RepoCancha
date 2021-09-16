<template>
    <div>
        <hr>
        <p>{{accion}} Clientes</p>
            <form class="formABM">

                <div v-if="accion=='Borrar'">
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
                </div>
                
                <div v-if="accion=='Crear' || accion=='Editar'">
                    <div class="mb-3">
                        <label for="" class="form-label"> Nombre: </label>
                        <input type="text" class="form-control" v-model="datosClientes.nombre">
                    </div>

                    <div class="mb-3">
                        <label for="" class="form-label"> Apellido: </label>
                        <input type="text" class="form-control" v-model="datosClientes.apellido">
                    </div>

                    <div class="mb-3">
                        <label for="" class="form-label"> Telefono: </label>
                        <input type="text" class="form-control" v-model="datosClientes.telefono">
                    </div>

                    <div class="mb-3">
                        <label for="" class="form-label"> Edad: </label>
                        <input type="text" class="form-control" v-model="datosClientes.edad">
                    </div>

                    <div class="mb-3">
                        <label for="" class="form-label"> Email:</label>
                        <input type="text" class="form-control" v-model="datosClientes.email">
                    </div>
                </div>

                <div class="divBotones">
                    <button @click="Aceptar()" class="btn btn-primary"> Aceptar </button>
                    |
                    <button @click="Cancelar()" class="btn btn-danger"> Cancelar </button>
                </div>
            </form>
            <!--  <div class="alert alert-warning" role="alert" v-if="accion === 'Borrar'">
                <p>¿Esta seguro de borrar este CLIENTE?</p>
                <strong>Atención!</strong> ¿Esta seguro de borrar este CLIENTE?.
                <button @click="Cancelar()" class="btn btn-primary btn-sm">No, volver</button> 
                <button @click="Aceptar()" class="btn btn-danger btn-sm">Si, borrar cliente</button>
            </div> -->
            <hr>
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
                nombre: '',
                apellido:"",
                edad: "",
                telefono: "",
                email: "",
                club_configuracion_id:"",
                id: 0,
            }
        }
    },

    created() {
        console.log("evento created")
        if (this.accion != 'Crear') {
            let club=  localStorage.getItem('club')
            //this.datosClientes.club_configuracion_id= club;

            this.ObtenerDatos(`clientes/${club}/${this.id}`)
                .then (res => {
                    this.datosClientes = res
                })
        }
    },

    methods: {
        Aceptar() {
            if (this.accion == 'Crear') {
                let club= {club_configuracion_id : localStorage.getItem('club')}
                this.datosClientes.club_configuracion_id= club;

                console.log(JSON.stringify(this.datosClientes))
                this.InsertarDatos ('clientes', this.datosClientes)
                    .then(res => {
                        if (res.id != 0) {
                            console.log('El registro fue ingresado con exito')
                        } else {
                            console.log('Error al ingresar el registro')
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
                /* this.EliminarDatos ('clientes', this.id)
                    .then(res => {
                        this.datosClientes = res
                        this.$emit('SalirDeABMclientes', true)
                    }) */
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

p {
    font-size: 30px;
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
</style>