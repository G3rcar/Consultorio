<?php
include("sesion.php");
//- Incluimos la clase de conexion e instanciamos del objeto principal
include_once("libs/php/class.connection.php");

$botones_menu["pacientes"]=true;
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

<h3> Pacientes </h3>
<div class="container-fluid">
		<div class="row-fluid">
			
			<!-- Columna fluida con peso 3/12 -->
			<div class="span3">
				<div class="well sidebar-nav">
					<img id="progressBar_main" src="res/img/loading.gif" class="loading_indicator_mannto" />
					<ul class="nav nav-list">
						<li class="nav-header">Opciones</li>
						<li><a id="lnkAgregar" href="expediente.php"><i class="icon-plus"></i> Agregar </a> </li>
						<li><a id="lnkBorrar" href="#"><i class="icon-remove"></i> Borrar</a></li>
						<li class="nav-header">Herramientas</li>
						<li><a id="lnkCita" href="#">Agregar cita</a></li>
						<li><a id="lnkExpediente" href="#">Ver expediete</a></li>
						<li><a id="lnkConsultas" href="#">Ver consultas</a></li>
						<li><a id="lnkRecetas" href="#">Ver recetas</a></li>
					</ul>
				</div>
			</div>
			
			

		</div>
	</div>

