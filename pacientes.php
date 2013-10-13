<?php
include("sesion.php");
//- Incluimos la clase de conexion e instanciamos del objeto principal
include_once("libs/php/class.connection.php");

$botones_menu["limpio"]=true;


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

.modalPequena{
	width:350px;
	margin-left:-175px;
}
</style>
<!-- /Estilo extra -->

<!-- Scripts extra -->
<script type="text/javascript" src="libs/js/custom/objetos-comunes.js"></script>
<h3><center> Pacientes </center></h3>

<div class="row-fluid">
			
			<!-- Columna fluida con peso 3/12 -->
			<div class="span3">
				<div class="well sidebar-nav">
					<img id="progressBar_main" src="res/img/loading.gif" class="loading_indicator" />
					<ul class="nav nav-list">
						<li class="nav-header">Opciones</li>
						<li><a id="lnkAgregar" href="expediente.php"><i class="icon-plus"></i> Agregar</a></li>
						<li><a id="lnkBorrar" href="#"><i class="icon-remove"></i> Borrar</a></li>
						
						
					</ul>
				</div>

			
                 
				<html> 
<body> 

<?php 
$link = mysql_connect("localhost", "root"); 
mysql_select_db("consultorio", $link); 
$result = mysql_query("SELECT nombres, apellidos FROM paciente", $link); 
if ($row = mysql_fetch_array($result)){ 
   echo "<table border = '1'> \n"; 
   echo "<tr><td>Nombres</td><td>aplellidos</td></tr> \n"; 
   do { 
      echo "<tr><td>".$row["nombres"]."</td><td>".$row["apellidos"]."</td></tr> \n"; 
   } while ($row = mysql_fetch_array($result)); 
   echo "</table> \n"; 
} else { 
echo "¡ No se ha encontrado ningún registro !"; 
} 
?> 
  
</body> 
</html>