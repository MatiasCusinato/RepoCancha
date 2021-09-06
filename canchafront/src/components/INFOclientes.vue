<template>
    <div>
        <h1> Clientes </h1>
        <br>
        <button class="btn btn-success" @click="desplegarABMcliente('Crear')"> 
            Agregar un nuevo Cliente 
        </button>
        <br>
        <br>
        <ABMclientes
            v-if="abrirABMcliente"
            :accion=accion
            :id=id
            @SalirDeABMclientes = MostrarABMclientes($event)
        />
        <br>
            <table class="table">
                <thead class="table-dark">
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Apellido</th>
                    <th scope="col">Telefono</th>
                    <th scope="col">Edad</th>
                    <th scope="col">Email</th>
                    <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(clientes, index) in datos" :key="index">
                    <th scope="row">{{clientes.id}}</th>
                    <td> {{clientes.nombre}} </td>
                    <td> {{clientes.apellido}} </td>
                    <td> {{clientes.telefono}} </td>
                    <td> {{clientes.edad}} </td>
                    <td> {{clientes.email}} </td>
                    <td>
                    <button class="btn btn-warning" @click="desplegarABMcliente('Modificar', clientes.id)">
                        Modificar
                    </button> 
                    <button class="btn btn-danger" @click="desplegarABMcliente('Eliminar', clientes.id)">
                        Eliminar
                    </button> 
                    </td>
                    </tr>
                </tbody>
            </table>
    </div>
</template>

<script>

import apiRest from "../mixins/apiRest.vue"
import ABMclientes from "../components/ABMclientes.vue"

export default {

    mixins: [apiRest],

    components: {
        ABMclientes
        },

    data() {
        return {
            datos: [],
            abrirABMcliente: false,
            accion: '',
            id: 0,
        }
    },
    created() {
        this.traerDatos()
    },
    mounted() {
        console.log("evento mounted")
        this.traerDatos()
    },
    destroyed() {
        console.log("evento destroyed")
        this.traerDatos()
    },
    methods: {
        traerDatos() {
            console.log("Obteniendo CLIENTES desde la API ...");
            this.ObtenerDatos('clientes')
                .then(res => {
                    this.datos = res
                })
        },
        desplegarABMcliente(accion, id=0) {
            this.accion = accion,
            this.id = id,
            this.abrirABMcliente = !this.abrirABMcliente;
        },
        
        MostrarABMclientes(ver) {
            this.abrirABMcliente = false
            if (ver == true) {
            this.traerDatos();
            }
        }
    }
}
</script>

<style scoped>
    table, th, td{
        border: 2px solid rgb(116, 113, 113);
        border-collapse: collapse;
        margin:10px auto 10px auto;
        background-color: rgb(222, 184, 135);
    }
</style>