<template>
    <div>
        <h2> Canchas </h2>
        <button> Ingresar una nueva Cancha </button>

        <br>

        <br>
        <div>
            <table class="table">
                <thead class="table-dark">
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col">Club</th>
                    <th scope="col">Deporte</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                    <th scope="row">1</th>
                    <td>Mark</td>
                    <td>Otto</td>
                    </tr>
                    <tr>
                    <th scope="row">2</th>
                    <td>Jacob</td>
                    <td>Thornton</td>
                    </tr>
                    <tr>
                    <th scope="row">3</th>
                    <td>Larry</td>
                    <td>the Bird</td>
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