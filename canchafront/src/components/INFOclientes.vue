<template>
    <div>
        <h1> Clientes </h1>
        <button> Agregar un nuevo Cliente </button>

        <br>

        <br>
        <div>
            <table class="table">
                <thead class="table-dark">
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Apellido</th>
                    <th scope="col">Telefono</th>
                    <!-- <th scope="col">Edad</th>
                    <th scope="col">Email</th> -->
                    <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                    <th scope="row">1</th>
                    <td>Mark</td>
                    <td>Otto</td>
                    <td>@mdo</td>
                    <td class="tdAcciones">
                    <button class="button btn btn-warning btn-sm">
                        Modificar
                    </button> 
                    <button class="button btn btn-danger btn-sm">
                        Eliminar
                    </button> 
                    <button class="button btn btn-primary btn-sm">
                        Consultar
                    </button>
                    </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
export default {
    /* mixins: [apiRest], */
    datos() {
        return {
            datos: [],
            verABMclientes: false,
        }
    }
}
</script>