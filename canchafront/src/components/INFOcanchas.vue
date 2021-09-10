<template>
    <div>
        <h1 class="bg-primary text-white text-center mb-3"> Canchas </h1>
        <br>
        <button class="btn btn-success" @click="desplegarABMcancha('Crear')" style="font-size: 22px"> 
            Agregar nueva Cancha 
        </button>
        <br>
        <ABMcanchas
            v-if="abrirABMcancha"
            :accion=accion
            :id=id
            @SalirDeABMcanchas = MostrarABMcanchas($event)
        />
        <br>  <!-- table table-dark table-striped mt-4 -->
            <table class="light-blue darken-2">
                <thead>
                    <tr class="bg-primary text-light">
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
                    <button class="btn btn-info" @click="desplegarABMcancha('Editar', canchas.id)">
                        Editar
                    </button> 
                    <button class="btn btn-danger" @click="desplegarABMcancha('Borrar', canchas.id)">
                        Borrar
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
h1 {
    text-align: center;
    border-style: solid;
    border-width: 2px;
    font-size: 50px;
    font-family: -webkit-body;
    color: blue;
}
table, th, td{
    border: 2px solid rgb(116, 113, 113);
    border-collapse: collapse;
    margin:10px auto 10px auto;
    padding: 18px 30px;
    margin: 10px -100px;
    text-align: center;
    border-width: 2px;
    font-size: 15px;
    }
</style>