<template>
    <div>
        <form @submit.prevent="logearUsuario">
            <h1 class="h3 mb-3 fw-normal">Por favor, ingrese</h1>

            <input v-model="datosLoginUser.email" type="email"
                class="form-control" placeholder="Email" />

            <input v-model="datosLoginUser.password" type="password"
                class="form-control" placeholder="Password" />

            <button class="w-100 btn btn-lg btn-primary" type="logearUsuario">
                Iniciar sesión
            </button>
        </form>
    </div>
</template>

<script>
import apiRest from "../mixins/apiRest.vue";
//import axios from "axios";

export default {
    name: "Login",

    mixins: [apiRest],

    data() {
        return {
            datosLoginUser: {
                email: "usuario@gmail.com",
                password: "usuario",
            },

            alertaLogueado: [],
        };
    },

    methods: {
        logearUsuario() {
            if(!this.validarCampos()){
                this.InsertarDatos("login", this.datosLoginUser).then((res) => {
                    console.log(res)
    
                    if (res.msj == "Error") {
                        this.$swal({
                            title: 'Error!',
                            text: ''+res.razon,
                            icon: 'warning',
                            confirmButtonText: 'Ok'
                        })
                    } else {
                        let token = JSON.stringify(res.user.token_actual);
                        let numeroClub = JSON.stringify(res.user.club_configuracion_id);
                        
                        this.$store.commit("guardarDatosUsuario", {
                            token,
                            numeroClub,
                        });
                        
                        setInterval(() => {
                            location.reload();
                        }, 200);
                        this.$router.push("/INFOturnosADMIN");
                    }
                });
            } else {
                this.$swal({
                    title: '¡Error!',
                    text: 'Los siguientes campos estan vacios: '+ this.alertaLogueado,
                    icon: 'warning',
                    confirmButtonText: 'Ok'
                })
            }
        },

        validarCampos(){
                this.alertaLogueado= [];
                for (let key in this.datosLoginUser) {
                        if(this.datosLoginUser[key] == ""){
                                this.alertaLogueado.push(' '+key.charAt(0).toUpperCase()+ key.slice(1))
                        }
                }

                if(this.alertaLogueado.length > 0){
                        return true
                } else {
                        return false
                }
        },

        /* async logearUsuario(){
				const url = 'http://localhost:8000/api/login';
				axios.post(url, this.datosLoginUser, {
					withCredentials: true,
					headers: {
									Accept: 'application/json',
									'Content-Type': 'application/json',
					},
				}).then(res =>{
					console.log(res.data)
					let tkn = JSON.stringify(res.data.user.token_actual);
					this.$store.commit("guardarToken", tkn);
					this.$router.push('/') 
				});
			}, */

    },
};
</script>
