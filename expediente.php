<?php
include("sesion.php");
//- Incluimos la clase de conexion e instanciamos del objeto principal
include_once("libs/php/class.connection.php");

$botones_menu["limpio"]=true;
$botones_herramientas["pacientes"]=true;


//- Hacerlo hasta el final de cada codigo embebido; incluye el head, css y el menu
include("res/partes/encabezado.php");

?>
<!-- Estilo extra -->
<style>
.sidebar-nav { padding: 9px 0; }
.headGrid{
	background-color: #33b5e5;
}
.headGrid th{
	color: #FFFFFF;
}

</style>
<link href="res/css/select2/select2.css" rel="stylesheet"/>
<!-- /Estilo extra -->

<!-- Scripts extra -->
<script type="text/javascript" src="libs/js/select2/select2.js"></script>
<script type="text/javascript" src="libs/js/select2/select2_locale_es.js"></script>
<script type="text/javascript" src="libs/js/custom/objetos-comunes.js"></script>

<h3> Expediente </h3>
<div class="container-fluid">
		<div class="row-fluid">
			
			<!-- Columna fluida con peso 3/12 -->
			<div class="span3">
				<div class="well sidebar-nav">
	<img id="progressBar_main" src="res/img/loading.gif" class="loading_indicator_mannto" />
	<ul class="nav nav-list">
		<li class="nav-header">Opciones</li>
		<li><a id="lnkGuardar" href="#"><i class="icon-hdd"></i> Guardar</a></li>
		<li><a id="lnkBorrar" href="#"><i class="icon-repeat"></i> Limpiar</a></li>
		<li><a id="lnkLimpiar" href="pacientes.php"><i class="icon-remove"></i> Cancelar</a></li>
		
	</ul>
</div>
			</div>
			<!-- /Columna fluida con peso 3/12 -->


			


			<div class="span9">
			
				<form action= "#" method ="POST">
					<label>Nombres</label> 
					<input type="text" name="nombres" class="span7"><br>
					<label>Apellidos</label>
					<input type="text" name ="apellido" class="span7"><br>
	                <label>Fecah de Nacimiento</label>
					<input type="date" name="fecha nac">
					<label>Peso</label>
					<input type="text" name="peso" class="span2"><br>
                    <label>Genero</label>
                    <input type="radio" name="genero" value="masculino" calss="span2">Masculino 
					<input type="radio" name="genero" value="femenino" >Femenino 
  					
  					<label>Departamento</label>
  					
					
			</div>