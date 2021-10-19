<template>
    <div>
        <div >
            <button @click="mostrarInfoClub=!mostrarInfoClub">
                <i class="bi bi-info-circle-fill">Informacion del Club</i>
            </button>

            <div v-if="mostrarInfoClub && clubActual">
                <span>Ubicacion {{club.ubicacion}}</span>
                <br>
                <span>contacto {{club.contacto}}</span>
            </div>
        </div>

        <div v-if="clubActual">
            <label for="" class="form-label campo"><i class="bi bi-person"> Cancha: </i></label>
            <select name="cliente_id" v-model="canchaActual" 
                    class="form-select" aria-label=".form-select-sm example">

                <option v-for="(cancha, $id) in canchas" 
                    :key="$id"
                    :value="cancha.id">
                        {{cancha.id}}| {{cancha.deporte}}
                </option>
            </select>

            <button @click="traerTurnos()">
                Traer turnos (cancha: {{canchaActual}})
            </button>
        </div>

        <div>
            <vue-cal class="calendarioVue vuecal--green-theme " 
                :time-from="9 * 60" :time-to="24.5 * 60" 
                :time-step="30" active-view="month" 
                
                :events="events" selected-date="2018-11-19"
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
</template>

<script>
import apiRest from "../mixins/apiRest.vue";
import VueCal from 'vue-cal'
import 'vue-cal/dist/vuecal.css'
import 'vue-cal/dist/i18n/es.js'

export default {
    mixins: [apiRest],

    components:{
        VueCal,
    },

    data() {
        return {
            mostrarInfoClub: false,
            club: [],
            clubActual: this.$route.params.club,

            canchas: [],
            canchaActual:"",

            turnos: [],

            datos: [],
            events: [],
        }
    },

    created(){
        this.events= [];
        this.traerClub();
        this.traerCanchas();
    },

    methods: {
        traerClub(){
            this.ObtenerDatosPorId(`clubes/show`, this.clubActual)
                .then(res => {
                    this.club = res;
                })
        },

        traerCanchas(){
            this.ObtenerDatos(`canchas/${this.clubActual}`)
                .then (res => {
                    this.canchas = res.canchas.data
                    this.canchaActual= this.canchas[0].id
                    //this.traerTurnos(this.canchaActual);
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

    },
}
</script>