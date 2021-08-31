<template>
    <div>
        <h2> Canchas </h2>
        <button> Agregar nueva Cancha </button>

        <br>

        <br>
        <div>
            <table class="table">
                <thead class="table-dark">
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col">Club</th>
                    <th scope="col">Deporte</th>
                    <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                    <th scope="row">1</th>
                    <td>Mark</td>
                    <td>Otto</td>
                    <td>
                    <button class="btn btn-warning">
                        Modificar
                    </button> 
                    <button class="btn btn-danger">
                        Eliminar
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
            verABMcanchas: false,
        }
    }
}
</script>