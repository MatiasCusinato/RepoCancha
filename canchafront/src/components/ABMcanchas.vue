<template>
    <div>
        <hr>
        <p>{{accion}} Canchas</p>
            <form class="formABM">
                <div class="mb-3">
                    <label for="" class="form-label"> Id Club: </label>
                    <input type="text" class="form-control" v-model="datosCancha.club_configuracion_id">
                </div>
                <div class="mb-3">
                    <label for="" class="form-label"> Deporte </label>
                    <input type="text" class="form-control" v-model="datosCancha.deporte">
                </div>
                <div>
                    <button @click="Aceptar()" class="btn btn-primary"> Aceptar </button>
                    |
                    <button @click="Cancelar()" class="btn btn-danger"> Cancelar </button>
                </div>
            </form>
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
            if (this.accion == 'Editar') {
                this.EditarDatos ('canchas', this.id, this.datosCancha)
                    .then(res => {
                        this.datosCancha = res
                        this.$emit('SalirDeABMcanchas', true)
                    })
            }
            if (this.accion == 'Borrar') {
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

<style scoped>
.formABM {
    border: 2px solid rgb(116, 113, 113);
    border-collapse: collapse;
    padding: 15px 32px;
}
p {
    font-size: 30px;
    font-family: "Times New Roman", Times, serif;
} 
</style>