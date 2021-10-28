<template>
    <div>
        <h1 class="bg-primary text-white text-center mb-3"> Canchas </h1>

        <div class="divFiltros">
            <h4>Filtros:</h4>
            <input type="text" placeholder="Filtro por deporte" v-model="filtroDeporte" maxlength="20">
            <button type="button" class="boton btn btn-secondary btn-sm" @click="FiltroCanchas()">
                <i class="bi bi-search"></i>
            </button>
        </div>


        <br>
        <button class="btn btn-success" @click="desplegarABMcancha('Crear')" style="font-size: 22px"> 
            <i class="bi bi-aspect-ratio"> Agregar nueva Cancha </i> 
        </button>
        <br>
        <ABMcanchas
            v-if="abrirABMcancha"
            :accion=accion
            :id=id
            @SalirDeABMcanchas = MostrarABMcanchas($event)
        />
        <br>  <!-- table table-dark table-striped mt-4 -->
            <table class="light-blue darken-2">
                <thead>
                    <tr class="bg-primary text-light">
                        <th scope="col">ID</th>
                        <!-- <th scope="col">Club</th> -->
                        <th scope="col">Deporte</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(canchas, index) in datos" :key="index">
                        <th scope="row">{{canchas.id}}</th>
                        <!-- <td> {{canchas.club_configuracion_id}} </td> -->
                        <td> {{canchas.deporte}} </td>

                        <td>
                            <button class="btn btn-info" @click="desplegarABMcancha('Editar', canchas.id)">
                                <i class="bi bi-brush"></i>
                            </button>

                            <button class="btn btn-danger" @click="desplegarABMcancha('Borrar', canchas.id)">
                                <i class="bi bi-trash-fill"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table> 

            <br>

            <nav aria-label="Page navigation example">
                <ul class="pagination pagination-lg">
                    <li class="page-item" v-if="paginacion.current_page > 1">
                        <a class="page-link" href="#" 
                            @click.prevent="cambiarPagina(paginacion.current_page - 1)">
                                <i class="bi bi-skip-start-fill"></i>
                        </a>
                    </li>

                    <li class="page-item" v-for="(pagina, id) in NumeroPaginas" :key="id"
                            :class="pagina==paginaActiva ? 'active' : ''">
                        <a class="page-link" href="#" @click.prevent="cambiarPagina(pagina)">{{pagina}}</a>
                    </li>

                    <li class="page-item" v-if="paginacion.current_page < paginacion.last_page">
                        <a class="page-link" href="#"
                            @click.prevent="cambiarPagina(paginacion.current_page + 1)">
                                <i class="bi bi-skip-end-fill"></i>
                        </a>
                    </li>
                </ul>
            </nav>
    </div>
</template>

<script>
import apiRest from "../mixins/apiRest.vue"
import ABMcanchas from "../components/ABMcanchas.vue"
export default {

    mixins: [apiRest],

    components: {
        ABMcanchas
    },

    data() {
        return {
            datos: [],

            filtroDeporte: "",

            abrirABMcancha: false,

            accion: '',

            id: 0,

            paginacion: {
                total: 0,
                current_page: 0,
                per_page: 0,
                last_page: 0,  
                from: 0,        
                to: 0,
            },

            offset: 2,
        }
    },

    created() {
        this.traerDatos(1)
    },

    mounted() {
        console.log("evento mounted")
        //this.traerDatos()
    },

    methods: {
        traerDatos(pagina) {
            console.log("Obteniendo CANCHAS desde la API ...");

            this.ObtenerDatos(`canchas/${this.$store.state.vClub}/4/?page=${pagina}`)
                .then(res => {
                    this.datos = res.canchas.data;
                    this.paginacion = res.paginacion
            })
    
        },

        desplegarABMcancha(accion, id=0) {
            this.accion = accion,
            this.id = id,
            this.abrirABMcancha = !this.abrirABMcancha;
        },

        MostrarABMcanchas(ver) {
            this.abrirABMcancha = false 
            if (ver == true) {
                this.traerDatos();
            }
        },

        cambiarPagina(pagina){
            if(pagina != this.paginacion.current_page){
                this.paginacion.current_page = pagina;
                this.traerDatos(pagina)
            }
        },

        FiltroCanchas(){
            if(this.filtroDeporte){
                this.ObtenerDatos(`canchas/${this.$store.state.vClub}/deporte/${this.filtroDeporte}`)
                    .then(res => {
                        if(res.canchas.length!=0){
                            this.datos = res.canchas;
                        } else{
                            this.$swal({
                                title: '¡Error!',
                                text: `No existe algun deporte con el nombre de "${this.filtroDeporte}"`,
                                icon: 'error',
                                confirmButtonText: 'Ok'
                            })

                            this.filtroDeporte= ""
                            this.traerDatos();
                        }
                    })
            } else {
                this.$swal({
                    title: '¡Error!',
                    text: 'Rellene el campo de filtro, porfavor',
                    icon: 'warning',
                    confirmButtonText: 'Ok'
                })
            }

        },



    },

    computed: {
        paginaActiva(){
            return this.paginacion.current_page
        },
    
        NumeroPaginas(){
            if(!this.paginacion.to){
                return []
            }

            let from = this.paginacion.current_page - this.offset;
            if(from < 1){
                from= 1;
            }

            let to= from + (this.offset  * 2);
            if(to >= this.paginacion.last_page){
                to= this.paginacion.last_page
            }

            let paginasArray= [];
            while(from <= to){
                paginasArray.push(from)
                from++;
            }

            return paginasArray;
        },
    },
}    
</script>

<style scoped>
h1 {
    position: relative;
    left: -30px;
    text-align: center;
    border-style: solid;
    border-width: 2px;
    font-size: 50px;
    font-family: -webkit-body;
    color: blue;
    /* position: absolute;
    left: 140px;
    top: 140px; */
}
/* .div-table{
    display: block;
    margin: 10px 40px;
    align-content: center;
    text-align: center;
    float: left;
}  */
    table, th, td{
    border: 2px solid rgb(116, 113, 113);
    border-collapse: collapse;
    /* margin:10px auto 10px auto; */
    padding: 18px;
    margin: 15px -50px; 
    text-align: center;
    border-width: 2px;
    font-size: 15px;
} 
.divFiltros {
    /* border: 2px solid rgb(116, 113, 113);*/
    border: 2px black solid;
    border-radius: 10px;
    border-collapse: collapse;
    min-height: 100px;
    height: 105px;
    width: 305px;
    margin: 20px -40px;
    padding: 20px 40px;
    background-color:rgb(243, 214, 159);
    position: relative;
    left: 10px;
}
.boton {
    position: relative;
    left: 200px;
    top: -30px;
}
.btncli {
    position: absolute;
    border-radius: 10px;
    display: flex;
    flex-direction: column;
}
</style>