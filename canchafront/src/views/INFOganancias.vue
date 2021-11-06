<template>
    <div>
        <h1 class="bg-secondary text-white text-center mb-3"> Ganancias </h1>
        
            <div>
                <div class="contenedor">
                    <div class="VentanaModalGanancia">
                        <div class="cabecera tituloventanaganancia">
                            <h5 class="h5ABMGanacia text-white text-center mb-3"> Ganancia </h5>
                            <div class="alert alert-success" role="alert">
                                <i class="bi bi-info-circle-fill"></i>
                                Calcule la ganacia de los turnos cobrados colocando solo 2 fechas
                            </div>
                            <div class="container overflow-hidden gx-1">
                                <div class="row gy-2 justify-content-md-center">
                                    <div class="col-md-6 mb-3">
                                        <span><i class="bi bi-hourglass-top campo"> Comienzo: </i></span>
                                        <input type="datetime-local" class="form-control form-control-sm inputChico" 
                                                v-model="objganancia.fecha_Desde">
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <span><i class="bi bi-hourglass-bottom campo"> Fin: </i></span>
                                        <input type="datetime-local" class="form-control form-control-sm inputChico" 
                                                v-model="objganancia.fecha_Hasta">
                                    </div>
                                </div>

                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                                <button class="btn btn-primary" @click="EnviarGanacia()">
                                                        <i class="bi bi-check2-circle"> Enviar </i>
                                                </button>
                                        </div>
                                    </div>  
                                </div>

                                <div class="inpganancia" v-if="datos.length>0">
                                    <div class="col-4 mb-3">
                                        <span> GananciaTotal: </span>
                                        <input type="number" class="form-control form-control-sm input-md" placeholder="0" v-model="ganancias" readonly>
                                    </div>
                                </div>
                                
                                <div class="container" v-if="datos.length>0">
                                    <div class="row">
                                        <div class="col">
                                            <table>
                                                <thead>
                                                    <tr class="bg-primary">
                                                        <th scope="col"> Turnos </th>
                                                        <th scope="col"> Fecha </th>
                                                        <th scope="col"> Precio </th>
                                                        <th scope="col"> Cancha </th>
                                                        <th scope="col"> Tipo de turno </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-for="(turnos, index) in datos" :key="index">
                                                        <th scope="row">{{turnos.id}}</th>
                                                        <td>{{turnos.fecha_Desde}}</td>
                                                        <td>{{turnos.precio}}</td>
                                                        <td>{{turnos.cancha_id}}</td>
                                                        <td>{{turnos.tipo_turno}}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>    
                                    </div> 
                                </div>
                            </div>    
                        </div>
                    </div>
                </div>
            </div>
    </div>        
</template>

<script>

import apiRest from '../mixins/apiRest.vue'
import * as moment from "moment/moment";

export default {

    mixins: [apiRest],

    props: ['accion', 'cant'],
    
    data() {
        return {
            datos: [],
            gananciaTotal: "",
            abrirGanancia: false,
            accionAux: this.accion,

            objganancia: { 
                club_configuracion_id: this.$store.state.vClub,
                fecha_Desde: moment().format('YYYY-MM-DDT00:00'),
                fecha_Hasta: moment().format('YYYY-MM-DDT23:59'),
            },

            canchas: [],
            
            ganancias: "0",
        }
        
    },

    created(){
        //console.log(this.$store.state)
    },

    methods: {
        EnviarGanacia() {
            this.alertaFormulario= [];
            let fechaDesde= this.objganancia.fecha_Desde
            let fechaHasta= this.objganancia.fecha_Hasta
            let a = moment(fechaHasta);
            let b = moment(fechaDesde);
            //console.log(a.diff(b, 'days') )
            //console.log(a.diff(b, 'days') < 2)

            //Valido si la Fecha1 es mayor a la Fecha2, o si la Fecha2 es anterior a la Fecha1 y por ultimo, si son iguales
            if(moment(fechaDesde).format('x') > moment(fechaHasta).format('x') ||
                    moment(fechaHasta).format('x') < moment(fechaDesde).format('x')){
                this.alertaFormulario+="Puede que las fechas esten mal expresadas (Fecha1 es posterior a la Fecha2 o viceversa)";                
            }

            //Valido que las fechas no sean iguales y tengan como minimo una diferencia de 2 dias entre sus fechas
            if(moment(fechaHasta).format('x') == moment(fechaDesde).format('x') || (a.diff(b, 'days') < 2 && a.diff(b, 'days') > 0) ){
                this.alertaFormulario+=". Las fechas no deben ser iguales, deben tener por lo menos 48 horas entre ellas";                
            }

            if(this.alertaFormulario.length > 0){
                this.$swal({
                    title: 'Error',
                    text: ''+this.alertaFormulario,
                    icon: 'error',
                    confirmButtonText: 'Ok',
                    timer: 5000
                })
                return
            }

            this.InsertarDatos("clubes/ganancias", this.objganancia)
                .then(res => {
                    //console.log(res)
                    if(res.msj == "Error") {
                        this.$swal({
                            title: ''+res.msj,
                            text: ''+res.razon,
                            icon: 'error',
                            confirmButtonText: 'Ok',
                            timer: 2500
                        }) 
                    } else {
                        if (res.data.length== 0) {
                            this.$swal({
                            title: 'No se encontraron ganancias entre estas fechas',
                            position: "top-end", 
                            backdrop:false,
                            icon: 'error',
                            confirmButtonText: 'Ok',
                            timer: 2500
                        }) 
                        }
                        this.datos=res.data
                        this.ganancias=res.TotalGanancia.ganancia
                        /* this.$swal({
                            title: ''+res.msj,
                            text: 'Cant de Turnos cobrados: '+res.data.cant_turnos + ". Ganancia Total: $" + res.data.ganancia,
                            icon: 'info',
                            confirmButtonText: 'Ok',
                            timer: 10000
                        }) */
                    }       
                })
                
                
        },
    }
}
</script>

<style scoped>

table, th, td{
    border: 2px solid rgb(116, 113, 113);
    border-collapse: collapse;
    margin:10px auto 10px auto;
    padding: 15px;
    margin: 15px -240px;
    text-align: center;
    border-width: 2px;
    font-size: 18px;
    margin-left: 120px;
    margin-right: auto;
    width: 300px;
}
.contenedor{
    background-color: rgb(255, 255, 255) !important;
	position: fixed;
	margin-top: 55px;
	left:0;
	width: 100%;
	height: 100%;
	background: rgba(0,0,0,0.5);
    overflow-y: scroll;
}
.VentanaModalGanancia {
    background-color: rgb(35, 155, 86 );
    border-radius: 10px;
    padding: 28px;
    width: 800px;
    margin: 25px auto;
}
.h5ABMGanacia{
    border-radius: 10px;
    border-style: ridge;
    border-color: rgb(134, 186, 255);
    min-width: 10%;
    min-height: 20px;
    background-color: rgb(125, 155, 241);
}

.inpganancia{
    margin-left: 280px;
}
</style>