<template>
    <div>
        <h1 class="bg-primary text-white text-center mb-3"> ABMTURNOS </h1>

        <div v-if="!abrirFormTurnos && accionAux=='Consultar'">
            <div class="contenedor">
                <div class="VentanaModalConsultar">
                    <div class="cabecera tituloventana">
                        <h5 class="h5ABMTurnos">Evento: {{ eventoActual.title }}</h5>
                        <div class="container overflow-hidden gx-1">
                            <!-- <h5 class="card-title"><i class="bi bi-calendar"> Fecha: {{ eventoActual.start && eventoActual.start.format('DD/MM/YYYY') }} </i></h5> -->
                            <div class="row justify-content-md-center">
                                <div class="col-md-6 mb-3">
                                    <span><i class="bi bi-person campo"> Cliente: </i></span>
                                    <input type="text" class="form-control form-control-sm inputChico" 
                                            :value="NombreApellido" readonly>
                                </div>
                            
                                <div class="col-md-6 mb-3">
                                    <span><i class="bi bi-aspect-ratio campo"> Cancha: </i></span>
                                    <input type="text" class="form-control form-control-sm inputChico" 
                                            :value="Cancha" readonly>
                                </div>
                            </div>

                            <hr class="hrBarra">

                            <div class="row">
                                <div class="row justify-content-md-center">
                                    <span><i class="bi bi-calendar campo"> Fecha: </i></span>
                                    <input type="text" class="form-control  form-control-sm inputChico" 
                                            :value="FechaActual" readonly>
                                </div>    

                                <div class="row gy-2 justify-content-md-center">
                                    <div class="col-md-6 mb-3">
                                        <span><i class="bi bi-hourglass-top campo"> Comienzo: </i></span>
                                        <input type="text" class="form-control form-control-sm inputChico" 
                                                :value="Comienzo" readonly>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <span><i class="bi bi-hourglass-bottom campo"> Fin: </i></span>
                                        <input type="text" class="form-control form-control-sm inputChico" 
                                                :value="Fin" readonly>
                                    </div>
                                </div>
                            </div>

                            <hr class="hrBarra">

                            <div class="row">                                  
                                <div>
                                    <span><i class="bi bi-flag campo"> Tipo de turno </i></span>
                                    <input type="text" class="form-control form-control-sm" 
                                            :value="TipoTurno" readonly>
                                </div>
                                
                                <div class="row gy-2 justify-content-md-center">
                                    <div class="col-md-6 mb-3">
                                        <span><i class="bi bi-currency-dollar campo"> Precio: </i></span>
                                        <input type="text" class="form-control form-control-sm inputChico" 
                                                :value="Precio" readonly>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <span><i class="bi bi-tags campo"> Estado: </i></span>
                                        <input type="text" class="form-control form-control-sm inputChico" 
                                                :value="Estado" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="row">                                  
                                <div class="row gy-1 justify-content-md-center">
                                    <div class="col-md-6 mb-3">
                                        <button class="btn btn-danger" style="margin: auto 10px" 
                                                @click="BorrarTurno()">
                                            <i class="bi bi-trash">
                                                Borrar
                                            </i>    
                                        </button>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <button class="btn btn-success" 
                                                @click="desplegarABMturnos('Editar')">
                                            <i class="bi bi-pencil-square">
                                                Editar
                                            </i>
                                        </button>
                                    </div>
                                </div>
                                
                                <div class="row justify-content-md-center">
                                    <button class="btn btn-secondary col-md-6 mb-3" @click="Cancelar()">
                                        <i class="bi-arrow-left-square">
                                            Atras
                                        </i>
                                    </button>
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
                <div class="contenedor">
                    <div :class="accionAux=='Editar' ? 'VentanaModalEditar' : 'VentanaModalCrear'">
                        <div class="cabecera tituloventana">
                            <button class="cierre btn btn-primary" @click="accionAux=='Editar'? desplegarABMturnos('Consultar'): Cancelar()">
                                <font color="#ff0000">
                                    <i class="bi bi-x-circle-fill"></i>
                                </font>
                            </button>
                            <p>{{AccionABM}} turno</p>
                        </div>

                        <div class="contenido">
                            <div class="row" v-if="accionAux=='Crear'">
                                <div class="col-md-6 mb-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault" @click="cambiarTurno()">
                                        <label class="form-check-label campo" for="flexSwitchCheckDefault">Turno fijo</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="" class="form-label campo">
                                        <i class="bi bi-person"> Cliente: </i>
                                    </label>

                                    <select name="cliente_id" v-model="datosTurno.cliente_id"
                                            class="form-select" aria-label=".form-select-sm example">
                                        <option v-for="(cliente, $id) in clientes" :key="$id"
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
                                <input type="text" 
                                        autofocus
                                        class="form-control form-control-sm" 
                                        v-model="datosTurno.tipo_turno"
                                        placeholder="Ej: Cumpleaños, entrenamiento, turno fijo de ...">
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
                                            <i class="bi bi-calendar2-day"> Fin: </i>
                                        </label>
                                        <input type="datetime-local" v-model="datosTurno.fecha_Hasta" 
                                                class="form-control form-control-sm">
                                    </div>

                                    <div class="col-md-6 mb-3" v-if="datosTurno.grupo > 1">
                                        <label for="" class="form-label campo">
                                            <i class="bi bi-calendar2-day"> Fin por intervalos: </i> 
                                        </label>
                                        <select name="cancha_id" v-model="datosTurno.fecha_Hasta" 
                                                class="form-select inputChico" aria-label=".form-select-sm example">
                                            <option :value="this.moment(datosTurno.fecha_Desde).add({weeks:3,hours:1}).format('YYYY-MM-DDTHH:mm')">
                                                    3 semanas
                                            </option>

                                            <option :value="this.moment(datosTurno.fecha_Desde).add({weeks:4,hours:1}).format('YYYY-MM-DDTHH:mm')">
                                                    4 semanas
                                            </option>

                                            <option :value="this.moment(datosTurno.fecha_Desde).add({months:1,hours:1}).format('YYYY-MM-DDTHH:mm')">
                                                    1 mes
                                            </option>

                                            <option :value="this.moment(datosTurno.fecha_Desde).add({months:2,hours:1}).format('YYYY-MM-DDTHH:mm')">
                                                    2 mes
                                            </option> 
                                        </select>
                                    </div>
                                </div>

                                <div class="row" v-if="turnoFijo && accionAux=='Crear'">
                                    <h4 class="campo">Seleccione los dias del turno fijo</h4>
                                    
                                    <div class="col-md-6 mb-3 divDias">
                                        <div class="form-check" v-for="(dia, id) in diasFijo" :key="id">
                                            <input v-model="datosTurno.diasFijo" :value="dia.diaEN"
                                                    class="form-check-input" type="checkbox" id="flexCheckDefault">
                                                    
                                            <label class="form-check-label campo" for="flexCheckDefault">
                                                {{dia.diaES}}
                                            </label>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="" class="form-label campo">
                                        <i class="bi bi-currency-dollar"> Precio: </i>
                                    </label>
                                    <input type="number" class="form-control form-control-sm inputChico" 
                                            v-model="datosTurno.precio"
                                            min="100" max="1000">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="" class="form-label campo"><i class="bi bi-tags"> Estado: </i></label>
                                    <select name="estado" v-model="datosTurno.estado" 
                                            class="form-select inputChico" aria-label=".form-select-sm example">
                                        
                                        <option v-for="(estado, $id) in estadosTurno" 
                                            :key="$id"
                                            :value="estado">
                                                {{estado}}
                                        </option>
                                    </select>
                                </div>
                                
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
        </div>

        <!-- Modal Ganacia "consultar" -->
        <h1 class="bg-primary text-white text-center mb-3"> Ganancias </h1>
            <div v-if="!abrirGanancia && accionAux=='Consultar'">
                <div class="contenedor">
                    <div class="VentanaModalGanancia">
                        <div class="cabecera tituloventanaganancia">
                            <h5 class="h5ABMGanacia"> Ganancia </h5>
                            <div class="container overflow-hidden gx-1">
                                    <div class="row">    
                                    <div class="row gy-2 justify-content-md-center">
                                        <div class="col-md-6 mb-3">
                                            <span><i class="bi bi-hourglass-top campo"> Comienzo: </i></span>
                                            <input type="date" class="form-control form-control-sm inputChico" 
                                                    v-model="objganancia.fecha_Desde">
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <span><i class="bi bi-hourglass-bottom campo"> Fin: </i></span>
                                            <input type="date" class="form-control form-control-sm inputChico" 
                                                    v-model="objganancia.fecha_Hasta">
                                        </div>
                                    </div>
                                </div>
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                                <button class="btn btn-primary" @click="EnviarGanacia()">
                                                        <i class="bi bi-check2-circle"> Enviar </i>
                                                </button>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                                <button class="btn btn-danger" @click="Cancelar()">
                                                        <i class="bi bi-x-circle-fill"> Atras </i>
                                                </button>
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

    props: ['eventoActual', 'accion'],
    
    computed: {
        AccionABM(){
            let accion = this.accionAux.replace('ar', 'ando');
            return accion
        },

        FechaActual() {
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
            let comienzo = moment(this.eventoActual.objTurnos.fecha_Desde).format("HH:mm");
            return comienzo + " hrs."
        },

        Fin() {
            let fin = moment(this.eventoActual.objTurnos.fecha_Hasta).format("HH:mm");
            return fin + " hrs."
        },

        TipoTurno() {
            let tipoTurno = this.eventoActual.objTurnos.tipo_turno;
            return tipoTurno + " "
        },

        Precio(){
            let precio = this.eventoActual.objTurnos.precio;
            return precio + " "
        },
        Estado(){
            let estado = this.eventoActual.objTurnos.estado;
            return estado + " "
        },
    },

    created() {
        console.log(JSON.stringify(this.eventoActual))
        
        if (this.accionAux != '') {
            this.datosTurno.club_configuracion_id= localStorage.getItem('club');
            
            if(this.accionAux=='Crear'){
                this.desplegarABMturnos('Crear')
            }
            if(this.accionAux=='Consultar'){
                this.desplegarABMturnos('Consultar')
            }
        
            this.traerClientes()
            this.traerCanchas()
        } 
    },

    data() {
        return {
            moment: moment,

            datosTurno: {
                cliente_id: 0,
                cancha_id: 0,
                club_configuracion_id: this.$store.state.vClub,
                tipo_turno: "",
                fecha_Desde: moment().format('YYYY-MM-DDTHH:mm'),
                fecha_Hasta: moment().add(1, 'hours').format('YYYY-MM-DDTHH:mm'),
                grupo: 1,
                precio: "",
                estado: "",
                diasFijo:[],
                token: this.$store.state.vToken,
            },

            arrIntervalos: [],
            turnoFijo: false,
            diasFijo: [
                {diaES: "Lunes", diaEN: "Mon"}, 
                {diaES: "Martes", diaEN: "Tue"}, 
                {diaES: "Miercoles", diaEN: "Wed"}, 
                {diaES: "Jueves", diaEN: "Thu"}, 
                {diaES: "Viernes", diaEN: "Fri"}, 
                {diaES: "Sabado", diaEN: "Sat"}, 
                {diaES: "Domingo", diaEN: "Sun"}
            ],

            estadosTurno: ["Reservado", "Cobrado", "Adeudado"],

            clientes: [],
            canchas: [],
    

            alertaFormulario:[],

            accionAux: this.accion,
            fechaDesdeAux: "",
            fechaHastaAux: "",
            
            abrirFormTurnos: false,

            abrirGanancia: false,

            objganancia: { 
                club_configuracion_id: this.$store.state.vClub,
                fecha_Desde: moment().format('YYYY-MM-DDTHH:mm'),
                fecha_Hasta: moment().format('YYYY-MM-DDTHH:mm'),
            },

            numGanancia: "",
        }
    },

    methods: {
        cambiarTurno(){
            this.turnoFijo=!this.turnoFijo
            if(this.turnoFijo){
                this.datosTurno.grupo= 11;
            } else{
                this.datosTurno.grupo= 1;
            }
        },

        BorrarTurno(){
            this.$swal.fire({
                title: 'Borrando el turno',
                showCancelButton: true,
                showDenyButton: true,
                confirmButtonText: 'Borrar solo el turno',
                denyButtonText: 'Borrar todo los turnos fijos',
                cancelButtonText: 'Cancelar',
            }).then((result) => {
                let grupo= ""+this.eventoActual.objTurnos.grupo;
                let turno_id= ""+ this.eventoActual.objTurnos.id;
                let grupo_turno_id = "";

                result.isConfirmed ? grupo_turno_id= grupo+"/"+turno_id : grupo_turno_id= grupo;
                
                if((result.isDenied) && (this.eventoActual.objTurnos.grupo <= 1)){
                    this.$swal({
                        title: '¡Error!',
                        text: 'No se pueden eliminar todos los turnos normales (grupo 1)',
                        icon: 'error',
                        confirmButtonText: 'Ok'
                    })

                    return
                } else if(result.dismiss){
                    return  
                }

                this.EliminarDatos(`turnos/eliminar`, grupo_turno_id, this.datosTurno)
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
                                    title: 'Turno/s borrado!',
                                    icon: 'success',
                                    confirmButtonText: 'Ok'
                                })

                                this.$emit('SalirDeABMturnos', true)  
                            }
                        })
            })
        },

        Cancelar() {
            this.$emit("SalirDeABMturnos", false)
        },

        Aceptar(){
            if(this.accionAux=='Editar' || this.accionAux=='Crear'){
                this.datosTurno.fecha_Desde= this.transformarFecha(this.datosTurno.fecha_Desde, 'enviar')
                this.datosTurno.fecha_Hasta= this.transformarFecha(this.datosTurno.fecha_Hasta, 'enviar')

                this.fechaDesdeAux= this.transformarFecha(this.datosTurno.fecha_Desde, 'abm')
                this.fechaHastaAux= this.transformarFecha(this.datosTurno.fecha_Hasta, 'abm')

                if(this.datosTurno.grupo == 1){
                    this.datosTurno.diasFijo[0]= moment(this.datosTurno.fecha_Desde).format("ddd");
                }

                console.log(this.datosTurno)
                if(!this.validarCampos(this.datosTurno)){
                    if(this.accionAux=='Crear'){
                        this.InsertarDatos('turnos/guardar', this.datosTurno)
                                .then(res => {
                                    console.log(res)
                                    if(res.msj=="Error"){
                                        this.$swal({
                                            title: '¡Error!',
                                            text: ''+res.razon,
                                            icon: 'error',
                                            confirmButtonText: 'Ok'
                                        })

                                        //this.$emit('SalirDeABMturnos', true)
                                    } else {
                                        this.$swal({
                                            title: 'Turno creado!',
                                            text: ''+res.razon,
                                            icon: 'success',
                                            confirmButtonText: 'Ok'
                                        })

                                        this.$emit('SalirDeABMturnos', true)  
                                    }
                                })
                        }

                        if(this.accionAux=='Editar'){  
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
                        title: '¡Error en el formulario!',
                        text: 'Errores:'+ this.alertaFormulario,
                        icon: 'warning',
                        confirmButtonText: 'Ok'
                    })   
                }

                this.datosTurno.fecha_Desde= this.fechaDesdeAux
                this.datosTurno.fecha_Hasta= this.fechaHastaAux
                /* this.datosTurno.fecha_Desde= this.transformarFecha(this.fechaDesdeAux, 'abm')
                this.datosTurno.fecha_Hasta= this.transformarFecha(this.fechaHastaAux, 'abm') */
            }
            
        },

        EnviarGanacia() {
            this.InsertarDatos("clubes/ganacias", this.objganancia)
                .then(res => {
                    console.log(res)
                    if(res.msj == "Error") {
                        this.$swal({
                            title: ''+res.msj,
                            text: ''+res.razon,
                            icon: 'error',
                            confirmButtonText: 'Ok'
                        }) 
                    } else {
                        this.$swal({
                            title: ''+res.msj,
                            text: 'Cant de Turnos cobrados: '+res.data.cant_turnos + ". Ganancia Total: $" + res.data.ganancia,
                            icon: 'info',
                            confirmButtonText: 'Ok'
                        })
                    }       
                })
                
                
        },
        
        

        desplegarABMturnos(accion) {
            this.accionAux = accion
            this.abrirFormTurnos = !this.abrirFormTurnos

            if(this.accionAux=='Editar'){

                let fechaDesde= this.eventoActual.objTurnos.fecha_Desde
                let fechaHasta= this.eventoActual.objTurnos.fecha_Hasta

                //console.log(moment(fechaDesde).format('YYYY-MM-DD'));
                //console.log(this.datosTurno.fecha_Desde);

                this.datosTurno.cliente_id = this.eventoActual.objTurnos.cliente_id
                this.datosTurno.cancha_id = this.eventoActual.objTurnos.cancha_id
                this.datosTurno.club_configuracion_id = this.eventoActual.objTurnos.club_configuracion_id
                this.datosTurno.tipo_turno = this.eventoActual.objTurnos.tipo_turno
                this.datosTurno.fecha_Desde = this.transformarFecha(fechaDesde, 'abm')
                this.datosTurno.fecha_Hasta = this.transformarFecha(fechaHasta, 'abm')
                this.datosTurno.grupo = this.eventoActual.objTurnos.grupo
                this.datosTurno.precio = this.eventoActual.objTurnos.precio
                this.datosTurno.diasFijo[0] = moment(this.transformarFecha(fechaDesde, 'abm')).format('ddd');
                this.datosTurno.estado = this.eventoActual.objTurnos.estado
                this.datosTurno.token = this.$store.state.vToken
            }
        },
    
        traerClientes(){
            this.ObtenerDatos(`clientes/${this.$store.state.vClub}`)
                .then (res => {
                    this.clientes = res.clientes.data
                })
        },

        traerCanchas(){
            this.ObtenerDatos(`canchas/${this.$store.state.vClub}`)
                .then (res => {
                    this.canchas = res.canchas.data
                })
        },

        transformarFecha(fecha, razon){
            if(razon=='abm'){
                //La fecha pasa de esto: 2018-11-14 10:00:00 a esto --> 2018-11-14T10:00 
                //  para poder mostrarla en input datetime-local
                //fecha= fecha.replace(fecha[10], 'T').slice(0, 16)
                fecha= moment(fecha).format('YYYY-MM-DDTHH:mm')
            } else if(razon=='enviar'){
                //Metodo viceversa: La fecha pasa de esto: 2018-11-14T10:00 a esto --> 2018-11-14 10:00:00 para enviarla a la BD
                //fecha= fecha.replace('T', ' ')+':00'
                fecha= moment(fecha).format('YYYY-MM-DD HH:mm:ss')
            }

            return fecha
        },

        validarCampos(objFormulario){
            this.alertaFormulario= [];
            for (let key in objFormulario) {
                    if( (objFormulario[key] == "") || (objFormulario[key] == 'Invalid date')){
                            this.alertaFormulario.push(' '+key.charAt(0).toUpperCase()+ key.slice(1)+' (campo vacio)')
                    }
            }

            //Valido si la Fecha1 es mayor a la Fecha2, o si la Fecha2 es anterior a la Fecha1 y por ultimo, si son iguales
            if(moment(this.datosTurno.fecha_Desde).format('x') > moment(this.datosTurno.fecha_Hasta).format('x') ||
                    moment(this.datosTurno.fecha_Hasta).format('x') < moment(this.datosTurno.fecha_Desde).format('x') ||
                        moment(this.datosTurno.fecha_Hasta).format('x') == moment(this.datosTurno.fecha_Desde).format('x')){
                            
                this.alertaFormulario+= ". Fechas invalidas o incorrectas"
            }
            
            //Valido que el turno NORMAL (reservado) tenga como duracion 24 horas
            if(this.datosTurno.estado == 'Reservado' && this.datosTurno.grupo == 1 
                    && moment(this.datosTurno.fecha_Hasta).isAfter(moment(this.datosTurno.fecha_Desde), 'day')){
                
                this.alertaFormulario+= ". El turno normal debe cumplir como maximo 24 hrs"
            }

            let a = moment(this.datosTurno.fecha_Hasta);
            let b = moment(this.datosTurno.fecha_Desde);
            /* console.log(a.diff(b, 'days') )
            console.log(a.diff(b, 'days') < 2) */

            //Valido que el turno FIJO, tenga como minimo una diferencia de 2 dias entre sus fechas
            if(this.datosTurno=='Reservado' && this.datosTurno.grupo >= 11 
                && a.diff(b, 'days') < 2){
                
                this.alertaFormulario+= ". El turno fijo debe cumplir como min 48 hrs"
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
    left: 50px;
    top: 10px;
}

/* .boton {
    top: -10px;
    position: relative;
    left: -20px;
    margin: 20px 25px 0px;
} */

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
    overflow-y: scroll;
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
    width: 450px;
    margin: 25px auto;
}
.VentanaModalGanancia {
    background-color: rgb(35, 155, 86 );
    border-radius: 10px;
    padding: 28px;
    width: 450px;
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

.tituloventanaganancia{
    text-align:center;
    color:black;
}

.campo{
	color: white;
    font-size: 20px;
}

.titulo{
	float:left;
	color: white;
}

.inputChico{
    width: 180px;
    margin: 3px;
}

.divDias{
    min-width: 50px;
    min-height: 100px;
    border-style: solid;
    border-color: whitesmoke;
    border-radius: 5%;
    padding: 2.5%;
}
.hrBarra{
    height: 10px;
    background-color: rgb(0, 0, 0);
    border-radius: 5px;
}

.h5ABMTurnos{
    border-radius: 10px;
    border-style: ridge;
    border-color: rgb(134, 186, 255);
    min-width: 10%;
    min-height: 20px;
    background-color: rgb(3, 7, 218);
}
.h5ABMGanacia{
    border-radius: 10px;
    border-style: ridge;
    border-color: rgb(134, 186, 255);
    min-width: 10%;
    min-height: 20px;
    background-color: rgb(125, 155, 241);
}

.btn {
    font-size: 20px;
    position: relative;
}
</style>