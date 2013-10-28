<?php
include("sesion.php");
//- Incluimos la clase de conexion e instanciamos del objeto principal
include_once("libs/php/class.connection.php");
include_once("libs/php/class.objetos.base.php");

$botones_menu["limpio"]=true;
$botones_configuracion["configuracion"]=true;


//- Hacerlo hasta el final de cada codigo embebido; incluye el head, css y el menu
include("res/partes/encabezado.php");

$hora_inicio = strtoupper(date("h:i a",$conf["horaInicio"]));
$hora_fin = strtoupper(date("h:i a",$conf["horaFin"]));

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
<link href="res/css/bootstrap/css/bootstrap-timepicker.css" rel="stylesheet"/>
<!-- /Estilo extra -->

<!-- Scripts extra -->
<script type="text/javascript" src="libs/js/select2/select2.js"></script>
<script type="text/javascript" src="libs/js/select2/select2_locale_es.js"></script>
    <script type="text/javascript" src="libs/js/bootstrap-timepicker.js"></script>
<script type="text/javascript" src="libs/js/custom/objetos-comunes.js"></script>

<!-- /Scripts extra -->


	<h3>Configuraci&oacute;n General</h3>

	<div class="container-fluid">
		<div class="row-fluid">
			
			<!-- Columna fluida con peso 3/12 -->
			<div class="span3">
				<?php include('res/partes/herramientas.configuracion.php'); ?>
			</div>
			<!-- /Columna fluida con peso 3/12 -->


			<!-- Columna fluida con peso 9/12 -->
			<div id="contenedorTabla" class="span9">
				<form>
					<fieldset>
						<legend>General</legend>
						<div class="span5">
							<label>Nombre de la Empresa</label>
							<input id="txtNombreEmpresa" type="text" placeholder="Escriba el nombre" style="width:100%;" value="<?php echo $conf["nombreEmpresa"]; ?>" >
							<span class="help-block">Aparecer&aacute; al momento de iniciar sesi&oacute;n</span>

						</div>
						<div class="span5">
							<label>Nombre del Sistema</label>
							<input id="txtNombreSistema" type="text" placeholder="Escriba el nombre" style="width:100%;" value="<?php echo $conf["nombreSistema"]; ?>" >
							<span class="help-block">Aparecer&aacute; en la parte superior del sistema</span>
						</div>
					</fieldset>
					<br>
					<fieldset>

						<legend>Horario</legend>
						<div class="span5">
							<label>Hora de inicio</label>
							<div class="input-append bootstrap-timepicker">
								<input id="timeHoraInicio" type="text" class="input-small" style="width:90%" value="<?php echo $hora_inicio; ?>" >
								<span class="add-on"><i class="icon-time"></i></span>
							</div>
							<span class="help-block">Usado para construir la agenda semanal</span>

							<label>Duraci&oacute;n de las citas</label>
							<div class="input-append">
								<input id="txtDuracion" type="text" placeholder="Escriba la duraci&oacute;n..." style="width:81%;" value="<?php echo $conf["duracion"]; ?>" >
								<span class="add-on">minutos</span>
							</div>
							
						</div>
						<div class="span5">
							<label>Hora de fin</label>
							<div class="input-append bootstrap-timepicker">
								<input id="timeHoraFin" type="text" class="input-small" style="width:90%" value="<?php echo $hora_fin; ?>" >
								<span class="add-on"><i class="icon-time"></i></span>
							</div>
							<span class="help-block">Usado para construir la agenda semanal</span>
						</div>
					</fieldset>
				</form>
			</div>
			<!-- /Columna fluida con peso 9/12 -->
			

		</div>
	</div>

	<!-- Scripts -->

	

	<script>
		$(document).ready(function(){
			$('#lnkGuardar').click(function(){ manto.guardar(); });
			
			$('#timeHoraInicio').timepicker({ 
				minuteStep: 1, showInputs: true, showSeconds: false, showMeridian: true 
			}).on("changeTime.timepicker",function(e){ manto.procesarMinutos(e.time,"inicio"); });
			$('#timeHoraInicio').timepicker('setTime','<?php echo $hora_inicio; ?>');

			$('#timeHoraFin').timepicker({ 
				minuteStep: 1, showInputs: true, showSeconds: false, showMeridian: true 
			}).on("changeTime.timepicker",function(e){ manto.procesarMinutos(e.time,"fin"); });
			$('#timeHoraFin').timepicker('setTime','<?php echo $hora_fin; ?>');
		});


		var manto = {
			hora_inicio:0,
			hora_fin:0,

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
				var errores=0;
				var iv1 = $('#txtNombreEmpresa').val();
				var iv2 = $('#txtNombreSistema').val();
				var iv3 = parseInt($('#txtDuracion').val());$('#txtDuracion').val(iv3);
				var iv4 = manto.hora_inicio;
				var iv5 = manto.hora_fin;

				if(iv1==''){ $('#txtNombreEmpresa').addClass('error_requerido'); errores++; }
				if(iv2==''){ $('#txtNombreSistema').addClass('error_requerido'); errores++; }
				if(iv3==''){ $('#txtDuracion').addClass('error_requerido'); errores++; }
				if(iv1.length>50){ $('#txtNombreEmpresa').addClass('error_requerido').attr('title','No debe sobrepasar de 50 caracteres'); errores++; }
				if(iv2.length>50){ $('#txtNombreSistema').addClass('error_requerido').attr('title','No debe sobrepasar de 50 caracteres'); errores++; }
				if(iv3>720){ $('#txtDuracion').addClass('error_requerido').attr('title','Una cita no debe sobrepasar 12 horas de duracion'); errores++; }
				if(errores>0){
					humane.log('Complete los campos requeridos');
					return false;
				}else{
					return true;
				}
			},




			guardar:function(){
				var _t = this;
				if(!_t.validarForm()){ return; }
				
				var empresa = $('#txtNombreEmpresa').val();
				var sistema = $('#txtNombreSistema').val();
				var duracion = parseInt($('#txtDuracion').val());
				var hi = _t.hora_inicio;
				var hf = _t.hora_fin;
				
				if(this.estado=='agregar'){ this.id=''; }
				var datos = 'action=sv_conf&empresa='+empresa+'&sistema='+sistema+'&duracion='+duracion+'&hinicio='+hi+'&hfin='+hf;

				$.ajax({
					url:'stores/configuracion.php',
					data:datos, dataType:'json', type:'POST',
					complete:function(datos){
						var T = jQuery.parseJSON(datos.responseText);

						humane.log(T.msg);
					}
				});
			},

			toggle:function(v){
				if(v){ $('#guardarBtn').removeClass('disabled').html('Guardar'); }
				else{ $('#guardarBtn').addClass('disabled').html('Guardando...'); }
			}
		}


	</script>


	<!-- Modales -->

	<!-- Agregar -->
	<div id="AgregarTipo" class="modal hide fade modalPequena" role="dialog" aria-labelledby="AgregarTipo" aria-hidden="true">
		
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h3 id="modalHead">Tipo de Documento</h3>
		</div>
		<div class="modal-body">
			<form>
				<fieldset>
					<label id="nombreTipo_label" class="requerido" style="margin-top:5px;">Nombre</label>
					<input id="nombreTipo" type="text" min-length="2" class="input-block-level" placeholder="Escribir..." >
				</fieldset>
			</form>
		</div>
		<div class="modal-footer">
			<button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
			<button id="guardarBtn" class="btn btn-primary">Guardar</button>
		</div>

	</div>



<?php include('res/partes/pie.pagina.php'); ?>

