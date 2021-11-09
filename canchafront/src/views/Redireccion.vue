<template>
    <div>  
        <div style="text-align: center">
            <h1><u>Redireccionando</u></h1>        
            <br>
            <h3>No tienes los permisos para ingresar a esta vista...</h3>
        </div>      
    </div>
</template>

<script>

export default {
    data() {
        return{
            
        }
    },

    mounted(){
        setInterval(() => {
            this.$router.push("/INFOturnosDISPONIBLES/club/0");
            location.reload();
        }, 3500);         
    }
}
</script>
