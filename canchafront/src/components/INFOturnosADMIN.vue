<template>
    <div>
        <h2> Turnos </h2>
        <br>
        <div>
            <h4>FILTROS</h4>
            <input type="text" placeholder="Buscar clientes">
        </div>

        <br>
        <br>
        <div class="btn-group" role="group" aria-label="Basic example">
            <button class="btn btn-info" style="margin: 10px">CANCHA 1</button>
            <button class="btn btn-info" style="margin: 10px">CANCHA 2</button>
            <button class="btn btn-info" style="margin: 10px">CANCHA 3</button>
        </div>
        <br>
        <div class="btnTurno">
            <button class="btn btn-info"> Agregar nuevo Turno </button>
            <br>
            <br>
            <button class="btn btn-info"> Agregar nuevo Turno Fijo </button>
        </div>

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
                    </tr>
                    <tr>
                    <th scope="row">2</th>
                    <td>Jacob</td>
                    <td>Thornton</td>
                    <td>@fat</td>
                    </tr>
                    <tr>
                    <th scope="row">3</th>
                    <td>Larry</td>
                    <td>the Bird</td>
                    <td>@twitter</td>
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

<style scoped>
.btnTurno {
    position: fixed;
    float: left;
    bottom: 200px;
    left: 100px;
    font-size: 16px;
    min-width: 150px;
    height: 40px;
    width: 80px;
    padding: 15px 32px;
}
.btnCancha button {
    display: inline-block;
    margin: 0 10px;
}
</style>