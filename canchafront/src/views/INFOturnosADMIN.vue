<template>
    <div>
        <h2> Turnos </h2>
        <div>
            <vue-cal class="calendarioVue vuecal--green-theme" 
                :time-from="8 * 60" :time-to="19 * 60" 
                :time-step="30" active-view="month" 
                :disable-views="['years', 'year',]"
                :events="events" selected-date="2018-11-19"
                :editable-events="{ title: false, drag: false, resize: true, delete: true, create: false }"
                locale="es"
                :on-event-click="onEventClick"
                
                :cell-click-hold="false"
                :drag-to-create-event="false"
                :on-event-create="onEventCreate"

                v-show="!modal"
            />
        </div>

        <div v-if="modal">
            <div class="card">
                <h5 class="card-header">Evento: {{ selectedEvent.title }}</h5>
                <div class="card-body">
                    <h5 class="card-title">Fecha: {{ selectedEvent.start && selectedEvent.start.format('DD/MM/YYYY') }}</h5>
                    <p class="card-text">{{ selectedEvent.contentFull }}</p>
                    <button class="btn btn-info divBotones" @click="modal=!modal">Guardar</button>
                    <button class="btn btn-dark divBotones" @click="modal=false">Cancelar</button>
                </div>
            </div>
        </div>
        
        <!-- <ABMturnos v-if="modal" :accion=accion :id=id /> -->
    </div>
</template>

<script>
import VueCal from 'vue-cal'
import 'vue-cal/dist/vuecal.css'
import 'vue-cal/dist/i18n/es.js'
import apiRest from '../mixins/apiRest.vue'
//import ABMturnos from "../components/ABMturnos.vue"

export default {
    components:{
        VueCal,
        //ABMturnos,
    },

    mixins: [apiRest],

    data() {
        return {
            selectedEvent: null,
            showEventCreationDialog: false,

            datos: [],
            verABMturnos: false,

            modal:false,

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
        onEventCreate (event, deleteEventFunction) {
            this.selectedEvent = event
            this.showEventCreationDialog = true
            this.deleteEventFunction = deleteEventFunction

            return event
        },

        cancelEventCreation () {
            this.closeCreationDialog()
            this.deleteEventFunction()
        },

        closeCreationDialog () {
            this.showEventCreationDialog = false
            this.selectedEvent = {}
        },

        onEventClick (event, e) {
            this.selectedEvent = event
            this.modal = true

            // Prevent navigating to narrower view (default vue-cal behavior).
            e.stopPropagation()
        },

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
    width: 1000px;
    margin: 50px auto auto -300px;
}

.vuecal--month-view .vuecal__cell {height: 80px;}

.vuecal--month-view .vuecal__cell-content {
  justify-content: flex-start;
  height: 100%;
  align-items: flex-end;
}

.vuecal--month-view .vuecal__cell-date {padding: 4px;}
.vuecal--month-view .vuecal__no-event {display: none;}





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
    margin: 10px 25px 0px
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