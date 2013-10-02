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
		.error_requerido_sel2 a{
			border: 1px solid #F00 !important;
		}
	</style>
	<link href="res/css/select2/select2.css" rel="stylesheet"/>
	<link href="res/css/bootstrap/css/bootstrap-timepicker.css" rel="stylesheet"/>
	<link href="res/css/table-fixed-header.css" rel="stylesheet"/>

    <script type="text/javascript" src="libs/js/select2/select2.js"></script>
    <script type="text/javascript" src="libs/js/select2/select2_locale_es.js"></script>
    <script type="text/javascript" src="libs/js/bootstrap-timepicker.js"></script>
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
	<div id="ManntoCita" class="modal hide fade modalMediana" role="dialog" aria-labelledby="ManntoCita" aria-hidden="true">
		
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 id="modalHead">Nueva cita</h3>
		</div>
		<div class="modal-body" style="overflow-y:visible;" >
			<form>
				<fieldset>
					<label id="paciente_label" class="requerido">Paciente</label>
					<input type="hidden" id="paciente" style="width:100%" />

					<table width="100%" cellspacing="0" cellpadding="0" style="margin-top:5px;">
					<tr><td width="50%">
						<label id="hora_inicio_label" class="requerido">Hora de inicio</label>
						<div class="input-append bootstrap-timepicker">
							<input id="hora_inicio" type="text" value="10:35 AM" class="input-small" style="width:155px">
							<span class="add-on"><i class="icon-time"></i></span>
						</div>
					</td>
					<td width="50%">
						<label id="hora_inicio_label" class="requerido">Hora de inicio</label>
						<div class="input-append bootstrap-timepicker">
							<input id="hora_fin" type="text" value="10:35 AM" class="input-small" style="width:165px">
							<span class="add-on"><i class="icon-time"></i></span>
						</div>
					</td></tr>
					</table>

					<label id="empleado_label" class="requerido">Doctor</label>
					<select id="empleado" style="width:100%">
						<option value="1">Dr. Julio Cerna</option>
						<option value="2">Dr. Carlos Alvarado</option>
					</select>
				</fieldset>
			</form>
		</div>
		<div class="modal-footer">
			<button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
			<button id="guardarCita" onClick="citas.guardar()" class="btn btn-primary">Guardar</button>
		</div>

	</div>


	<script type="text/javascript">


		var dr_ci = <?php echo $minutos_citas; ?>;

		var citas = {
			nueva:function(dia,hora){
				$('#ManntoCita').modal('show');
				
				$("#empleado").select2();
				$("#paciente").select2({
					placeholder: "Seleccionar", minimumInputLength: 1,
					ajax: {
						url: "stores/agenda.php", dataType: 'json', type:'POST',
						data: function (term, page) {
							return { q: term, action:'ls_pacientes' };
						},
						results: function (data, page) {
							return {results: data.results};
					    }
					}
				});

				$('#hora_inicio').timepicker({ minuteStep: dr_ci, showInputs: true, showSeconds: false, showMeridian: true });
				$('#hora_fin').timepicker({ minuteStep: dr_ci, showInputs: true, showSeconds: false, showMeridian: true });
			},
			guardar:function(){
				if($('#paciente').val()==""){
					$('#s2id_paciente').addClass("error_requerido_sel2"); return;
				}else{
					$('#s2id_paciente').removeClass("error_requerido_sel2");
				}
			}
		}

	</script>



<? include('res/partes/pie.pagina.php'); ?>

