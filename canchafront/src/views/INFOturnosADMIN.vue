<template>
    <div style="margin: -30px ">
        <h2>Turnos</h2>
        <div v-if="!abrirABMturnos && alertaCanchas">
            <div class="alert alert-danger" role="alert" style="text-align: center; font-size:20px">
                <strong>¡No tenés canchas!</strong> <br>Para crear un turno, debes de crear una cancha en la vista <u>"Mis canchas"</u>.<br>
                Tambien deberas crear clientes desde la vista <u>"Mis clientes"</u> 
            </div>
        </div>
        <div v-if="!abrirABMturnos && canchas.length>0">
            <div class="btncli">
                <button class="btn btn-primary" @click="desplegarAccion('Crear', 0, canchaActual)"  
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

        <div v-if="!abrirUltimosTurnos && canchas.length>0">
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
            :accion="accion"
            :turnoObjeto="turnoObjeto"
            @SalirDeABMturnos = MostrarABMturnos($event)
        />

        <div class="container">
            <div class="row justify-content-md-center">
                <div class="btnganacias">
                    <button class="btn btn-secondary" @click="abrirUltimosTurnos= !abrirUltimosTurnos"
                            style="font-size: 22px"> 
                        <i class="bi bi-stack"> Ultimos turnos </i> 
                    </button>
                </div>

            <!-- Modal Ganacia "consultar" -->
            <div v-if="abrirUltimosTurnos">
                    <div class="contenedor">
                        <div class="VentanaModalUltimosTurnos">
                            <div class="row gy-2 justify-content-md-center">
                                <div class="row">
                                    <h1 class="bg-success text-white text-center"> 
                                        Ultimos turnos reservados 
                                    </h1>     
                                </div>
                            </div>

                            <div class="row justify-content-around">
                                    <div class="col-4 mb-3">
                                        <span><i class="bi bi-hourglass-top campo "> Comienzo: </i></span>
                                        <input type="datetime-local" class="form-control form-control-sm input-md" 
                                                v-model="objUltimosTurnos.fecha_Desde">
                                    </div>

                                    <div class="col-4 mb-3">
                                        <span><i class="bi bi-hourglass-bottom campo "> Fin: </i></span>
                                        <input type="datetime-local" class="form-control form-control-sm input-md" 
                                                v-model="objUltimosTurnos.fecha_Hasta">
                                    </div>
                                </div>

                            <div class="row justify-content-around">
                                    <button class="btn btn-danger col-4" @click="cerrarUltimosTurnos()">
                                        <i class="bi bi-x-circle-fill"> Atras </i>
                                    </button>

                                    <button class="btn btn-primary col-4" @click="obtenerUltimosTurnos()">
                                            <i class="bi bi-check2-circle"> Enviar </i>
                                    </button>

                            </div>  
                             <br>
                            <table class="table-success tablecli" v-if="ultimosTurnos.length>0">
                                <thead>
                                    <tr class="bg-success">
                                        <!-- <th scope="col">ID</th> -->
                                        <th scope="col">Cliente</th>
                                        <th scope="col">Cancha</th>
                                        <th scope="col">Comienzo</th>
                                        <th scope="col">Fin</th>
                                        <th scope="col">Precio</th>
                                        <th scope="col">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(turno, index) in ultimosTurnos" :key="index">
                                        <!-- <th scope="row">{{turno.id}}</th> -->
                                        <td> {{turno.nombre}} {{turno.apellido}}</td>
                                        <td>{{turno.cancha_id}}| {{turno.deporte}}</td>
                                        <td> {{turno.fecha_Desde}} </td>
                                        <td> {{turno.fecha_Hasta}} </td>
                                        <td> {{turno.precio}} </td>

                                        <td>
                                            <button class="btn btn-info" 
                                                    @click="desplegarAccion('Consultar', turno.id, turno.cancha_id)">
                                                <i class="bi bi-eye-fill"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table> 
                        </div>
                    </div>
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
            abrirUltimosTurnos: false,
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

            objUltimosTurnos: { 
                club_configuracion_id: this.$store.state.vClub,
                token: this.$store.state.vToken,
                fecha_Desde: moment().format('YYYY-MM-DDT00:00'),
                fecha_Hasta: moment().add({days: 2}).format('YYYY-MM-DDT23:59'),
            },

            ultimosTurnos: [],
            alertaCanchas: false,
        }
    },

    created(){
        //console.log(this.$store.state)
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
            console.log(event)
            
            this.desplegarAccion('Consultar', event.objTurnos.id, event.objTurnos.cancha_id)
        
            // Prevent navigating to narrower view (default vue-cal behavior).
            e.stopPropagation()
        },

        desplegarAccion(accion, turno_id, cancha_id){
            if(accion=='Consultar' || accion=='Crear'){
                this.abrirABMturnos = true
            
                this.accion= accion 
                this.turnoObjeto= {
                    "turno_id": turno_id,
                    "cancha_id": cancha_id,
                }

                this.abrirUltimosTurnos=false
            }
            
        },

        traerCanchas(){
            this.ObtenerDatos(`canchas/${this.$store.state.vClub}`)
                .then (res => {
                    if(res.msj=='Error'){
                        this.$swal({
                            title: ''+res.msj,
                            text: ''+res.razon,
                            icon: 'error',
                            confirmButtonText: 'Ok',
                            timer: 2500
                        })

                        this.alertaCanchas= true;
                        return
                    }else {
                        this.canchas = res.canchas.data
                        this.canchaActual= this.canchas[0].id
                        this.traerTurnos(this.canchaActual);
                    }
                })
        },

        traerTurnos(){
            this.events=[]

            this.ObtenerDatos(`turnos/${this.$store.state.vClub}/${this.canchaActual}`)
                .then(res => {
                    //console.log(res)
                    if(res.length==0){
                        this.$swal({
                            title: 'Esta cancha no contiene turnos',
                            icon: 'error',
                            confirmButtonText: 'Ok',
                            timer: 2000,
                            position: 'top-end',
                            backdrop:false,
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
                    class: this.datos[i].estado
                })      
            }
        },
        
        MostrarABMturnos(ver) {
            this.ultimosTurnos= [];
            this.abrirABMturnos= false

            if (ver === true) {
                this.traerTurnos();
            }
        },
        

        obtenerUltimosTurnos() {
            this.alertaFormulario= [];
            //Valido si la Fecha1 es mayor a la Fecha2, o si la Fecha2 es anterior a la Fecha1 y por ultimo, si son iguales
            let fechaDesde= moment(this.objUltimosTurnos.fecha_Desde);
            let fechaHasta= moment(this.objUltimosTurnos.fecha_Hasta);
            if(fechaDesde.format('x') > fechaHasta.format('x') ||
                    fechaHasta.format('x') < fechaDesde.format('x')){
                this.alertaFormulario+="Las fechas estan mal indicadas (Fecha1 es posterior a la Fecha2 o viceversa)";                
            }

            //Valido que las fechas no sean iguales y tengan como minimo una diferencia de 2 dias entre sus fechas
            if(fechaHasta.format('x') === fechaDesde.format('x') || 
                    (fechaHasta.diff(fechaDesde, 'days') < 2 && fechaHasta.diff(fechaDesde, 'days') > 0) ){
                this.alertaFormulario+=". Las fechas no deben ser iguales, deben tener por lo menos 48 horas entre ellas";                
            }

            if(this.alertaFormulario.length > 0){
                return this.$swal({
                    title: 'Error',
                    text: ''+this.alertaFormulario,
                    icon: 'error',
                    confirmButtonText: 'Ok',
                })
            }

            this.InsertarDatos(`turnos/${this.$store.state.vClub}/ultimosReservados`, this.objUltimosTurnos)
                .then(res => {
                    console.log(res)
                    if(res.msj == "Error") {
                        this.$swal({
                            title: ''+res.msj,
                            text: ''+res.razon,
                            icon: 'error',
                            confirmButtonText: 'Ok',
                        }) 
                    } else {
                        this.ultimosTurnos= res.data;
                    }       
                })   
        },

        cerrarUltimosTurnos(){
            this.abrirUltimosTurnos=!this.abrirUltimosTurnos
            this.ultimosTurnos= [];
        }
        
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

.vuecal__event.Reservado {
    background-color: rgba(27, 155, 44, 0.9);
    border: 1px solid rgb(4, 15, 5);
    color: #fff;
}

.vuecal__event.Cobrado {
    background-color: rgba(138, 138, 138, 0.9);
    border: 1px solid rgb(8, 2, 2);
    color: #fff;
}
.vuecal__event.Adeudado {
    background-color: rgba(216, 104, 0, 0.9);
    border: 1px solid rgb(0, 0, 0);
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
    overflow-y: scroll;
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

.VentanaModalUltimosTurnos{
    background-color: rgb(58, 194, 137);
    border-radius: 10px;
    padding: 28px;
    width: 1000px;
    margin: 25px auto;
}
.input-md{
    width:250px;
}

table, th, td{
    border: 2px solid rgb(116, 113, 113);
    border-collapse: collapse;
    margin:10px auto 10px auto;
    padding: 10px;
    text-align: center;
    border-width: 2px;
    font-size: 22px;
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