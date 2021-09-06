<template>
  <form @submit.prevent="submit">
    <h1 class="h3 mb-3 fw-normal">Por favor, registrese</h1>

    <input v-model="nombre" class="form-control" placeholder="Nombre" required>

    <input v-model="apellido" class="form-control" placeholder="Apellido" required>

    <input v-model="email" type="email" class="form-control" placeholder="Email" required>

    <input v-model="password" type="password" class="form-control" placeholder="Contraseña" required>

    <button class="w-100 btn btn-lg btn-primary" type="submit">Enviar</button>
  </form>
</template>

<script>
export default {
    name: 'Registro',

    data(){
        return {
            nombre: "",
            apellido: "",
            email: "",
            password: "",
        }
    }
}
</script>