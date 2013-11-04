<?php
include("sesion.php");
//- Incluimos la clase de conexion e instanciamos del objeto principal
include_once("libs/php/class.connection.php");
$conexion = new Conexion();

$botones_menu["citas"]=true;

$idUsuario = $_SESSION["iduser"];
$esDoctor = $_SESSION["esDoctor"];

$minutos_citas = $conf["duracion"]; //40;
$hora_inicio = $conf["horaInicio"]; //1379854800;
$hora_fin = $conf["horaFin"]; //1379887200;
$arrayDias = array("1"=>"Lunes","2"=>"Martes","3"=>"Mi&eacute;rcoles","4"=>"Jueves","5"=>"Viernes","6"=>"S&aacute;bado","7"=>"Domingo");
$fecha_actual = strtotime(date("Y-m-d"));

$numDia = date("d");
$diaSemana = date("N")-1;
$mes = date("m");
$anyo = date("Y");
$horai_form = date("h:i a",$hora_inicio);

$fecha_inicial = strtotime("-{$diaSemana} days",$fecha_actual);

//----Impresion de tabla agenda
//----Aqui se imprimen los bloques HTML de la tabla de agenda donde se insertarán las citas posteriormente
$hora_contador=$hora_inicio;
$finalizado=false;
$ho=0;
$tabla_agenda="";
$fecha_impresion=$fecha_inicial;
while($finalizado==false){
	$hora = date("h:i a",$hora_contador);
	$tabla_agenda .= "<tr> <td class='horas'>{$hora}</td>";
	for($i=1;$i<=7;$i++){

		$tabla_agenda .= "<td class='events'> <div id='h_{$ho}_d_{$i}' p:fecha='{$fecha_impresion}' p:hora='{$hora}'>
			<span class='out-button'> <a href='#' onClick='citas.nueva($fecha_impresion,\"{$hora}\")' title='Agregar'><i class='icon-plus'></i> </a> </span> </div> </td>";
		$fecha_impresion = strtotime("+1 day",$fecha_impresion);
	}
	$tabla_agenda .= "</tr>";

	$hora_contador = strtotime("+{$minutos_citas} minutes",$hora_contador);
	$fecha_impresion=$fecha_inicial;

	if($hora_contador>$hora_fin) $finalizado=true;
	$ho++;
}
//----/Impresion de tabla agenda

//----Impresion de días de la agenda
$dias_agenda="";
for($i=1;$i<=7;$i++){
	$diaI = date("d",$fecha_impresion);
	$mesI = date("m",$fecha_impresion);
	$nomDiaI = $arrayDias[date("N",$fecha_impresion)];
	$dias_agenda .= "<th width='13%'>{$nomDiaI} {$diaI}/{$mesI}</th>";
	$fecha_impresion = strtotime("+1 day",$fecha_impresion);
}
$fecha_impresion=$fecha_inicial;



//----Listado de empleados-doctores
$selDoctores = "SELECT e.emp_id AS 'id',CONCAT(e.emp_nom,' ',e.emp_ape) AS 'nombre',c.car_nom 
				FROM empleado AS e INNER JOIN cargo AS c ON e.emp_idcar = c.car_id WHERE c.car_es_doctor = 'true'";
$res = $conexion->execSelect($selDoctores);

$lsDoctores=""; //Almacenará la lista html de los doctores
$lsDoctoresWin=""; //Almacenará la lista html de los doctores para la ventana
$seleccion=""; //Decidirá si un registro será autoseleccionado o no
$docSeleccionado = "0"; //Id del doctor que se seleccione del listado
if($res["num"]>0){
	$i=0;
	while($iDoc = $conexion->fetchArray($res["result"])){
		if($idUsuario==$iDoc["id"] && $esDoctor){
			$seleccion=" selected ";
			$docSeleccionado = $iDoc["id"];
		}elseif($i==0 && !$esDoctor){
			$seleccion=" selected ";
			$docSeleccionado = $iDoc["id"];
		}else{
			$seleccion="";
		}
		$lsDoctores.="<option {$seleccion} value='".$iDoc["id"]."' >".utf8_encode($iDoc["nombre"])."</option>";
		$lsDoctoresWin.="<option {$seleccion} value='".$iDoc["id"]."' >".utf8_encode($iDoc["nombre"])." (".utf8_encode($iDoc["car_nom"]).")</option>";
		$i++;
	}
}
//----Listado de empleados-doctores


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
		.item-agenda{
			transition: all 3s;
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
			
			$("#cmb_doctor").select2();
			$('.table-fixed-header').fixedHeader();
			mainAgenda.fechaInicial = <?php echo $fecha_inicial; ?>;
			mainAgenda.docSeleccionado = <?php echo $docSeleccionado; ?>;
			mainAgenda.cargarAgenda(<?php echo $docSeleccionado; ?>); 
		});
	</script>

	

	<h2>Agenda <img id="progressBar_main" src="res/img/loading.gif" class="loading_indicator_process" /></h2>
	<select id="cmb_doctor" style="width:300px">
		<?php echo $lsDoctores; ?>
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
					<?php echo $dias_agenda; ?>
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
					<table width="100%" cellspacing="0" cellpadding="0" style="margin-top:5px;">
					<tr><td width="80%">
						<label id="paciente_label" class="requerido">Paciente</label>
						<input type="hidden" id="paciente" style="width:95%" />
					</td>
					<td width="20%">
						<label id="hora_inicio_label" class="requerido">Hora</label>
						<div class="input-append bootstrap-timepicker" style="padding-top:4px;">
							<input id="hora_inicio" type="text" class="input-small" style="width:80px">
							<span class="add-on"><i class="icon-time"></i></span>
						</div>
					</td></tr>
					</table>
					<!--
					<label id="paciente_label" class="requerido">Paciente</label>
					<input type="hidden" id="paciente" style="width:100%" />
					<table width="100%" cellspacing="0" cellpadding="0" style="margin-top:5px;">
					<tr><td width="50%">
						<label id="hora_inicio_label" class="requerido">Hora de inicio</label>
						<div class="input-append bootstrap-timepicker">
							<input id="hora_inicio" type="text" class="input-small" style="width:155px">
							<span class="add-on"><i class="icon-time"></i></span>
						</div>
					</td>
					<td width="50%">
						<label id="hora_inicio_label" class="requerido">Hora de fin</label>
						<div class="input-append bootstrap-timepicker">
							<input id="hora_fin" type="text" class="input-small" style="width:165px">
							<span class="add-on"><i class="icon-time"></i></span>
						</div>
					</td></tr>
					</table>-->

					<label id="empleado_label" class="requerido">Doctor</label>
					<select id="empleado" style="width:100%">
						<?php echo $lsDoctoresWin; ?>
					</select>
					<label id="comentario_label" style="margin-top:10px;">Motivo&nbsp;<small>(M&aacute;x. 50)</small></label>
					<textarea id="comentario" style="width:96%;height:50px;" placeholder="Escriba una breve descripci&oacute;n del motivo de la cita"></textarea>
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
			estado: 'agregar',
			id:'',

			min_inicio:0,
			min_fin:0,
			fecha_seleccionada:0,
			nueva:function(fecha,hora){
				var _t = this;
				_t.fecha_seleccionada = fecha;
				$('#ManntoCita').modal('show');
				
				$("#empleado").select2({ allowClear:true });
				$("#paciente").select2("val","");

				$("#paciente").select2({
					placeholder: "Seleccionar",
					escapeMarkup: function(m) { return m; },
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

				$('#hora_inicio').timepicker({ 
					minuteStep: dr_ci, showInputs: true, showSeconds: false, showMeridian: true 
				}).on("changeTime.timepicker",function(e){ _t.procesarMinutos(e.time,"inicio"); });
				$('#hora_inicio').timepicker('setTime',hora);
				/*$('#hora_fin').timepicker({ 
					minuteStep: dr_ci, showInputs: true, showSeconds: false, showMeridian: true 
				}).on("changeTime.timepicker",function(e){ _t.procesarMinutos(e.time,"fin"); });*/
				$('#comentario').val('').removeClass('error_requerido').attr('title','');
			},
			
			guardar:function(){
				var _t = this;

				if(!_t.validarForm()){ return; }
				$('#s2id_paciente').removeClass('error_requerido_sel2');
				$('#comentario').removeClass('error_requerido').attr('title','');
				
				_t.toggle(false);
				
				var idPaciente = $('#paciente').val();
				var hi = _t.hora_inicio;
				var hf = _t.hora_fin;
				var fecha = _t.fecha_seleccionada;
				var idEmpleado = $('#empleado').val();
				var comentario = $('#comentario').val();
				
				if(this.estado=='agregar'){ this.id=''; }
				var datos = 'action=sv_cita&idpaciente='+idPaciente+'&hinicio='+hi+'&idempleado='+idEmpleado+'&fecha='+fecha+'&comentario='+comentario+'&id='+this.id;
				//+'&hfin='+hf

				$.ajax({
					url:'stores/agenda.php',
					data:datos, dataType:'json', type:'POST',
					complete:function(datos){
						var T = jQuery.parseJSON(datos.responseText);

						humane.log(T.msg);
						if(T.success=="true"){
							$('#ManntoCita').modal('hide');
							_t.toggle(true);
							mainAgenda.cargarAgenda(mainAgenda.docSeleccionado);
						}
						_t.toggle(true);
					}
				});
			},
			borrar:function(id){
				var tipo = 'uno';
				var ids = id;
				var action = 'br_cita';
				
				bootbox.confirm("¿Esta seguro de eliminar la cita?", function(confirm) {
					if(confirm){
						$.ajax({
							url:'stores/agenda.php',
							data:'action='+action+'&id='+ids, dataType:'json', type:'POST',
							complete:function(datos){
								var T = jQuery.parseJSON(datos.responseText);
								
								humane.log(T.msg)
								if(T.success=='true'){ 
									mainAgenda.cargarAgenda(mainAgenda.docSeleccionado);
									mainAgenda.removerEvento(id);
								}
							}
						});
					}
				}); 
			},



			procesarMinutos:function(tiempo,tipo){
				var _t = this;
				var h = tiempo.hours;
				var m = tiempo.minutes;
				var p = tiempo.meridian;
				h += (p=="PM")?12:0;
				h = (p=="AM"&&h==12)?0:h;
				h = h*60;
				h += m;
				if(tipo=="inicio"){ _t.hora_inicio = h; }
				else{ _t.hora_fin = h; }
			},
			validarForm:function(){
				var _t = this;
				var errores=0;
				var maximo = 50;
				var iv1 = $('#paciente').val();
				var iv2 = $('#comentario').val();
				var hi = _t.hora_inicio;
				//var hf = _t.hora_fin;

				//--remover
				$('#s2id_paciente').removeClass('error_requerido_sel2');
				$('#comentario').removeClass('error_requerido').attr('title','');
				//--/remover

				if(iv1==''){ $('#s2id_paciente').addClass('error_requerido_sel2'); errores++; }
				if(iv2.length>maximo){ $('#comentario').addClass('error_requerido').attr('title','No debe sobrepasar de 50 caracteres'); errores++; }
				//if(hi>=hf){ $('#hora_fin').addClass('error_requerido'); errores++; }
				if(errores>0){
					humane.log('Complete los campos requeridos');
					return false;
				}else{
					return true;
				}
			},

			toggle:function(v){
				if(v){ $('#guardarCita').removeAttr('disabled').html('Guardar'); }
				else{ $('#guardarCita').attr('disabled','disabled').html('Guardando...'); }
			}
		}

	</script>



<?php include('res/partes/pie.pagina.php'); ?>

