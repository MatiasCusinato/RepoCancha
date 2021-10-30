<template>
    <div>
        <nav class="navbar navbar-expand-md navbar-dark bg-dark mb-4">
            <div class="container-fluid">
                <li @click="refrescarPagina()">
                    <router-link to="/INFOturnosDISPONIBLES/club/0" class="navbar-brand">
                        <i class="bi bi-house"> Clubes</i>
                    </router-link>
                </li>
                
                <div class="collapse navbar-collapse" v-if="this.token">
                    <div class="navbar-nav">
                        <router-link to="/INFOturnosADMIN" 
                                class="nav-item nav-link">
                                    <i class="bi bi-calendar3"> Mis Turnos </i>
                        </router-link>

                        <!-- <router-link to="/INFOturnosDISPONIBLES/club/1" 
                                class="nav-item nav-link">
                                    <i class="bi bi-calendar-check-fill"> Turnos DISPONIBLES </i>
                        </router-link> -->

                        <router-link to="/INFOclientes" 
                                class="nav-item nav-link">
                                    <i class="bi bi-people-fill"> Mis Clientes </i>
                        </router-link>
                        
                        <router-link to="/INFOcanchas" 
                                class="nav-item nav-link">
                                    <i class="bi bi-flag-fill"> Mis Canchas </i>
                        </router-link>

                        <router-link to="/Soporte" 
                                class="nav-item nav-link">
                                    <i class="bi bi-envelope"> Soporte </i>
                        </router-link>
                    </div>
                </div>

                <div>
                    <ul class="navbar-nav me-auto mb-2 mb-md-0" v-if="!this.token">
                        <li class="nav-item">
                            <router-link to="/login" class="nav-link">
                                Login
                            </router-link>
                        </li>

                        <!-- <li class="nav-item">
                            <router-link to="/registro" class="nav-link">
                                Registro
                            </router-link>
                        </li> --> 

                    </ul>

                    <ul class="navbar-nav me-auto mb-2 mb-md-0" v-if="this.token">
                        <li class="nav-item">
                            <a @click="logoutUser" href="#" class="nav-link">
                                <i class="bi bi-box-arrow-right"> Cerrar Sesión </i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
</template>


<script>
import apiRest from '../mixins/apiRest.vue'
//import axios from 'axios'

export default {
    name: "NavigationBar",
    
    mixins:[apiRest],

    data(){
        return {
            token: localStorage.getItem('laravelToken'),
        }
    },

    methods:{
        logoutUser(){
            let token= {
                token_actual: this.$store.state.vToken
            }

            if(token.token_actual){
                //token.token_actual = token.token_actual.slice(1,-1)
                //console.log("token "+ JSON.stringify(token)+ " a borrar")
                
                this.InsertarDatos("logout", token)
                    .then(res => {
                        console.log(res)
                        this.$store.commit("borrarToken");

                        setInterval(() => {
                            location.reload();
                        }, 100);
                        this.$router.push('/login') 
                    })
                
            } else {
                alert("Ya estas deslogueado!!")
            }

            
        },

        refrescarPagina(){
            location.reload();
        }
        /* async logoutUser(){
            const url = 'http://localhost:8000/api/logout';
            let token= {
                token_actual: localStorage.getItem('laravelToken')
            }
            token.token_actual = token.token_actual.slice(1,-1)
            console.log("token "+ JSON.stringify(token)+ " a borrar")
            
            axios.post(url, token, {
            withCredentials: true,
            headers: {
                    Accept: 'application/json',
                    'Content-Type': 'application/json',
            },
            }).then(res =>{
                console.log(res.data)
                this.$store.commit("borrarToken");
                this.$router.push('/login') 
            });
        }, */
    },  
}
</script>