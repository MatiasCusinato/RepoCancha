<template>
  <div class="home">
    <div>
      <ul class="list-group">
        <li class="list-group-item">
          <router-link to="/INFOturnos" class="nav-link">Turnos ADMIN</router-link>
        </li>
        <li class="list-group-item">
          <router-link to="/INFOclientes" class="nav-link">Clientes</router-link>
        </li>
        <li class="list-group-item">
          <router-link to="/INFOcanchas" class="nav-link">Canchas</router-link>
        </li>
      </ul>

      <!-- <ul class="navbar-nav me-auto mb-2 mb-md-0">
          <li class="nav-item">
              <a href="#" class="nav-link">Logout</a>
          </li>
      </ul> -->
    </div>
  </div>  
</template>

<script>
// @ is an alias to /src

export default {
  components: {
  },
  data() {
    return {
      verINFOclientes: false,
      verINFOturnos: false,
      verINFOcanchas: false,
    }
  },
  methods: {
    funcMostrarClientes() {
      this.verINFOclientes = !this.verINFOclientes
    },
    funcMostrarTurnos() {
      this.verINFOturnos = !this.verINFOturnos
    },
    funcMostrarCanchas() {
      this.verINFOcanchas = !this.verINFOcanchas
    },
  }
}
</script>

<style scoped>
  .home{
    margin: 50px auto 10px auto;
  }
  .btnAbrirINFO{
    text-align: center;
    height: 40px;
    width: 80px;
  }
  .BtnInfos{
    display: flex;
    align-content: space-between;
    background-color:rgb(127, 255, 212);
    padding: 10px;
    border: 2px solid black;
    justify-content: center;
  } 
  .BtnInfos button {
    background-color: rgb(255,127,80);
    height: 50px;
    min-width: 150px;
    margin: 10px 10px 10px 10px;
    border: 2px solid black;
    font-size: 22px;
  }  
  .info{
    display: flex;
    flex-direction: column;
    justify-content: center;
  }
</style>
