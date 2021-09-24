<template>
    <div>
        <h1 class="bg-primary text-white text-center mb-3"> Clientes </h1>
        <!-- <div>
            <span>{{this.paginacion}}</span>
        </div> -->

        <div class="divFiltros">
            <h4>Filtros:</h4>
            <input type="text" placeholder="Filtro por nombre" v-model="filtroNombre">
            <button @click="traerFiltro()">
                Buscar
            </button>
        </div>

        <br>

        <div class="btncli">
            <button class="btn btn-primary" @click="desplegarABMcliente('Crear')" 
                    style="font-size: 22px"> 
                Agregar un nuevo Cliente 
            </button>
        </div>

        <br>
        <br>

        <ABMclientes v-if="abrirABMcliente"
            :accion=accion :id=id
            @SalirDeABMclientes = MostrarABMclientes($event)
        />
        <br>
            <table class="light-blue darken-2">
                <thead>
                    <tr class="bg-primary text-light">
                        <th scope="col">ID</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Apellido</th>
                        <th scope="col">Telefono</th>
                        <th scope="col">Edad</th>
                        <th scope="col">Email</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(clientes, index) in datos" :key="index">
                        <th scope="row">{{clientes.id}}</th>
                        <td> {{clientes.nombre}} </td>
                        <td> {{clientes.apellido}} </td>
                        <td> {{clientes.telefono}} </td>
                        <td> {{clientes.edad}} </td>
                        <td> {{clientes.email}} </td>

                        <td>
                            <button class="btn btn-info" @click="desplegarABMcliente('Editar', clientes.id)">
                                Editar
                            </button>

                            <button class="btn btn-danger" @click="desplegarABMcliente('Borrar', clientes.id)">
                                Borrar
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
                            @click.prevent="cambioPagina(paginacion.current_page - 1)">
                                Atras
                        </a>
                    </li>

                    <li class="page-item" v-for="(pagina, id) in NroPaginas" :key="id"
                            :class="pagina==paginaActiva ? 'active' : ''">
                        <a class="page-link" href="#" @click.prevent="cambioPagina(pagina)">{{pagina}}</a>
                    </li>

                    <li class="page-item" v-if="paginacion.current_page < paginacion.last_page">
                        <a class="page-link" href="#"
                            @click.prevent="cambioPagina(paginacion.current_page + 1)">
                                Siguiente
                        </a>
                    </li>
                </ul>
            </nav>   
    </div>
</template>

<script>
import apiRest from "../mixins/apiRest.vue"
import ABMclientes from "../components/ABMclientes.vue"

export default {
    
    mixins: [apiRest],

    components: {
        ABMclientes
    },

    data() {
        return {
            datos: [],
            
            filtroNombre:"",

            abrirABMcliente: false,

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
            console.log("Obteniendo CLIENTES desde la API ...");
            let club= localStorage.getItem('club')
            this.ObtenerDatos(`clientes/${club}?page=${pagina}`)
                .then(res => {
                    this.datos = res.clientes.data;
                    this.paginacion= res.paginacion
                }) 
        },

        desplegarABMcliente(accion, id=0) {
            this.accion = accion,
            this.id = id,
            this.abrirABMcliente = !this.abrirABMcliente;
        },
        
        MostrarABMclientes(ver) {
            this.abrirABMcliente = false
            if (ver == true) {
                this.traerDatos();
            }
        },

        cambioPagina(pagina){
            if(pagina != this.paginacion.current_page){
                this.paginacion.current_page = pagina;
                this.traerDatos(pagina)
            }
        },

        traerFiltro(){
            let club= localStorage.getItem('club')
            this.ObtenerDatos(`clientes/${club}/nombre/${this.filtroNombre}`)
                .then(res => {
                    if(res.clientes.length!=0){
                        this.datos = res.clientes;
                    } else{
                        alert(`No existe algun cliente con el nombre de "${this.filtroNombre}"`)
                        this.traerDatos();
                    }
                })
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
    margin: 15px -300px;
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
    margin: 10px;
    padding: 20px 40px;
    background-color:rgb(243, 214, 159);
}
.btncli {
    position: absolute;
    border-radius: 10px;
    display: flex;
    flex-direction: column;
}
</style>