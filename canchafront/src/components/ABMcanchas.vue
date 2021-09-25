<template>
    <div>
        <hr>
        <p>{{accion}} Canchas</p>
            <form class="formABM">

                <div v-if="accion=='Borrar'">
                    <table class="table-bordered light-blue darken-2">
                        <thead>
                            <tr class="bg-primary text-light">
                                <th scope="col">ID</th>
                                <th scope="col">Club</th>
                                <th scope="col">Deporte</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row"> {{datosCancha.id}} </th>
                                <td> {{datosCancha.club_configuracion_id}} </td>
                                <td> {{datosCancha.deporte}} </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div v-if="accion=='Crear' || accion=='Editar'">
                    <!-- <div class="mb-3">
                        <label for="" class="form-label"> Id Club: </label>
                        <input type="text" class="form-control" v-model="datosCancha.club_configuracion_id">
                    </div> -->
                    <div class="mb-3">
                        <label for="" class="form-label"> Deporte </label>
                        <input type="text" class="form-control" v-model="datosCancha.deporte">
                    </div>
                </div>

                <div class="divBotones">
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
                //id: 0,
                deporte: "",
            }
        }
    },

    created() {
        console.log("evento created")
        if (this.accion != 'Crear') {
            let club = localStorage.getItem('club')
            this.ObtenerDatos(`canchas/${club}/${this.id}`)
                .then (res => {
                    this.datosCancha = res
            })
        }
    },

    methods: {
        Aceptar() {
            if(!this.validarCampos(this.datosCancha)){
                if (this.accion == 'Crear') {
                    let club=localStorage.getItem('club')
                    this.datosCancha.club_configuracion_id= club;
                    console.log(JSON.stringify(this.datosCancha))

                    this.InsertarDatos ('canchas/guardar', this.datosCancha)
                        .then(res => {
                            console.log(res)
                            if (res.id != 0) {
                                console.log('El registro fue ingresado con exito')
                            } else {
                                console.log('Error al ingresar el registro')
                            }
                            this.$emit('SalirDeABMcanchas', true)
                        })
                }

                if (this.accion == 'Editar') {
                    console.log(JSON.stringify(this.datosCancha))
                    this.EditarDatos ('canchas/editar', this.id, this.datosCancha)
                        .then(res => {
                            this.datosCancha = res
                            this.$emit('SalirDeABMcanchas', true)
                        })
                }

                if (this.accion == 'Borrar') {
                    /* this.EliminarDatos ('canchas', this.id)
                        .then(res => {
                            this.datosCancha = res
                            this.$emit('SalirDeABMcanchas', true)
                        }) */
                    this.EliminarDatos(`canchas/eliminar`, this.id, this.datosCancha)
                        .then(res => {
                            this.datosCancha = res
                            this.$emit('SalirDeABMcanchas', true)
                        }) 
                }
            }else{
                this.$swal({
                    title: '¡Formulario incompleto!',
                    text: 'Los siguientes campos estan vacios: '+ this.alertaFormulario,
                    icon: 'warning',
                    confirmButtonText: 'Ok'
                })
            }

            
        },

        Cancelar() {
            this.$emit("SalirDeABMcanchas", false)
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
.divBotones{
    margin: 20px 10px
}
</style>