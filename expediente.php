<?php
include("sesion.php");
//- Incluimos la clase de conexion e instanciamos del objeto principal
include_once("libs/php/class.connection.php");



$botones_menu["limpio"]=true;
$botones_herramientas["pacientes"]=true;
$consulta="SELECT pac_id,pac_nom FROM paciente ORDER BY pac_id ASC ";
$result=mysql_query($consulta);

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
			
				<form action= "#" method ="POST" onsubmit="return  validacion()" >
					<label>Nombres</label> 
					<input id="txtNompaciente" type="text" placeholder="Escriba el nombre" style="width:70%;">

					<!--<input type="text" name="pac_nom" class="span8"><br>-->
                    <label>Apellidos</label>
					<input id="txtApellidoPac" type="text" placeholder="Escriba el Apellido" style="width:70%;">
	                <label>Fecha de Nacimiento</label>
					<input type="date" name="pac_fecha_nac">

					 <fieldset>
					 <div class="span5">
					<label>Peso</label>
					<input id="txtPesopac" type="text" placeholder="Escriba el peso" ><br>
					</div>
					<div class="span5">
					<label>Altura</label>
					<input id="txtAltpac" type="text" placeholder="Escriba la altura" >
				    </div>
					</fieldset>
				
					
					<label>Alergias</label>
  					<textarea rows="3"  cols= 50 class="span9"  ></textarea>
  				    
  				   
                    <label>Genero</label>
                    <input type="radio" name="pac_gen" value="masculino" > Masculino 
					<input type="radio" name="pac_gen" value="femenino" >  Femenino <br>
  					<br>
  					
  				  <!--<label>Pais</label>-->
  				  	<fieldset>
	  				  <div class="span5">
	  				  <label>Pais</label>
					  <select >
					  <option>El Salvador </option>
					  <option>Hondura</option>
					  <option>Costa Rica</option>
					  <option>Panama</option>
					  <option>Estados Unidos</option>
					</select>
					</div>

					<div calss="span5">
					<label>Municipio</label>
					<select>
					<option>Mejicanos</option>
					<option>Ayutuxtepeque</option>
			    	</select>
					</div>
					</fieldset>

					<label>Dirección</label>
				    <textarea rows="3"  cols= 50 class="span9" placeholder="Escriba la direccion"></textarea>
				  
 	

  					<fieldset>
  					<div class="span5">
  				 	 <label>Telefono Casa</label>
  				 	<input id="txtTelpac" type="text" placeholder="Escriba el telefono" >
					</div>
					<div class="span5">
                 	 <label>Telefono Celular</label>
			     	<input id="txtCelc" type="text" placeholder="Escriba el telefono" >
		          	 </select>
  				  	</div>
  				  	</fieldset>
					
				<div calss="span5">
  				  	<label>Fecha de Creación Expediente</label>
					<input type="date" name="pac_fecha_cre">
					</div>

				
					</div>

			
		

			


<?php include('res/partes/pie.pagina.php'); ?>




			
			
				