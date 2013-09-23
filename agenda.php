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


	<h2>Agenda</h2>
	

		<!-- Agenda -->


		<table class="calendar table table-bordered">
		    <thead>
		        <tr>
		            <th width="7%">&nbsp;</th>
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
	$hora = date("h:i A",$hora_contador);
	echo "<tr> <td>{$hora}</td>";
	for($i=1;$i<=7;$i++){
		echo "<td class='no-events'> <div id='h_{$ho}_d_{$i}'>h_{$ho}_d_{$i}</td>";
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

