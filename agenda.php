<?php
include("sesion.php");
//- Incluimos la clase de conexion e instanciamos del objeto principal
include_once("libs/php/class.connection.php");

$botones_menu["citas"]=true;

$minutos_citas = 40;
$hora_inicio = 1379854800;
$hora_fin = 1379887200;

//- Hacerlo hasta el final de cada codigo embebido; incluye el head, css y el menu
include("res/partes/encabezado.php");



//----Impresion de tabla
$hora_contador=$hora_inicio;
$finalizado=false;
$ho=0;
$tabla_agenda="";
while($finalizado==false){
	$hora = date("h:i a",$hora_contador);
	$tabla_agenda .= "<tr> <td class='horas'>{$hora}</td>";
	for($i=1;$i<=7;$i++){
		$tabla_agenda .= "<td class='events'> <div id='h_{$ho}_d_{$i}'> 
			<span class='out-button'> <a href='#' onClick='citas.nueva()' title='Agregar'><i class='icon-plus'></i> </a> </span> </div> </td>";
	}
	$tabla_agenda .= "</tr>";

	$hora_contador = strtotime("+{$minutos_citas} minutes",$hora_contador);

	if($hora_contador>$hora_fin) $finalizado=true;
	$ho++;
}




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
	<link href="res/css/select2/select2.css" rel="stylesheet"/>
	<link href="res/css/table-fixed-header.css" rel="stylesheet"/>

    <script type="text/javascript" src="libs/js/select2/select2.js"></script>
    <script type="text/javascript" src="libs/js/table-fixed-header.js"></script>
	<script type="text/javascript" src="libs/js/custom/agenda.js"></script>
	<script type="text/javascript" src="libs/js/jquery-ui-1.10.3.custom.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			mainAgenda.crearEvento(1,'h_5_d_1','Juan P&eacute;rez','Doc. Cerna');
			mainAgenda.crearEvento(2,'h_3_d_1','Manuel Salazar','Doc. Cerna');
			mainAgenda.crearEvento(3,'h_3_d_2','Carlos Perla','Doc. Cerna');
			mainAgenda.crearEvento(4,'h_4_d_3','Oscar Funes','Doc. Cerna');
			mainAgenda.crearEvento(5,'h_6_d_5','Sara Rodezno','Doc. Cerna');

			$("#cmb_doctor").select2();

			$('.table-fixed-header').fixedHeader();


		});

	</script>

	

	<h2>Agenda</h2>
	<select id="cmb_doctor" style="width:300px">
		<option value="1">Gerardo Calderon</option>
		<option value="2">Calderon Gerard</option>
		<option value="3">Manuel Martinez</option>
		<option value="4">Luis Monzon</option>
		<option value="5">César Araujo</option>
		<option value="6">Marcos Umaña</option>
		<option value="7">Albo Nero</option>
		<option value="8">San SS</option>
	</select>
	
	<br/>
	<br/>

		<!-- Agenda -->

		<div class="fixed-table">
		<div class="table-content"> 
		<table class="calendar table table-bordered table-fixed-header">
		    <thead class="header">
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

		    	<?php echo $tabla_agenda; ?>

			</tbody>
		</table>
		</div>
		</div>

		<br />
		<br />
		<br />


	<!-- Agregar -->
	<div id="ManntoCita" class="modal hide fade modalPequena" role="dialog" aria-labelledby="ManntoCita" aria-hidden="true">
		
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 id="modalHead">Nueva cita</h3>
		</div>
		<div class="modal-body">
			<form>
				<fieldset>
					<label id="paciente_label" class="requerido">Paciente</label>
					<!--<input id="paciente" type="text" min-length="2" class="input-block-level" placeholder="Escribir..." >-->
					<select id="paciente" class="populate" style="width:100%">
						<option value=""></option>
						<option value="1">Gerardo Calderon</option>
						<option value="2">Calderon Gerard</option>
						<option value="3">Manuel Martinez</option>
						<option value="4">Luis Monzon</option>
						<option value="5">César Araujo</option>
						<option value="6">Marcos Umaña</option>
						<option value="7">Albo Nero</option>
						<option value="8">San SS</option>
					</select>
				</fieldset>
			</form>
		</div>
		<div class="modal-footer">
			<button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
			<button id="guardarCita" class="btn btn-primary">Guardar</button>
		</div>

	</div>


	<script type="text/javascript">

		var citas = {
			nueva:function(dia,hora){
				$('#ManntoCita').modal('show');
				$("#paciente").select2();
			},
		}

	</script>



<? include('res/partes/pie.pagina.php'); ?>

