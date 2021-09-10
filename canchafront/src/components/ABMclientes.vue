<template>
    <div>
        <hr>
        <p>{{accion}} Clientes</p>
            <form class="formABM">
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
                <div>
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
                id: 0,
            }
        }
    },
    created() {
        console.log("evento created")
        if (this.accion != 'Crear') {
            this.ObtenerDatosPorId('clientes', this.id)
                .then (res => {
                    this.datosClientes = res
            })
        }
    },
    mounted() {
        console.log("evento mounted")
    },
    beforeDestroyed() {
        console.log("evento beforeDestroyed")
    },
    destroted() {
        console.log("evento destroyed")
    },
    methods: {
        Aceptar() {
            if (this.accion == 'Crear') {
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
                this.EditarDatos ('clientes', this.id, this.datosClientes)
                    .then(res => {
                        this.datosClientes = res
                        this.$emit('SalirDeABMclientes', true)
                    })
            }
            if (this.accion == 'Borrar') {
                this.EliminarDatos ('clientes', this.id)
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
</style>