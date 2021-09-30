<template>
    <div>
        <h2> Turnos </h2>
        <div class="btncli">
            <button class="btn btn-primary" @click="crearTurno('Crear')"  
                    v-if="!abrirABMturnos" style="font-size: 20px"> 
                Agregar un nuevo turno 
            </button>
        </div> 
        <div>
            <vue-cal class="calendarioVue vuecal--green-theme" 
                :time-from="9 * 60" :time-to="24.5 * 60" 
                :time-step="30" active-view="month" 
                
                :events="events" selected-date="2018-11-19"
                :editable-events="{ title: false, drag: false, resize: true, delete: true, create: false }"
                locale="es"
                :on-event-click="onEventClick"
                :todayButton="true"
                
                :cell-click-hold="false"
                :drag-to-create-event="false"
                :on-event-create="onEventCreate"

                v-if="!abrirABMturnos"
            />
        </div>

        <ABMturnos v-if="abrirABMturnos"
            :eventoActual="eventoActual"
            :accion="accion"
            @SalirDeABMturnos = MostrarABMturnos($event)
        />
    </div>
</template>

<script>
import VueCal from 'vue-cal'
import 'vue-cal/dist/vuecal.css'
import 'vue-cal/dist/i18n/es.js'
import apiRest from '../mixins/apiRest.vue'
import ABMturnos from "../components/ABMturnos.vue"

export default {
    components:{
        VueCal,
        ABMturnos,
    },

    mixins: [apiRest],
    
    data() {
        return {
            selectedEvent: null,
            showEventCreationDialog: false,

            datos: [],

            abrirABMturnos: false,
            eventoActual: null,

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
        this.events= []
        this.traerTurnos();
    },

    methods:{
        onEventCreate (event, deleteEventFunction) {
            this.selectedEvent = event
            this.abrirABMturnos = true
            this.deleteEventFunction = deleteEventFunction

            return event
        },

        cancelEventCreation () {
            this.closeCreationDialog()
            this.deleteEventFunction()
        },

        closeCreationDialog () {
            this.abrirABMturnos = false
            this.selectedEvent = {}
        },

        onEventClick (event, e) {
            this.selectedEvent = event
            this.abrirABMturnos = true
            this.accion= "Consultar"
            //console.log(event)
            this.eventoActual= event

            // Prevent navigating to narrower view (default vue-cal behavior).
            e.stopPropagation()
        },

        crearTurno(accion){
            this.abrirABMturnos = true
            this.accion= accion
            this.eventoActual= {
                //"start":"00-0-00",
                "objTurnos":{
                    "grupo":0,
                    "cliente_id":null,
                    "nombre":"",
                    "apellido":"",
                    "cancha_id":null,
                    "deporte":"",
                    "club_configuracion_id":null,
                    "tipo_turno":"",
                    "fecha_Desde":"0000-00-00 00:00:00",
                    "fecha_Hasta":"0000-0-0 00:00:00",
                    "precio":"0"
                }
            }
        },

        traerTurnos(){
            this.events=[]
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
                    class: 'sport',
                    objTurnos: this.datos[i]
                })      
            }
        },
        
        MostrarABMturnos(ver) {
            this.abrirABMturnos= false

            if (ver === true) {
                this.traerTurnos();
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

.vuecal__event.leisure {background-color: rgba(253, 156, 66, 0.9);border: 1px solid rgb(233, 136, 46);color: #fff;}
.vuecal__event.sport {background-color: rgba(255, 102, 102, 0.9);border: 1px solid rgb(235, 82, 82);color: #fff;}
</style>