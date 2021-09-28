<template>
    <div>
        <h1 class="bg-primary text-white text-center mb-3"> ABMTURNOS </h1>
        <br>
        <div class="divCard">
            <div class="card w-100" v-if="!abrirFormTurnos">
                <h5 class="card-header">Evento: {{ eventoActual.title }}</h5>
                <div class="card-body">
                    <!-- <h5 class="card-title"><i class="bi bi-calendar"> Fecha: {{ eventoActual.start && eventoActual.start.format('DD/MM/YYYY') }} </i></h5> -->
                    <div>
                        <span><i class="bi bi-calendar"> Fecha: </i></span>
                        <input type="text" class="form-control form-control-sm" :value="Actual" readonly>
                    </div>    
                    
                    <!-- <p class="card-text">
                        <strong><i class="bi bi-person"> Cliente: </i></strong>
                            {{ eventoActual.objTurnos.nombre }} 
                            {{ eventoActual.objTurnos.apellido }}
                    </p> -->
                    <br>
                    <div >
                        <span><i class="bi bi-person"> Cliente: </i></span>
                        <input type="text" class="form-control form-control-sm" :value="NombreApellido" readonly>
                    </div>
                
                    <!-- <p class="card-text">
                        <strong><i class="bi bi-aspect-ratio"> Cancha: </i></strong> {{ eventoActual.objTurnos.cancha_id }}
                    </p> -->
                    <br>
                    <div>
                        <span><i class="bi bi-aspect-ratio"> Cancha: </i></span>
                        <input type="text" class="form-control form-control-sm" :value="Cancha" readonly>
                    </div>

                    <!-- <p class="card-text">
                        <strong><i class="bi bi-calendar2-day"> Comienzo: </i></strong> {{ eventoActual.objTurnos.fecha_Desde }}
                    </p> -->
                    <br>
                    <div>
                        <span><i class="bi bi-calendar2-day"> Comienzo: </i></span>
                        <input type="text" class="form-control form-control-sm" :value="Comienzo" readonly>
                    </div>

                    <!-- <p class="card-text">
                        <strong><i class="bi bi-calendar2-day"> Fin: </i></strong> {{ eventoActual.objTurnos.fecha_Hasta }}
                    </p> -->
                    <br>
                    <div>
                        <span><i class="bi bi-calendar2-day"> Fin: </i></span>
                        <input type="text" class="form-control form-control-sm" :value="Fin" readonly>
                    </div>

                    <!-- <p class="card-text">
                        <strong><i class="bi bi-flag"> Tipo turno: </i></strong> {{ eventoActual.objTurnos.tipo_turno }}
                    </p> -->
                    <br>
                    <div>
                        <span><i class="bi bi-flag"> Tipo de turno </i></span>
                        <input type="text" class="form-control form-control-sm" :value="TipoTurno" readonly>
                    </div>

                    <!-- <p class="card-text">
                        <strong><i class="bi bi-currency-dollar"> Precio: </i></strong> ${{ eventoActual.objTurnos.precio }}
                    </p> -->
                    <br>
                    <div>
                        <span><i class="bi bi-currency-dollar"> Precio: </i></span>
                        <input type="text" class="form-control form-control-sm" :value="Precio" readonly>
                    </div>       

                    <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                        <div class="btn-group mr-2" role="group" aria-label="First group"
                                style="margin: 0px 50px 0px 10px">

                            <button type="button" class="botones btn btn-secondary" @click="Cancelar()">
                                <i class="bi bi-skip-start-fill"></i>
                            </button>
                        </div>
                        <div class="btn-group mr-2" role="group" aria-label="Second group">
                            <button type="button" class="boton btn btn-success" @click="desplegarABMturnos('Editar')">Editar</button>
                            <button type="button" class="boton btn btn-danger" @click="desplegarABMturnos('Borrar')">Borrar</button>
                    </div>
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
                        <button class="cierre btn btn-primary" @click="desplegarABMturnos('Consultar')"><font color="#ff0000"><i class="bi bi-x-circle-fill"></i></font></button>
                        <p>{{accion}} Turnos</p>
                        </div>
                        <div class="contenido">
                            <div class="mb-3">
                                <label for="" class="form-label campo"><i class="bi bi-person"> Cliente: </i></label>
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
                                <label for="" class="form-label campo"><i class="bi bi-aspect-ratio"> Cancha: </i></label>
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
                                <label for="" class="form-label campo"><i class="bi bi-flag"> Tipo de turno </i></label>
                                <input type="text" class="form-control form-control-sm inputChico" v-model="eventoActual.objTurnos.tipo_turno">
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="" class="form-label campo"><i class="bi bi-calendar2-day"> Comienzo: </i><strong> {{eventoActual.objTurnos.fecha_Desde}}</strong> </label>
                                    <input type="datetime-local" v-model="eventoActual.objTurnos.fecha_Desde" 
                                            class="form-control form-control-sm inputChico">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="" class="form-label campo"><i class="bi bi-calendar2-day"> Fin: </i><strong>{{eventoActual.objTurnos.fecha_Hasta}}</strong> </label>
                                    <input type="datetime-local" v-model="eventoActual.objTurnos.fecha_Hasta"
                                            value="eventoActual.objTurnos.fecha_Hasta" class="form-control form-control-sm inputChico">
                                </div>
                            </div>

                            <div>
                                <label for="" class="form-label campo"><i class="bi bi-currency-dollar"> Precio: </i></label>
                                <input type="text" class="form-control form-control-sm inputChico" v-model="eventoActual.objTurnos.precio">
                            </div>
                            <div>
                                <button class="btn btn-primary divBotones" @click="Cancelar()"> <i class="bi bi-check2-circle"> Guardar </i></button>
                                <button class="btn btn-danger divBotones" @click="Cancelar()"><i class="bi bi-x-circle-fill"> Cancelar </i></button>
                            </div>
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
    
    computed: {
        Actual() {
            let fechActual = this.eventoActual.start.format('DD/MM/YYYY');
            return fechActual + " "
        },
        NombreApellido() {
            let nombre = this.eventoActual.objTurnos.nombre;
            let apellido = this.eventoActual.objTurnos.apellido;
            return nombre + " " + apellido 
        },
        Cancha() {
            let cancha = this.eventoActual.objTurnos.cancha_id;
            return cancha + " "
        },
        Comienzo() {
            let comienzo = this.eventoActual.objTurnos.fecha_Desde;
            return comienzo + " "
        },
        Fin() {
            let fin = this.eventoActual.objTurnos.fecha_Hasta;
            return fin + " "
        },
        TipoTurno() {
            let tipoTurno = this.eventoActual.objTurnos.tipo_turno;
            return tipoTurno + " "
        },
        Precio(){
            let precio = this.eventoActual.objTurnos.precio;
            return precio + " "
        }
    },

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
    margin: 10px 25px 0px;
    position: relative;
    left: 105px;
    top: 10px;
}

.boton {
    top: 2px;
    left: 70px;
    margin: 20px;
}

.botones {
    left: 20px;
    top: 58px;
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