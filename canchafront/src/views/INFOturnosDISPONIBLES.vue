<template>
    <div>
        <div v-if="club.length > 1">
            <div class="alert alert-primary divAlerta" role="alert">
                ¡Clickea uno de nuestros clubes para observar sus turnos y sus canchas!
            </div>
            
            <h1> Nuestros clubes: </h1>
            <div class="alert alert-success divAlerta" role="alert">
                ¿Se te complica buscar un club? <br> Buscalo por su nombre:
                <input type="text" v-model="busquedaClub" autofocus>
            </div>
            <ul class="list-group">
                <li class="list-group"  @click="refrescarPagina()">
                    <router-link class="nav-link list-group-item 
                                            list-group-item-action 
                                            list-group-item-secondary"
                                style="font-size: 20px "                                   
                                :to="'/INFOturnosDISPONIBLES/club/'+c.id" 
                                v-for="(c, id) in filtroClub" :key="id">
                        {{c.id}}|{{c.nombre_club}}
                    </router-link>
                </li>
            </ul>
        </div>

        <div v-if="club.length == 1">
            <div>
                <button @click="mostrarInfoClub=!mostrarInfoClub" class="btn btn-info">
                    <i class="bi bi-info-circle-fill icono">
                        <h4>
                            Informacion del Club 
                            <br> 
                            {{club[0].nombre_club}}
                        </h4>
                        
                    </i>
                </button>

                <div v-if="mostrarInfoClub && clubActual" class="divInfo">
                    <h5>Ubicacion: {{club[0].ubicacion}}</h5>
                    <h5>Contacto: {{club[0].contacto}}</h5>
                </div>
            </div>

            <div v-if="clubActual && canchas.length!=0">
                <label for="" class="form-label campo">
                    <i class="bi bi-aspect-ratio"> Cancha: </i>
                </label>
                <select name="cliente_id" v-model="canchaActual" 
                        @change="traerTurnos()"
                        class="form-select" aria-label=".form-select-sm example">

                    <option v-for="(cancha, $id) in canchas" 
                        :key="$id"
                        :value="cancha.id" 
                        >
                            {{cancha.id}}| {{cancha.deporte}}
                    </option>
                </select>

            </div>

            <div>
                <vue-cal class="calendarioVue vuecal--green-theme"
                    :time-from="9 * 60" :time-to="24.5 * 60" 
                    :time-step="30" active-view="month" 
                    
                    :events="events" 

                    :selected-date="fechaDeHoy"
                    :editable-events="{ 
                                        title: false, drag: false, 
                                        resize: false, delete: false, 
                                        create: false
                                    }"
                    locale="es"
                    :todayButton="true"
                />
            </div>
        </div>
    </div>
</template>

<script>
import apiRest from "../mixins/apiRest.vue";
import VueCal from 'vue-cal'
import 'vue-cal/dist/vuecal.css'
import 'vue-cal/dist/i18n/es.js'
import * as moment from "moment/moment";

export default {
    mixins: [apiRest],

    components:{
        VueCal,
    },

    data() {
        return {
            mostrarInfoClub: false,

            fechaDeHoy: moment().format("YYYY-MM-DD"),

            club: [],
            clubActual: ""+this.$route.params.club,
            busquedaClub:"",

            canchas: [],
            canchaActual:"",

            turnos: [],
            events: [],
        }
    },

    created(){
        console.log(this.clubActual)
        this.events= [];
        this.traerClub();
    },

    methods: {
        traerClub(){
            this.ObtenerDatosPorId(`clubes/show`, this.clubActual)
                .then(res => {
                    if(res.msj=="Error" || res.club===[]){
                        this.$swal({
                            title: 'Error, no se pudo mostrar la vista',
                            text: `${res.razon}`,
                            icon: 'error',
                            confirmButtonText: 'Ok'
                        })
                        
                        setInterval(() => {
                            location.reload();
                        }, 3000);

                        this.$router.push('/INFOturnosDISPONIBLES/club/0') 
                    } else {
                        console.log(res.club)
                        this.club = res.club;
                        
                        if(this.clubActual!='0'){
                            this.traerCanchas();
                        }
                    }

                })
        },

        traerCanchas(){
            this.ObtenerDatos(`canchas/${this.clubActual}`)
                .then (res => {
                    if(res.msj=='Error'){
                        this.$swal({
                            title: ''+res.msj,
                            text: ''+res.razon,
                            icon: 'error',
                            confirmButtonText: 'Ok'
                        })
                    }
                    this.canchas = res.canchas.data
                    this.canchaActual= this.canchas[0].id

                    this.traerTurnos(this.canchaActual);
                })
        },

        traerTurnos(){
            this.events=[]

            this.ObtenerDatos(`turnos/${this.clubActual}/${this.canchaActual}`)
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
                        this.turnos = res;
    
                        this.cargarTurnos();
                    }
                })
        },

        cargarTurnos(){
            for (let i=0; i < this.turnos.length; i++) {
                //console.log(this.turnos[i])
                this.events.push({
                    start: this.turnos[i].fecha_Desde,
                    end: this.turnos[i].fecha_Hasta,
                    title: this.turnos[i].tipo_turno,
                    objTurnos: this.turnos[i],
                    class: 'sport'
                })      
            }
            
            //console.log(this.events)
        },

        refrescarPagina(){
            location.reload();
        }

    },

    computed: {
        filtroClub(){
            if(this.busqueda==""){
                return this.club
            }else {
                return this.club.filter((elem)=>elem.nombre_club.toLowerCase().includes(this.busquedaClub.trim().toLowerCase()))
            }
        }
    },
}
</script>

<style scoped>
.divAlerta{
    min-width: 200px;
    min-height: 50px;
    margin: 20px -50px;
    text-align: center;
    font-size: 20px;
}

.divInfo{
    min-width: 200px;
    min-height: 90px;
    margin: 20px -50px;
    padding: 20px;
    background-color: rgb(246, 218, 157) ;
    border: 3px solid;
    border-radius: 15%;
}

.icono{
    font-size: 25px; 
}

.campo{
	color: rgb(44, 41, 41);
    font-size: 20px;
}
</style>