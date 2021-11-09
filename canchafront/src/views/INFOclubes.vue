<template>
    <div>
        <h1 class="bg-info text-white text-center mb-3"> Clubes </h1>
        
        <div>
            <button class="btn btn-primary" @click="desplegarABMclubes('Crear')" 
                    style="font-size: 22px"> 
                <i class="bi bi-person-plus-fill"> Agregar un nuevo Club </i> 
            </button>
        </div>
        <br>

        <!-- <ABMclubes v-if="abrirABMclubes"
            :accion=accion :id=id
            @SalirDeABMclubes = MostrarABMclubes($event)
        /><br> -->

        <div class="row justify-content-md-center tableclub" v-if="datos.length>0">
            <table class="table-secondary">
                <thead>
                    <tr class="bg-info">
                        <th scope="col"> ID </th>
                        <th scope="col"> Nombre del club </th>
                        <th scope="col"> Razon Social </th>
                        <th scope="col"> Ubicacion </th>
                        <th scope="col"> Contacto </th>
                        <th scope="col"> Ultimo Grupo </th>
                        <th scope="col"> Cuit </th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(clubes, index) in datos" :key="index">
                        <th scope="row">{{clubes.id}}</th>
                        <td> {{clubes.nombre_club}} </td>
                        <td> {{clubes.razon_social}} </td>
                        <td> {{clubes.ubicacion}} </td>
                        <td> {{clubes.contacto}} </td>
                        <td> {{clubes.ultimo_grupo}} </td>
                        <td> {{clubes.cuit}} </td>

                        <td>
                            <button class="btn btn-info" @click="desplegarABMclubes('Editar', clubes.id)">
                                <i class="bi bi-brush"></i>
                            </button>

                            <button class="btn btn-danger" @click="desplegarABMclubes('Borrar', clubes.id)">
                                <i class="bi bi-trash-fill"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>     

            <br>

            <nav class="navcli" v-show="!accion" aria-label="Page navigation example">
                <ul class="pagination pagination-lg">
                    <li class="page-item" v-if="paginacion.current_page > 1">
                        <a class="page-link" href="#" 
                            @click.prevent="cambioPagina(paginacion.current_page - 1)">
                                <i class="bi bi-skip-start-fill"></i>
                        </a>
                    </li>

                    <li class="page-item" v-for="(pagina, id) in NroPaginas" :key="id"
                            :class="pagina==paginaActiva ? 'active' : ''">
                        <a class="page-link" href="#" @click.prevent="cambioPagina(pagina)">{{pagina}}</a>
                    </li>

                    <li class="page-item" v-if="paginacion.current_page < paginacion.last_page">
                        <a class="page-link" href="#"
                            @click.prevent="cambioPagina(paginacion.current_page + 1)">
                                <i class="bi bi-skip-end-fill"></i>
                        </a>
                    </li>
                </ul>
            </nav>  
        </div>
    </div>
</template>

<script>
import apiRest from "../mixins/apiRest.vue"
/* import ABMclientes from "../components/ABMclientes.vue" */

export default {
    
    mixins: [apiRest],

    /* components: {
        ABMclientes
    }, */

    data() {
        return {
            datos: [],

            /* abrirABMcliente: false, */

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

    methods: {
        traerDatos() {
            console.log("Obteniendo CLUBES desde la API ...");
            this.ObtenerDatos(`clubes`)
                .then(res => {
                    this.datos = res.clubes.data;
                    this.paginacion= res.paginacion
                }) 
        },

        desplegarABMclubes(accion, id=0) {
            this.accion = accion
            this.id = id
            this.abrirABMclubes = !this.abrirABMclubes;
        },
        
        MostrarABMclubes(ver) {
            this.abrirABMclubes = false
            if (ver == true) {
                this.traerDatos();
            }

            this.accion=''
        },

        cambioPagina(pagina){
            if(pagina != this.paginacion.current_page){
                this.paginacion.current_page = pagina;
                this.traerDatos(pagina)
            }
        },
    },

    computed: {
        paginaActiva(){
            return this.paginacion.current_page
        },
    
        NroPaginas(){
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

            let paginasArr= [];
            while(from <= to){
                paginasArr.push(from)
                from++;
            }

            return paginasArr;
        },
    },
}
</script>

<style scoped>
h1 {
    left: -5px;
    position: relative;
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
    margin:10px auto 10px auto;
    padding: 18px;
    margin: 15px -240px;
    text-align: center;
    border-width: 2px;
    font-size: 22px;
    margin-left: -300px;
    margin-right: auto;
}   
.divFiltros {
    border: 2px black solid;
    border-radius: 10px;
    border-collapse: collapse;
    min-height: 130px;
    min-width: 100px;
    margin: 20px 0px 20px -30px;
    padding: 20px 40px;
    background-color:rgb(243, 214, 159);
    position: relative;
    left: 10px;
}
.boton {
    position: relative;
    left: 200px;
    top: -54px;
}

nav{
    margin-left: -300px;
}
.tableclub{
    margin-left: 280px;
}
</style>