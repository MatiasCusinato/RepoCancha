<template>
    <div>
        <h1 class="bg-success text-white text-center mb-3"> Clientes </h1>
        <!-- <div>
            <span>{{this.paginacion}}</span>
        </div> -->
        <div>
            <div class="divFiltros">
                <h4>Filtros:</h4>
                <div class="row justify-content-md-center">
                    <div class="row justify-content-evenly g-2">
                        <input type="text" placeholder="Filtro por nombre" 
                            v-model="filtroNombre" maxlength="20" class="form-control">

                        <button type="button" class="btn btn-secondary btn-sm col-4" @click="traerFiltro()">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div>
            <button class="btn btn-success" @click="desplegarABMcliente('Crear')" 
                    style="font-size: 22px"> 
                <i class="bi bi-person-plus-fill"> Agregar un nuevo Cliente </i> 
            </button>
        </div>
        <br>

        <ABMclientes v-if="abrirABMcliente"
            :accion=accion :id=id
            @SalirDeABMclientes = MostrarABMclientes($event)
        /><br>

        <div v-if="datos.length>0">
            <table class="table-success tablecli">
                <thead>
                    <tr class="bg-success">
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
                                <i class="bi bi-brush"></i>
                            </button>

                            <button class="btn btn-danger" @click="desplegarABMcliente('Borrar', clientes.id)">
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

    methods: {
        traerDatos(pagina) {
            console.log("Obteniendo CLIENTES desde la API ...");
            this.ObtenerDatos(`clientes/${this.$store.state.vClub}/8/?page=${pagina}`)
                .then(res => {
                    this.datos = res.clientes.data;
                    this.paginacion= res.paginacion
                }) 
        },

        desplegarABMcliente(accion, id=0) {
            this.accion = accion
            this.id = id
            this.abrirABMcliente = !this.abrirABMcliente;
        },
        
        MostrarABMclientes(ver) {
            this.abrirABMcliente = false
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

        traerFiltro(){
            if(this.filtroNombre){
                this.ObtenerDatos(`clientes/${this.$store.state.vClub}/nombre/${this.filtroNombre}`)
                    .then(res => {
                        if(res.clientes.length!=0){
                            this.datos = res.clientes;
                        } else{
                            this.$swal({
                                title: '¡Error!',
                                text: `No existe algun cliente con el nombre de "${this.filtroNombre}"`,
                                icon: 'error',
                                confirmButtonText: 'Ok',
                                timer: 2500
                            })

                            this.filtroNombre= ""
                            this.traerDatos(1);
                        }
                    })
            }else{
                this.$swal({
                    title: '¡Error!',
                    text: 'Rellene el campo de filtro, porfavor',
                    icon: 'warning',
                    confirmButtonText: 'Ok',
                    timer: 2500
                })
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
/* .btnganancias{
    font-size: 20px;
    left: 50px;
    width:120px;
    height:30px;
} */
.boton {
    position: relative;
    left: 200px;
    top: -54px;
}
</style>