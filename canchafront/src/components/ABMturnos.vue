<template>
    <div>
        
        <h1 class="bg-primary text-white text-center mb-3"> ABMTURNOS </h1>
            <div v-if="!abrirFormTurnos && accionAux=='Consultar'">
                <div class="contenedor">
                    <div class="VentanaModalConsultar">
                        <div class="cabecera tituloventana">
                            <h5>Evento: {{ eventoActual.title }}</h5>
                            <div>
                                <!-- <h5 class="card-title"><i class="bi bi-calendar"> Fecha: {{ eventoActual.start && eventoActual.start.format('DD/MM/YYYY') }} </i></h5> -->
                                <div>
                                    <span><i class="bi bi-calendar"> Fecha: </i></span>
                                    <input type="text" class="form-control form-control-sm" 
                                            :value="Actual" readonly>
                                </div>    
                    
                                <div >
                                    <span><i class="bi bi-person"> Cliente: </i></span>
                                    <input type="text" class="form-control form-control-sm" 
                                            :value="NombreApellido" readonly>
                                </div>
                            
                                <div>
                                    <span>
                                        <i class="bi bi-aspect-ratio"> Cancha: </i>
                                    </span>
                                    <input type="text" class="form-control form-control-sm" 
                                            :value="Cancha" readonly>
                                </div>

                                <div>
                                    <span><i class="bi bi-calendar2-day"> Comienzo: </i></span>
                                    <input type="text" class="form-control form-control-sm" 
                                            :value="Comienzo" readonly>
                                </div>

                                <div>
                                    <span><i class="bi bi-calendar2-day"> Fin: </i></span>
                                    <input type="text" class="form-control form-control-sm" :value="Fin" readonly>
                                </div>

                                <div>
                                    <span><i class="bi bi-flag"> Tipo de turno </i></span>
                                    <input type="text" class="form-control form-control-sm" 
                                            :value="TipoTurno" readonly>
                                </div>

                                <div>
                                    <span><i class="bi bi-currency-dollar"> Precio: </i></span>
                                    <input type="text" class="form-control form-control-sm" 
                                            :value="Precio" readonly>
                                </div>

                                <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                                    <div class="btn-group mr-2" role="group" aria-label="First group"
                                        style="margin: -30px 50px 0px 10px">
                                        <button type="button" class="botones btn btn-secondary" @click="Cancelar()">
                                            <i class="bi bi-skip-start-fill"></i>
                                        </button>
                                    </div>

                                    <div class="btn-group mr-2" role="group" aria-label="Second group">
                                        <button class="boton btn btn-success" @click="desplegarABMturnos('Editar')">Editar</button>
                                        <button class="boton btn btn-danger" @click="desplegarABMturnos('Borrar')">Borrar</button>
                                    </div>
                                </div>    
                            </div>
                        </div>
                    </div>
                </div>
            </div>    
        



        <!-- MODAL CREAR/EDITAR -->
        <div v-if="abrirFormTurnos">
            <div v-if="accionAux=='Editar' || accionAux=='Crear'">
                <div class="contenedor" >
                    <div :class="accionAux=='Editar' ? 'VentanaModalEditar' : 'VentanaModalCrear'">
                        <div class="cabecera tituloventana">
                            <button class="cierre btn btn-primary" @click="desplegarABMturnos('Consultar')" v-if="accion=='Editar'">
                                <font color="#ff0000">
                                    <i class="bi bi-x-circle-fill"></i>
                                </font>
                            </button>
                            <button class="cierre btn btn-primary" @click="Cancelar()" v-if="accion=='Crear'">
                                <font color="#ff0000">
                                    <i class="bi bi-x-circle-fill"></i>
                                </font>
                            </button>
                            <p>{{accionAux}} Turnos</p>
                        </div>

                        <div class="contenido">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="" class="form-label campo"><i class="bi bi-person"> Cliente: </i></label>
                                    <select name="cliente_id" v-model="datosTurno.cliente_id" 
                                            class="form-select" aria-label=".form-select-sm example">

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

                            <div>
                                <div v-if="accionAux=='Editar'" class="row">
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

                                <div v-if="accionAux=='Crear'" class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="" class="form-label campo">
                                            <i class="bi bi-calendar2-day"> Comienzo: </i>
                                        </label>
                                        <input type="datetime-local" v-model="datosTurno.fecha_Desde" 
                                                class="form-control form-control-sm">
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="" class="form-label campo">
                                            <i class="bi bi-calendar2-day"> Comienzo: </i>
                                        </label>
                                        <input type="datetime-local" v-model="datosTurno.fecha_Hasta" 
                                                class="form-control form-control-sm">
                                    </div>

                                    <!-- <div class="col-md-6 mb-3">
                                        <label for="" class="form-label campo">
                                            <i class="bi bi-alarm"> Duracion del turno: </i> 
                                        </label>
                                        <select name="cancha_id" v-model="horasIntervalo" 
                                            class="form-select inputChico" aria-label=".form-select-sm example">
                                            <option value="1">
                                                1 hora
                                            </option>
                                            <option value="1.5">
                                                1 hora con 30 minutos
                                            </option>
                                            <option value="2">
                                                2 hora
                                            </option>
                                        </select>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="" class="form-label campo">
                                            <i class="bi bi-calendar2-day"> Fin: </i>
                                        </label>
                                        <input type="datetime-local" v-model="datosTurno.fecha_Hasta" 
                                                class="form-control form-control-sm">
                                    </div> -->
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
                                <button class="btn btn-primary divBoton" @click="Aceptar()">
                                    <i class="bi bi-check2-circle"> Guardar </i>
                                </button>
                                
                                <button class="btn btn-danger divBoton" 
                                        @click="accionAux=='Editar' ? desplegarABMturnos('Consultar') : Cancelar()">
                                    <i class="bi bi-x-circle-fill"> Cancelar </i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            



            <!-- MODAL BORRAR -->
            <div v-if="accionAux == 'Borrar'">
                <h2>Borrando turno</h2>
                <div class="contenedor" v-if="accionAux=='Borrar'">
                    <div class="VentanaModalBorrar">
                        <div class="cabecera tituloventana">
                            <button class="cierre btn btn-primary" @click="desplegarABMturnos('Consultar')">
                                <font color="#ff0000"><i class="bi bi-x-circle-fill"></i></font>
                            </button>
                            <p>{{accionAux}} Turnos</p>
                        </div>

                        <div class="contenido">
                            <div class="row">
                                <div class="col-md-5 mb-3">
                                    <label for="" class="form-label campo"><i class="bi bi-person"> Cliente: </i></label>
                                    <input type="text" :value="NombreApellido" 
                                            class="form-control form-control-sm inputChico" readonly>
                                </div>

                                <div class="col-md-5 mb-3">
                                    <label for="" class="form-label campo"><i class="bi bi-aspect-ratio"> Cancha: </i></label>
                                    <input type="text" :value="Cancha" 
                                            class="form-control form-control-sm inputChico" readonly>
                                </div>
                            </div>

                            <br>
                            <div class="mb-3">
                                <label for="" class="form-label campo"><i class="bi bi-flag"> Tipo de turno </i> </label>
                                <input type="text" v-model="eventoActual.objTurnos.tipo_turno" readonly
                                        class="form-control form-control-sm inputChico">
                            </div>

                            <br>
                            <div class="row">
                                <div class="col-md-5 mb-3">
                                    <label for="" class="form-label campo"> 
                                        <i class="bi bi-calendar2-day"> Comienzo: </i>
                                    </label>
                                    <input type="datetime" v-model="eventoActual.objTurnos.fecha_Desde" 
                                            class="form-control form-control-sm inputChico" readonly>
                                </div>

                                <div class="col-md-5 mb-3">
                                    <label for="" class="form-label campo">
                                        <i class="bi bi-calendar2-day"> Fin: </i>
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
                            <button class="btn btn-danger divBotones" @click="Aceptar()">
                                <i class="bi bi-check2-circle"> Borrar </i>
                            </button>

                            <button class="btn btn-primary divBotones" @click="desplegarABMturnos('Consultar')">
                                <i class="bi bi-x-circle-fill"> Cancelar </i>
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

    props: ['eventoActual', 'accion'],
    
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
        
        if (this.accionAux != '') {
            this.datosTurno.club_configuracion_id= localStorage.getItem('club');
            
            if(this.accionAux=='Crear'){
                this.desplegarABMturnos('Crear')
            }
        
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
                grupo: 1,
                precio: "",
            },

            fechaComienzo: "",
            horasIntervalo: "",


            clientes: [],
            canchas: [],

            alertaFormulario:[],

            accionAux: this.accion,
            
            abrirFormTurnos: false,
        }
    },

    methods: {
        Cancelar() {
            this.$emit("SalirDeABMturnos", false)
        },

        Aceptar(){
            if(this.accionAux=='Editar' || this.accionAux=='Crear'){
                if(!this.validarCampos(this.datosTurno)){
                    if(this.accionAux=='Crear'){
                        this.datosTurno.fecha_Desde= this.transformarFecha(this.datosTurno.fecha_Desde, 'enviar')
                        this.datosTurno.fecha_Hasta= this.transformarFecha(this.datosTurno.fecha_Hasta, 'enviar')
                        

                        console.log(this.datosTurno)
                        this.InsertarDatos ('turnos/guardar', this.datosTurno)
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
                                            title: 'Turno creado!',
                                            icon: 'success',
                                            confirmButtonText: 'Ok'
                                        })

                                        this.$emit('SalirDeABMturnos', true)  
                                    }
                                })
                        }

                        if(this.accionAux=='Editar'){
                            this.datosTurno.fecha_Desde= this.transformarFecha(this.datosTurno.fecha_Desde, 'enviar')
                            this.datosTurno.fecha_Hasta= this.transformarFecha(this.datosTurno.fecha_Hasta, 'enviar')
                            
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
                } else {
                    this.$swal({
                        title: '¡Formulario incompleto!',
                        text: 'Los siguientes campos estan vacios: '+ this.alertaFormulario,
                        icon: 'warning',
                        confirmButtonText: 'Ok'
                    })
                }            
            }

            if(this.accionAux=='Borrar'){
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
            this.accionAux = accion
            this.abrirFormTurnos = !this.abrirFormTurnos

            if(this.accionAux=='Editar'){

                let fechaDesde= this.eventoActual.objTurnos.fecha_Desde
                let fechaHasta= this.eventoActual.objTurnos.fecha_Hasta


                this.datosTurno.cliente_id = this.eventoActual.objTurnos.cliente_id
                this.datosTurno.cancha_id = this.eventoActual.objTurnos.cancha_id
                this.datosTurno.club_configuracion_id = this.eventoActual.objTurnos.club_configuracion_id
                this.datosTurno.tipo_turno = this.eventoActual.objTurnos.tipo_turno
                this.datosTurno.fecha_Desde = this.transformarFecha(fechaDesde, 'abm')
                this.datosTurno.fecha_Hasta = this.transformarFecha(fechaHasta, 'abm')
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

        transformarFecha(fecha, razon){
            if(razon=='abm'){
                //La fecha pasa de esto: 2018-11-14 10:00:00 a esto --> 2018-11-14T10:00 
                //  para poder mostrarla en input datetime-local
                fecha= fecha.replace(fecha[10], 'T').slice(0, 16)
            } else if(razon=='enviar'){
                //Metodo viceversa: La fecha pasa de esto: 2018-11-14T10:00 a esto --> 2018-11-14 10:00:00 para enviarla a la BD
                fecha= fecha.replace('T', ' ')+':00'
            }

            return fecha
        },

        validarCampos(objFormulario){
            this.alertaFormulario= [];
            for (let key in objFormulario) {
                    if(objFormulario[key] == ""){
                            this.alertaFormulario.push(' '+key.charAt(0).toUpperCase()+ key.slice(1))
                    }
            }

            if(this.alertaFormulario.length > 0){
                return true
            } else {
                return false
            }
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
    left: 75px;
    top: 10px;
}

.divBoton{
    margin: 10px 25px 0px;
    position: relative;
    left: 120px;
    top: 10px;
}

.boton {
    top: -10px;
    position: relative;
    left: -20px;
    margin: 20px 25px 0px;
}

.botones {
    top: 40px;
    left: 20px;
    padding: 8px;
    width: 50px;
    height: 40px;
} 

.contenedor{
    background-color: rgb(255, 255, 255) !important;
	position: fixed;
	top: 0px;
	left:0;
	width: 100%;
	height: 100%;
	background: rgba(0,0,0,0.5);
}

.VentanaModalCrear {
    background-color: rgb(85, 84, 167);
    border-radius: 10px;
    padding: 28px;
    width: 500px;
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

.VentanaModalConsultar {
    background-color: rgb(0, 128, 255);
    border-radius: 10px;
    padding: 28px;
    width: 400px;
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