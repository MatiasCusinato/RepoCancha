<template>
    <div style="margin: -30px ">
        <h2>Turnos</h2>
        <div v-if="!abrirABMturnos">
            <div class="btncli">
                <button class="btn btn-primary" @click="crearTurno('Crear')"  
                        style="font-size: 20px"> 
                    Agregar un nuevo turno 
                </button>
            </div> 

            <div>
                <label for="" class="form-label campo">
                    <i class="bi bi-aspect-ratio"> Cancha: </i>
                </label>

                <select name="cliente_id" v-model="canchaActual" 
                        @change="traerTurnos()"
                        class="form-select inputChico" aria-label=".form-select-sm example">

                    <option v-for="(cancha, $id) in canchas" 
                        :key="$id"
                        :value="cancha.id">
                            {{cancha.id}}| {{cancha.deporte}}
                    </option>
                </select>
            </div>
        </div>

        <div>
            <vue-cal class="calendarioVue vuecal--green-theme" 
                :time-from="9 * 60" :time-to="24.5 * 60" 
                :time-step="30" active-view="month" 
                
                :events="events" 

                :selected-date="fechaDeHoy"
                
                :editable-events="{ 
                                    title: false, drag: false, 
                                    resize: true, delete: false, 
                                    create: false
                                }"
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
        <div class="container">
            <div class="row justify-content-md-center">
                <h3 class="calcular"> Calcular Ganacias: </h3>
                <div class="btnganacias">
                    <button class="btn btn-secondary" @click="desplegarGanancia('Consultar')"
                            style="font-size: 22px"> 
                        <i class="bi bi-currency-dollar"> Ganancias </i> 
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import VueCal from 'vue-cal'
import 'vue-cal/dist/vuecal.css'
import 'vue-cal/dist/i18n/es.js'
import apiRest from '../mixins/apiRest.vue'
import ABMturnos from "../components/ABMturnos.vue"
import * as moment from "moment/moment";

export default {
    components:{
        VueCal,
        ABMturnos,
    },

    mixins: [apiRest],
    
    data() {
        return {
            abrirGanancia: false,
            selectedEvent: null,
            showEventCreationDialog: false,

            fechaDeHoy: moment().format("YYYY-MM-DD"),

            datos: [],
            canchas:[],
            canchaActual: null,

            abrirABMturnos: false,
            eventoActual: null,

            events: [
                {
                    start: '2018-11-21',
                    end: '2018-11-21',
                    title: 'Need to go shopping',
                    class: 'sport'
                },
            ],
        }
    },

    created(){
        console.log(this.$store.state)
        this.events= []
        this.traerCanchas();
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
                    "fecha_Hasta":"0000-00-00 00:00:00",
                    "precio":"0",
                    "estado":"",
                    "diasFijos":[],
                }
            }
        },

        traerCanchas(){
            let club= localStorage.getItem('club')
            this.ObtenerDatos(`canchas/${club}`)
                .then (res => {
                    this.canchas = res.canchas.data
                    this.canchaActual= this.canchas[0].id
                    this.traerTurnos(this.canchaActual);
                })
        },

        traerTurnos(){
            this.events=[]
            let club= localStorage.getItem('club')

            this.ObtenerDatos(`turnos/${club}/${this.canchaActual}`)
                .then(res => {
                    console.log(res)
                    if(res.length==0){
                        this.$swal({
                            title: '¡Error!',
                            text: 'Esta cancha no contiene turnos',
                            icon: 'error',
                            confirmButtonText: 'Ok'
                        })
                    } else {
                        this.datos = res;
    
                        this.cargarTurnos()
                    }
                })

            //console.log(this.events)
        },

        cargarTurnos(){
            for (let i=0; i < this.datos.length; i++) {
                //console.log(this.datos[i])
                this.events.push({
                    start: this.datos[i].fecha_Desde,
                    end: this.datos[i].fecha_Hasta,
                    title: this.datos[i].tipo_turno,
                    objTurnos: this.datos[i],
                    class: 'sport'
                })      
            }
        },
        
        MostrarABMturnos(ver) {
            this.abrirABMturnos= false

            if (ver === true) {
                this.traerTurnos();
            }
        },
        desplegarGanancia(accion) {
            this.abrirABMturnos = true
            this.accion = accion
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
                    "fecha_Hasta":"0000-00-00 00:00:00",
                    "precio":"0",
                    "estado":"",
                    "diasFijos":[],
                }
            }
            /* this.abrirGanancia = !this.abrirGanancia; */
        },
        
    },
}
</script>

<style>
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
    height: 500px;
    width: 1200px;
    margin: 20px auto auto -450px;
}

.vuecal__event {cursor: pointer;}

.vuecal__event-title {
  font-size: 14px;
  font-weight: 700;
  margin: 4px 0 8px;
}

.vuecal__event.sport {
    background-color: rgba(255, 102, 102, 0.9);
    border: 1px solid rgb(235, 82, 82);
    color: #fff;
}




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

.btnganacias{
    position: relative;
    top: -620px;
    left: -370px
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
    margin: 5px 5px;
	color: rgb(39, 37, 37);
    font-size: 20px;
}

.titulo{
	float:left;
	color: white;
}

.inputChico{
    width: 250px;
}

.calcular{
    position: relative;
    top: -650px;
    left: -400px;

}
</style>