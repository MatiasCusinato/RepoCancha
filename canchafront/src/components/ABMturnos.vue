<template>
    <div>
        <h1>ABMTURNOS</h1>
        <div class="card w-100" v-if="!abrirFormTurnos">
            <h5 class="card-header">Evento: {{ eventoActual.title }}</h5>
            <div class="card-body">
                <h5 class="card-title">Fecha: {{ eventoActual.start && eventoActual.start.format('DD/MM/YYYY') }}</h5>
                <p class="card-text">
                    <strong>Cliente: </strong>
                        {{ eventoActual.objTurnos.nombre }} 
                        {{ eventoActual.objTurnos.apellido }}
                </p>

                <p class="card-text">
                    <strong>Cancha:</strong> {{ eventoActual.objTurnos.cancha_id }}
                </p>

                <p class="card-text">
                    <strong>Comienzo:</strong> {{ eventoActual.objTurnos.fecha_Desde }}
                </p>

                <p class="card-text">
                    <strong>Fin: </strong> {{ eventoActual.objTurnos.fecha_Hasta }}
                </p>

                <p class="card-text">
                    <strong>Tipo turno: </strong> {{ eventoActual.objTurnos.tipo_turno }}
                </p>

                <p class="card-text">
                    <strong>Precio: </strong> ${{ eventoActual.objTurnos.precio }}
                </p>           

                <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                    <div class="btn-group mr-2" role="group" aria-label="First group"
                            style="margin: 0px 50px 0px 10px">
                        <button type="button" class="btn btn-secondary" @click="Cancelar()">
                            Atras
                        </button>
                    </div>
                    <div class="btn-group mr-2" role="group" aria-label="Second group">
                        <button type="button" class="btn btn-success" @click="desplegarABMturnos('Editar')">Editar</button>
                        <button type="button" class="btn btn-danger" @click="desplegarABMturnos('Borrar')">Borrar</button>
                    </div>
                </div>
                
            </div>
        </div>
        
        <div v-if="abrirFormTurnos">
            <div v-if="accion == 'Editar'">
                <h2>Editando turno</h2>
                <div class="contenedor" v-if="accion=='Editar'">
                    <div class="VentanaModalEditar">
                        <div class="cabecera tituloventana">
                        <button class="cierre btn btn-primary" @click="desplegarABMturnos('Consultar')"><font color="#35586F">X</font></button>
                        <p>{{accion}} Turnos</p>
                        </div>
                        <div class="contenido">
                            <div class="mb-3">
                                <label for="" class="form-label campo"> Cliente: </label>
                                <select name="cliente_id" v-model="eventoActual.objTurnos.cliente_id" 
                                            class="form-select" aria-label=".form-select-sm example">
                                    <option :value="eventoActual.objTurnos.cliente_id" selected>
                                        {{eventoActual.objTurnos.id}}| {{eventoActual.objTurnos.nombre}} {{eventoActual.objTurnos.apellido}}
                                    </option>
                                    <option v-for="(cliente, $id) in clientes" 
                                        :key="$id"
                                        :value="cliente.id">
                                            {{cliente.id}}| {{cliente.nombre}} {{cliente.apellido}}
                                    </option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="" class="form-label campo"> Cancha: </label>
                                <select name="cancha_id" v-model="eventoActual.objTurnos.cancha_id" 
                                            class="form-select" aria-label=".form-select-sm example">
                                    <option :value="eventoActual.objTurnos.cancha_id" selected>
                                        {{eventoActual.objTurnos.cancha_id}}| {{eventoActual.objTurnos.deporte}}
                                    </option>
                                    <option v-for="(cancha, $id) in canchas" 
                                        :key="$id"
                                        :value="cancha.id">
                                            {{cancha.id}}| {{cancha.deporte}}
                                    </option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="" class="form-label campo"> Tipo de turno </label>
                                <input type="text" class="form-control form-control-sm inputChico" v-model="eventoActual.objTurnos.tipo_turno">
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="" class="form-label campo"> Comienzo:<strong> {{eventoActual.objTurnos.fecha_Desde}}</strong> </label>
                                    <input type="datetime-local" v-model="eventoActual.objTurnos.fecha_Desde" 
                                            class="form-control form-control-sm inputChico">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="" class="form-label campo">Fin:<strong>{{eventoActual.objTurnos.fecha_Hasta}}</strong> </label>
                                    <input type="datetime-local" v-model="eventoActual.objTurnos.fecha_Hasta"
                                            value="eventoActual.objTurnos.fecha_Hasta" class="form-control form-control-sm inputChico">
                                </div>
                            </div>

                            <div>
                                <label for="" class="form-label campo"> Precio:</label>
                                <input type="text" class="form-control form-control-sm inputChico" v-model="eventoActual.objTurnos.precio">
                            </div>
                            <button class="btn btn-info divBotones" @click="Cancelar()">Guardar</button>
                            <button class="btn btn-light divBotones" @click="Cancelar()">Cancelar</button>
                        </div>
                    </div>
                </div>
            </div>
            
            <div v-if="accion == 'Borrar'">
                <h2>Borrando turno</h2>
            </div>
        </div>
    </div>
</template>

<script>
import apiRest from '../mixins/apiRest.vue'

export default {
    mixins: [apiRest],

    props: ['eventoActual'],

    created() {
        console.log(JSON.stringify(this.eventoActual))
        if (this.accion != 'Crear') {
            this.datosTurno.club_configuracion_id= localStorage.getItem('club');

            this.ObtenerDatos(`turnos/${this.datosTurno.club_configuracion_id}/show/${this.eventoActual.objTurnos.id}`)
                .then (res => {
                    this.datosTurno = res
                })

            this.traerClientes()
            this.traerCanchas()

        } 
        
    },

    data() {
        return {
            datosTurno: {
                cliente_id: 0,
                cancha_id: 0,
                club_configuracion_id: localStorage.getItem('club'),
                tipo_turno: "",
                fecha_Desde: "",
                fecha_Hasta: "",
                grupo: 0,
                precio: "",
            },

            clientes: [],
            canchas: [],

            accion: "",
            
            abrirFormTurnos: false,
        }
    },

    methods: {
        Cancelar() {
            this.$emit("SalirDeABMturnos", false)
        },

        desplegarABMturnos(accion) {
            this.accion = accion
            this.abrirFormTurnos = !this.abrirFormTurnos
        },
    
        traerClientes(){
            this.ObtenerDatos(`clientes/${this.datosTurno.club_configuracion_id}`)
                .then (res => {
                    this.clientes = res.clientes.data
                })
        },
        traerCanchas(){
            this.ObtenerDatos(`canchas/${this.datosTurno.club_configuracion_id}`)
                .then (res => {
                    this.canchas = res.canchas.data
                })
        },
    },

    
}
</script>

<style scoped>
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
  width: 550px;
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

.inputChico{
    width: 180px;
}
</style>