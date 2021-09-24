<template>
  <div class="about">

    <div class="contenedor">
      <div class="VentanaModal" >
        <div class="cabecera tituloventana">
          <button class="cierre btn btn-primary" ><font color="#35586F">X</font></button>
          <h1>Ingresando Articulo</h1>
        </div>
        <div class="contenido">
            <div class="form-group campo">
              Nombre del articulo <br>
              <input type="text" autofocus name="nombre" id="nombre" class="form-control" >
            </div>
            <div class="form-group campo">
              <label for="" >Rubro</label>
              <select name="id_rubro" id="id_rubro"  class="form-control">
                <option value="">Seleccionar rubro</option>
              </select>
            </div>
            <button class="btn  btn-outline-primary">Ingresar Articulo</button>
            <button class="btn btn-outline-danger">Cancelar</button>
        </div>
      </div>
    </div>

  </div>
</template>

<style scoped>

.contenedor{
	position: fixed;
	top:0;
	left:0;

	width: 100%;
	height: 100%;
	background: rgba(0,0,0,0.5);
}
.VentanaModal {
  background-color: rgb(75, 73, 172);
  border-radius: 10px;
  padding: 35px;
  width: 400px;
  margin: 50px auto;
}

.cierre{
  background: white;
  float: right;
}

.tituloventana{
		text-align:center;
		color:white;
}

.campo{
	color: white;
}

.titulo{
	float:left;
	color: white;
}


</style>
