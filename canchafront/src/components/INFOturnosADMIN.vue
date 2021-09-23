<template>
    <div>
        <h2> Turnos </h2>
        <div class="btn-group" role="group" aria-label="Basic example">
            <button class="btn btn-info" style="margin: 10px">CANCHA 1</button>
            <button class="btn btn-info" style="margin: 10px">CANCHA 2</button>
            <button class="btn btn-info" style="margin: 10px">CANCHA 3</button>
        </div>
        <br>
        <div class="btnTurno">
            <button class="btn btn-info"> Agregar nuevo Turno </button>
            <br>
            <br>
            <button class="btn btn-info"> Agregar nuevo Turno Fijo </button>
        </div>

        <br>
        <div>
            <vue-cal class="calendarioVue vuecal--green-theme" 
                :time="false" active-view="month" :disable-views="['years', 'year',]"
                :events="events" selected-date="2018-11-19"
            />
        </div>
    </div>
</template>

<script>
import VueCal from 'vue-cal'
import 'vue-cal/dist/vuecal.css'
import apiRest from '../mixins/apiRest.vue'

export default {
    components:{VueCal},

    mixins: [apiRest],

    data() {
        return {
            datos: [],
            verABMturnos: false,

            events: [
                {
                    start: '2018-11-21',
                    end: '2018-11-21',
                    title: 'Need to go shopping',
                    class: 'leisure'
                },
            ],

        }
    },

    created(){
        this.traerTurnos();
    },

    methods:{
        traerTurnos(){
            let club= localStorage.getItem('club')
            this.ObtenerDatos(`turnos/${club}/1`)
                .then(res => {
                    //console.log(res)
                    this.datos = res;

                    this.cargarTurnos()
                })

            console.log(this.events)
        },

        cargarTurnos(){
            for (let i=0; i < this.datos.length; i++) {
                //console.log(this.datos[i])
                this.events.push({
                    start: this.datos[i].fecha_Desde,
                    end: this.datos[i].fecha_Hasta,
                    title: this.datos[i].tipo_turno,
                    class: 'blue-event',
                }) 

                
            }

        },
        
    },
}
</script>

<style scoped>
.btnTurno {
    position: fixed;
    float: left;
    bottom: 200px;
    left: 100px;
    font-size: 16px;
    min-width: 150px;
    height: 40px;
    width: 80px;
    padding: 15px 32px;
}
.btnCancha button {
    display: inline-block;
    margin: 0 10px;
}

.calendarioVue{
    height: 400px;
    width: 700px;
    margin: 5px -150px;
}
</style>