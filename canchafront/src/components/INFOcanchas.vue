<template>
    <div>
        <h1> Canchas </h1>
        <br>
        <button class="btn btn-success" @click="desplegarABMcancha('Crear')"> 
            Agregar nueva Cancha 
        </button>
        <br>
        <br>
        <ABMcanchas
            v-if="abrirABMcancha"
            :accion=accion
            :id=id
            @SalirDeABMcanchas = MostrarABMcanchas($event)
        />
        <br>
            <table class="table">
                <thead class="table-dark">
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col">Club</th>
                    <th scope="col">Deporte</th>
                    <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(canchas, index) in datos" :key="index">
                    <th scope="row"> {{canchas.id}} </th>
                    <td> {{canchas.club_configuracion_id}} </td>
                    <td> {{canchas.deporte}} </td>
                    <td>
                    <button class="btn btn-warning" @click="desplegarABMcancha('Modificar', canchas.id)">
                        Modificar
                    </button> 
                    <button class="btn btn-danger" @click="desplegarABMcancha('Eliminar', canchas.id)">
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
import ABMcanchas from "../components/ABMcanchas.vue"

export default {

    mixins: [apiRest],

    components: {
        ABMcanchas
    },

    data() {
        return {
            datos: [],
            abrirABMcancha: false,
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
            console.log("Obteniendo CANCHAS desde la API ...");
            this.ObtenerDatos('canchas')
                .then(res => {
                    this.datos = res
                })
        },
        desplegarABMcancha(accion, id=0) {
            this.accion = accion,
            this.id = id,
            this.abrirABMcancha = !this.abrirABMcancha;
        },
        MostrarABMcanchas(ver) {
            this.abrirABMcancha = false 
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