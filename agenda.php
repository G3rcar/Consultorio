<?
include("sesion.php");
//- Incluimos la clase de conexion e instanciamos del objeto principal
include_once("libs/php/class.connection.php");

$botones_menu["citas"]=true;

$minutos_citas = 40;
$hora_inicio = 1379854800;
$hora_fin = 1379887200;

//- Hacerlo hasta el final de cada codigo embebido; incluye el head, css y el menu
include("res/partes/encabezado.php");

?>
	<link href="res/css/agenda.css" rel="stylesheet" />
	<style type="text/css">
		.headGrid {
			background-color: #33b5e5;
		}
		.headGrid th{
			color: #FFF;
		} 
	</style>

	<script type="text/javascript" src="libs/js/custom/agenda.js"></script>
	<script type="text/javascript" src="libs/js/jquery-ui-1.10.3.custom.js"></script>
	<script type="text/javascript">

		$(document).ready(function(){
			mainAgenda.crearEvento(1,'h_5_d_1','Juan P&eacute;rez','Doc. Cerna');
			mainAgenda.crearEvento(2,'h_3_d_1','Manuel Salazar','Doc. Cerna');
			mainAgenda.crearEvento(3,'h_3_d_2','Carlos Perla','Doc. Cerna');
			mainAgenda.crearEvento(4,'h_4_d_3','Oscar Funes','Doc. Cerna');
			mainAgenda.crearEvento(5,'h_6_d_5','Sara Rodezno','Doc. Cerna');
		});

	</script>

	

	<h2>Agenda</h2>
	<select>
		<option>Doctor Cerna</option>
		<option>Doctor Alvarado</option>
	</select>
	

		<!-- Agenda -->


		<table class="calendar table table-bordered table-fixed-header">
		    <thead>
		        <tr>
		            <th width="6%">&nbsp;</th>
		            <th width="13%">Domingo</th>
		            <th width="13%">Lunes</th>
		            <th width="14%">Martes</th>
		            <th width="13%">Mi&eacute;rcoles</th>
		            <th width="14%">Jueves</th>
		            <th width="13%">Viernes</th>
		            <th width="13%">S&aacute;bado</th>
		        </tr>
		    </thead>
		    <tbody>
<?

//----Impresion de tabla
$hora_contador=$hora_inicio;
$finalizado=false;
$ho=0;
while($finalizado==false){
	$hora = date("h:i a",$hora_contador);
	echo "<tr> <td class='horas'>{$hora}</td>";
	for($i=1;$i<=7;$i++){
		echo "<td class='events'> <div id='h_{$ho}_d_{$i}'> 
			<span class='out-button'> <a href='#' title='Agregar'><i class='icon-plus'></i> </a> </span> </div> </td>";
	}
	echo "</tr>";

	$hora_contador = strtotime("+{$minutos_citas} minutes",$hora_contador);

	if($hora_contador>$hora_fin) $finalizado=true;
	$ho++;
}


?>

			</tbody>
		</table>
<!--
		        
-->

		<br />
		<br />
		<br />



<? include('res/partes/pie.pagina.php'); ?>

