<template>
    <div>
        <h2> Turnos </h2>
        <button> Ingresar un nuevo Turno </button>

        <br>

        <br>
        <div>
            <table class="table">
                <thead class="table-dark">
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col">Cliente</th>
                    <th scope="col">Cancha</th>
                    <th scope="col">Club</th>
                    <!-- <th scope="col">Tipo turno</th>
                    <th scope="col">Fecha Desde</th>
                    <th scope="col">Fecha Hasta</th>
                    <th scope="col">Grupo</th>
                    <th scope="col">Precio</th> -->
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th scope="row">1</th>
                            <td>Mark</td>
                            <td>Otto</td>
                            <td>@mdo</td>
                            <td>
                                <button class="btn btn-warning btn-sm">
                                    Modificar
                                </button>

                                <button class="btn btn-danger btn-sm">
                                    Borrar
                                </button>
                            </td>
                    </tr>
                    <tr>
                        <th scope="row">2</th>
                            <td>Jacob</td>
                            <td>Thornton</td>
                            <td>@fat</td>
                            <td>
                                <button class="btn btn-warning btn-sm">
                                    Modificar
                                </button>

                                <button class="btn btn-danger btn-sm">
                                    Borrar
                                </button>
                            </td>
                    </tr>
                    <tr>
                        <th scope="row">3</th>
                            <td>Larry</td>
                            <td>the Bird</td>
                            <td>@twitter</td>
                            <td>
                                <button class="btn btn-warning btn-sm">
                                    Modificar
                                </button>

                                <button class="btn btn-danger btn-sm">
                                    Borrar
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
            verABMturnos: false,
        }
    }
}
</script>