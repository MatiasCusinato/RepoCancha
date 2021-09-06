<template>
    <div>
        <hr>
        {{accion}} Canchas
            <div>
                <label>Id:</label>
                <input type="text" v-model="datosCancha.id">
            </div>
            <div>
                <label> Id Club: </label>
                <input type="text" v-model="datosCancha.club_configuracion_id">
            </div>
            <div>
                <label> Deporte: </label>
                <input type="text" v-model="datosCancha.deporte">
            </div>
            <br>
            <div>
                <button @click="Aceptar()"> Aceptar </button>
                |
                <button @click="Cancelar()"> Cancelar </button>
            </div>
            <hr>
    </div>
</template>

<script>

import apiRest from "@/mixins/apiRest.vue"

export default {
    props: ['accion','id'],
    mixins: [apiRest],
    data() {
        return {
            datosCancha: {
                nombre: '',
                id: 0,
            }
        }
    },
    created() {
        console.log("evento created")
        if (this.accion != 'Crear') {
            this.ObtenerDatosPorId('canchas', this.id)
                .then (res => {
                    this.datosCancha = res
            })
        }
    },
    mounted() {
        console.log("evento mounted")
    },
    beforeDestroyed() {
        console.log("evento beforeDestroyed")
    },
    destroted() {
        console.log("evento destroyed")
    },
    methods: {
        Aceptar() {
            if (this.accion == 'Crear') {
                this.InsertarDatos ('canchas', this.datosCancha)
                    .then(res => {
                        if (res.id != 0) {
                            console.log('El registro fue ingresado con exito')
                        } else {
                            console.log('Error al ingresar el registro')
                        }
                        this.$emit('SalirDeABMcanchas', true)
                    })
            }
            if (this.accion == 'Modificar') {
                this.EditarDatos ('canchas', this.id, this.datosCancha)
                    .then(res => {
                        this.datosCancha = res
                        this.$emit('SalirDeABMcanchas', true)
                    })
            }
            if (this.accion == 'Eliminar') {
                this.EliminarDatos ('canchas', this.id)
                    .then(res => {
                        this.datosCancha = res
                        this.$emit('SalirDeABMcanchas', true)
                    })
            }
        },
        Cancelar() {
            this.$emit("SalirDeABMcanchas", false)
        },
    }
}
</script>