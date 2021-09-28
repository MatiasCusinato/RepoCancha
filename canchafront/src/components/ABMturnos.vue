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
                        <input type="text" class="form-control form-control-sm" 
                                :value="Actual" readonly>
                    </div>    
                
                    <br>
                    <div >
                        <span><i class="bi bi-person"> Cliente: </i></span>
                        <input type="text" class="form-control form-control-sm" 
                                :value="NombreApellido" readonly>
                    </div>
                
                    <br>
                    <div>
                        <span>
                            <i class="bi bi-aspect-ratio"> Cancha: </i>
                        </span>
                        <input type="text" class="form-control form-control-sm" 
                                :value="Cancha" readonly>
                    </div>

                    <br>
                    <div>
                        <span><i class="bi bi-calendar2-day"> Comienzo: </i></span>
                        <input type="text" class="form-control form-control-sm" 
                                :value="Comienzo" readonly>
                    </div>

                
                    <br>
                    <div>
                        <span><i class="bi bi-calendar2-day"> Fin: </i></span>
                        <input type="text" class="form-control form-control-sm" :value="Fin" readonly>
                    </div>

                    <br>
                    <div>
                        <span><i class="bi bi-flag"> Tipo de turno </i></span>
                        <input type="text" class="form-control form-control-sm" 
                                :value="TipoTurno" readonly>
                    </div>

                    <br>
                    <div>
                        <span><i class="bi bi-currency-dollar"> Precio: </i></span>
                        <input type="text" class="form-control form-control-sm" 
                                :value="Precio" readonly>
                    </div>       

                    <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                        <div class="btn-group mr-2" role="group" aria-label="First group"
                                style="margin: -30px 50px 0px 10px">

                            <button type="button" class="botones btn btn-secondary" @click="Cancelar()">
                                <i class="bi bi-skip-start-fill"> </i>
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
                            <button class="cierre btn btn-primary" @click="desplegarABMturnos('Consultar')">
                                <font color="#ff0000">
                                    <i class="bi bi-x-circle-fill"></i>
                                </font>
                            </button>
                            <p>{{accion}} Turnos</p>
                        </div>

                        <div class="contenido">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="" class="form-label campo"><i class="bi bi-person"> Cliente: </i></label>
                                    <select name="cliente_id" v-model="datosTurno.cliente_id" 
                                                class="form-select" aria-label=".form-select-sm example">
                                        <option :value="eventoActual.objTurnos.cliente_id">
                                            {{eventoActual.objTurnos.cliente_id}}| {{eventoActual.objTurnos.nombre}} {{eventoActual.objTurnos.apellido}}
                                        </option>
                                        <option v-for="(cliente, $id) in clientes" 
                                            :key="$id"
                                            :value="cliente.id">
                                                {{cliente.id}}| {{cliente.nombre}} {{cliente.apellido}}
                                        </option>
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="" class="form-label campo"><i class="bi bi-aspect-ratio"> Cancha: </i></label>
                                    <select name="cancha_id" v-model="datosTurno.cancha_id" 
                                                class="form-select inputChico" aria-label=".form-select-sm example">
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
                            </div>

                            <div class="mb-3">
                                <label for="" class="form-label campo">
                                    <i class="bi bi-flag"> Tipo de turno </i>
                                </label>
                                <input type="text" class="form-control form-control-sm inputChico" 
                                        v-model="datosTurno.tipo_turno">
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="" class="form-label campo">
                                        <i class="bi bi-calendar2-day"> Comienzo: </i>
                                    </label>
                                    <input type="datetime-local" v-model="datosTurno.fecha_Desde" 
                                            class="form-control form-control-sm">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="" class="form-label campo">
                                        <i class="bi bi-calendar2-day"> Fin: </i> 
                                    </label>
                                    <input type="datetime-local" v-model="datosTurno.fecha_Hasta"
                                            class="form-control form-control-sm ">
                                </div>
                            </div>

                            <div>
                                <label for="" class="form-label campo">
                                    <i class="bi bi-currency-dollar"> Precio: </i>
                                </label>
                                <input type="text" class="form-control form-control-sm inputChico" 
                                        v-model="datosTurno.precio">
                            </div>
                            <div>
                                <button class="btn btn-primary divBotones" @click="Aceptar()">
                                    <i class="bi bi-check2-circle"> Guardar </i>
                                </button>
                                
                                <button class="btn btn-danger divBotones" @click="desplegarABMturnos('Consultar')">
                                    <i class="bi bi-x-circle-fill"> Cancelar </i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div v-if="accion == 'Borrar'">
                <h2>Borrando turno</h2>
                <div class="contenedor" v-if="accion=='Borrar'">
                    <div class="VentanaModalBorrar">
                        <div class="cabecera tituloventana">
                            <button class="cierre btn btn-primary" @click="desplegarABMturnos('Consultar')">
                                <font color="#35586F">X</font>
                            </button>
                            <p>{{accion}} Turnos</p>
                        </div>

                        <div class="contenido">
                            <div class="row">
                                <div class="col-md-5 mb-3">
                                    <label for="" class="form-label campo"> Cliente: </label>
                                    <input type="text" :value="NombreApellido" 
                                            class="form-control form-control-sm inputChico" readonly>
                                </div>

                                <div class="col-md-5 mb-3">
                                    <label for="" class="form-label campo"> Cancha: </label>
                                    <input type="text" :value="Cancha" 
                                            class="form-control form-control-sm inputChico" readonly>
                                </div>
                            </div>

                            <br>

                            <div class="mb-3">
                                <label for="" class="form-label campo"> Tipo de turno </label>
                                <input type="text" v-model="eventoActual.objTurnos.tipo_turno" readonly
                                        class="form-control form-control-sm inputChico">
                            </div>

                            <br>

                            <div class="row">
                                <div class="col-md-5 mb-3">
                                    <label for="" class="form-label campo"> 
                                        Comienzo:
                                    </label>
                                    <input type="datetime" v-model="eventoActual.objTurnos.fecha_Desde" 
                                            class="form-control form-control-sm inputChico" readonly>
                                </div>

                                <div class="col-md-5 mb-3">
                                    <label for="" class="form-label campo">
                                        Fin:
                                    </label>
                                    <input type="datetime" v-model="eventoActual.objTurnos.fecha_Hasta"
                                            class="form-control form-control-sm inputChico" readonly>
                                </div>
                            </div>

                            <!-- <div>
                                <label for="" class="form-label campo"> Precio:</label>
                                <input type="text" class="form-control form-control-sm inputChico" 
                                        v-model="eventoActual.objTurnos.precio">
                            </div> -->
                            <button class="btn btn-info divBotones" @click="Aceptar()">
                                Borrar
                            </button>

                            <button class="btn btn-light divBotones" @click="desplegarABMturnos('Consultar')">
                                Cancelar
                            </button>
                        </div>
                    </div>
                </div>
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
            let fechaActual = this.eventoActual.start.format('DD/MM/YYYY');
            return fechaActual + " "
        },

        NombreApellido() {
            let nombre = this.eventoActual.objTurnos.nombre;
            let apellido = this.eventoActual.objTurnos.apellido;
            return nombre + " " + apellido 
        },

        Cancha() {
            let cancha_id = this.eventoActual.objTurnos.cancha_id;
            let deporte = this.eventoActual.objTurnos.deporte;
            return cancha_id+ "| "+ deporte
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
        },
    },

    created() {
        console.log(JSON.stringify(this.eventoActual))
        if (this.accion != 'Crear') {
            this.datosTurno.club_configuracion_id= localStorage.getItem('club');

            /* this.ObtenerDatos(`turnos/${this.datosTurno.club_configuracion_id}/show/${this.eventoActual.objTurnos.id}`)
                .then (res => {
                    this.datosTurno = res
                    
                })

            let fechaDesde= this.eventoActual.objTurnos.fecha_Desde
            this.eventoActual.objTurnos.fecha_Desde= fechaDesde.replace(fechaDesde[10], 'T').slice(0, 16) */
            //this.traerTurno()
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

        Aceptar(){
            if(this.accion=='Editar'){
                console.log('El turno fue editado exitosamente')
                this.datosTurno.fecha_Desde = this.datosTurno.fecha_Desde.replace('T', ' ')+':00'
                this.datosTurno.fecha_Hasta = this.datosTurno.fecha_Hasta.replace('T', ' ')+':00'
                
                this.EditarDatos(`turnos/editar`, this.eventoActual.objTurnos.id, this.datosTurno)
                    .then(res => {
                        console.log(res)
                        if(res.msj=="Error"){
                            this.$swal({
                                title: '¡Error!',
                                text: ''+res.razon,
                                icon: 'error',
                                confirmButtonText: 'Ok'
                            })

                            this.$emit('SalirDeABMturnos', true)
                        } else {
                            this.$swal({
                                title: 'Turno editado!',
                                icon: 'success',
                                confirmButtonText: 'Ok'
                            })

                            this.$emit('SalirDeABMturnos', true)  
                        }
                    })
                
                console.log(this.datosTurno)
            }

            if(this.accion=='Borrar'){
                let turno_id = this.eventoActual.objTurnos.id
                this.EliminarDatos(`turnos/eliminar`, turno_id, this.datosTurno)
                        .then(res => {
                            console.log(res)
                            if(res.msj=="Error"){
                            this.$swal({
                                title: '¡Error!',
                                text: ''+res.razon,
                                icon: 'error',
                                confirmButtonText: 'Ok'
                            })

                            this.$emit('SalirDeABMturnos', true)
                        } else {
                            this.$swal({
                                title: 'Turno borrado!',
                                icon: 'success',
                                confirmButtonText: 'Ok'
                            })

                            this.$emit('SalirDeABMturnos', true)  
                        }
                        })
            }
        },

        desplegarABMturnos(accion) {
            this.accion = accion
            this.abrirFormTurnos = !this.abrirFormTurnos

            if(this.accion=='Consultar'){
                //this.traerTurno()
            }

            if(this.accion=='Editar'){
                //this.datosTurno.fecha_Desde = this.eventoActual.objTurnos.fecha_Desde.replace('T', ' ')+':00'
                let fechaDesde= this.eventoActual.objTurnos.fecha_Desde
                let fechaHasta= this.eventoActual.objTurnos.fecha_Hasta

                this.datosTurno.cliente_id = this.eventoActual.objTurnos.cliente_id
                this.datosTurno.cancha_id = this.eventoActual.objTurnos.cancha_id
                this.datosTurno.club_configuracion_id = this.eventoActual.objTurnos.club_configuracion_id
                this.datosTurno.tipo_turno = this.eventoActual.objTurnos.tipo_turno
                this.datosTurno.fecha_Desde = fechaDesde.replace(fechaDesde[10], 'T').slice(0, 16)
                this.datosTurno.fecha_Hasta = fechaHasta.replace(fechaHasta[10], 'T').slice(0, 16)
                this.datosTurno.grupo = this.eventoActual.objTurnos.grupo
                this.datosTurno.precio = this.eventoActual.objTurnos.precio
            }
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

        traerTurno(){
            this.ObtenerDatos(`turnos/${this.datosTurno.club_configuracion_id}/show/${this.eventoActual.objTurnos.id}`)
                .then (res => {
                    this.datosTurno = res
                })

            let fechaDesde= this.eventoActual.objTurnos.fecha_Desde
            this.eventoActual.objTurnos.fecha_Desde= fechaDesde.replace(fechaDesde[10], 'T').slice(0, 16)

            let fechaHasta= this.eventoActual.objTurnos.fecha_Hasta
            this.eventoActual.objTurnos.fecha_Hasta= fechaHasta.replace(fechaHasta[10], 'T').slice(0, 16)
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
    width: 600px;
    margin: 25px auto;
}

.VentanaModalBorrar {
  background-color: rgb(204, 124, 93);
  border-radius: 10px;
  padding: 28px;
  width: 500px;
  margin: 25px auto;
}

table{
    background-color: whitesmoke;
    margin: 0px 40px 10px;
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