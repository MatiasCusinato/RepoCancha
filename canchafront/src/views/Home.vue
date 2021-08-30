<template>
  <div class="home">
    <div class="BtnInfos">
      <button @click="funcMostrarClientes()">Clientes</button>
      <button @click="funcMostrarTurnos()">Turnos</button>
      <button @click="funcMostrarCanchas()">Canchas</button>
    </div>
    <div class="info">
      <INFOclientes v-if="verINFOclientes"/>
      <INFOturnos v-if="verINFOturnos"/>
      <INFOcanchas v-if="verINFOcanchas"/>
    </div>
  </div>  
</template>

<script>
// @ is an alias to /src
import INFOclientes from '@/components/INFOclientes.vue'
import INFOturnos from '@/components/INFOturnos.vue'
import INFOcanchas from '@/components/INFOcanchas.vue'

export default {
  components: {
    INFOclientes,
    INFOturnos,
    INFOcanchas,
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
