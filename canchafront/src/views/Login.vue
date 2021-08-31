<template>
  <form @submit.prevent="submit">
    <h1 class="h3 mb-3 fw-normal">Por favor, ingrese sesión</h1>

    <input v-model="email" type="email" class="form-control" placeholder="Email" required>

    <input v-model="password" type="password" class="form-control" placeholder="Contraseña" required>

    <button class="w-100 btn btn-lg btn-primary" type="submit">Ingresar</button>
  </form>
</template>

<script>
export default {
    name: 'Login',
    
    data(){
        return {
            email: "",
            password: "",
        }
    }
}
</script>