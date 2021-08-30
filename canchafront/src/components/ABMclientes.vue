<template>
    <div>
        <h1> Clientes </h1>
        <form @submit.prevent>
                <span>Nombre: </span>
                <input type="text" placeholder="Nombre cliente...">
                <br>
                <br>
                <button @click="cancelarForm()">Cancelar</button>
                <button @click="guardarCliente()">Enviar</button>
            </form>
            <div>
                <label> Nombre </label>
                <input type="text">
            </div>
            <div>
                <label> Apellido </label>
                <input type="text">
            </div>
            <div>
                <label> Telefono </label>
                <input type="text">
            </div>
            <div>
                <label> Edad </label>
                <input type="text">
            </div>
            <div>
                <label> Email </label>
                <input type="text">
            </div>
    </div>
</template>