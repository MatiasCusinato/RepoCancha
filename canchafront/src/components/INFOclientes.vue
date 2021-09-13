<template>
    <div>
        <h1 class="bg-primary text-white text-center mb-3"> Clientes </h1>
        <br>
        <div class="divFiltros">
            <h4>Filtros:</h4>
            <input type="text" placeholder="Filtro por nombre">
        </div>
        <br>
        <div class="btncli">
            <button class="btn btn-primary" @click="desplegarABMcliente('Crear')" style="font-size: 22px"> 
                Agregar un nuevo Cliente 
            </button>
        </div>
        <br>
        <br>
        <ABMclientes
            v-if="abrirABMcliente"
            :accion=accion
            :id=id
            @SalirDeABMclientes = MostrarABMclientes($event)
        />
        <br>
            <table class="light-blue darken-2">
                <thead>
                    <tr class="bg-primary text-light">
                    <th scope="col">#</th>
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
            abrirABMcliente: false,
            accion: '',
            id: 0,
        }
    },

    created() {
        this.traerDatos()
    },

    mounted() {
        console.log("evento mounted")
        //this.traerDatos()
    },

    methods: {
        traerDatos() {
            console.log("Obteniendo CLIENTES desde la API ...");
            /* this.ObtenerDatos('clientes')
                .then(res => {
                    this.datos = res
                }) */

            let club= {club_configuracion_id : localStorage.getItem('club')}

            this.InsertarDatos("clientes", club)
                .then(res => {
                        this.datos = res
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
        }
    }
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