<template>
    <div>
        <div>
            <h1 class="bg-primary text-white text-center mb-3">Contactanos</h1>
            <hr>
            <p class="divContacto">Para comunicarse con nosotros puede hacerlo a cualquiera de los teléfonos que figuran en el sitio o bien escribir su mensaje mediante los siguientes correos electronicos.</p>
            <div>
                <p class="contactos1"><a href="mailto:matimcusi@gmail.com"> Nombre: Matias Cusinato - 
                <br>
                Contactar por Correo: matimcusi@gmail.com
                <br>
                <i class="bi bi-whatsapp"> 3446-355446 </i>
                <br>
                <i class="bi bi-github"> Matias Cusinato </i>
                <br>
                </a></p>
                <img class="imagen1" height="180" width="180" src="@/assets/mati.png"/>
            </div>
            <div>    
                <p class="contactos2"><a href="mailto:nehuencuenca@gmail.com"> Nombre: Nehuen Cuenca - 
                <br>
                Contactar por Correo: nehuencuenca@gmail.com 
                <br>
                <i class="bi bi-whatsapp"> 3446-637047 </i>
                <br>
                <i class="bi bi-github"> Nehuen Cuenca </i>
                <br>
                </a></p>
                <img class="imagen2" height="180" width="180" src="@/assets/nehuen.png"/>
            </div>
        </div>
    </div>
</template>

<script>

export default {
    name: "Soporte",
    data() {
        return {
            /* src:'https://images.unsplash.com/photo-1520006709240-e2a6f6323d8e?ixlib=rb-0.3.5&ixid=eyJhcHBfaWQiOjEyMDd9&s=dfe8a318c622dee80cb04c81155485e6&auto=format&fit=crop&w=1050&q=80' */
        }
    }
};
</script>

<style scoped>
.divContacto {
    border: 2px black solid;
    border-radius: 10px;
    border-collapse: collapse;
    height: 140px;
    width: 750px;
    margin: 20px -170px;
    padding: 20px 40px;
    background-color:rgb(243, 214, 159);
    position: relative;
    left: 10px;
    top: -20px;
}    
.contactos1 {
    border: 2px black solid;
    border-radius: 10px;
    border-collapse: collapse;
    min-height: 100px;
    height: 220px;
    width: 400px;
    margin: 20px -400px;
    padding: 20px 40px;
    background-color:  rgb(224, 224, 218);
    position: relative;
    left: 10px;
    top: 170px;
}
.contactos2 {
    border: 2px black solid;
    border-radius: 10px;
    border-collapse: collapse;
    min-height: 100px;
    height: 220px;
    width: 400px;
    margin: 20px 300px;
    padding: 20px 40px;
    background-color:  rgb(224, 224, 218);
    position: relative;
    left: 10px;
    top: -270px;
}    
.imagen1{
    top: -260px;
    position: relative;
    left: -270px;
}
.imagen2{
    top: -700px;
    position: relative;
    left: 420px;
}
</style>