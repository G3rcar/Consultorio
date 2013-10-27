<?php
include("sesion.php");
//- Incluimos la clase de conexion e instanciamos del objeto principal
include_once("libs/php/class.connection.php");

$botones_menu["limpio"]=true;
$botones_configuracion["configuracion"]=true;


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
							<input type="text" placeholder="Escriba el nombre" style="width:100%;">
							<span class="help-block">Aparecer&aacute; al momento de iniciar sesi&oacute;n</span>

						</div>
						<div class="span5">
							<label>Nombre del Sistema</label>
							<input type="text" placeholder="Escriba el nombre" style="width:100%;">
							<span class="help-block">Aparecer&aacute; en la parte superior del sistema</span>
						</div>
					</fieldset>
					<br>
					<fieldset>

						<legend>Horario</legend>
						<div class="span5">
							<label>Hora de inicio</label>
							<div class="input-append bootstrap-timepicker">
								<input id="hora_inicio" type="text" class="input-small" style="width:90%">
								<span class="add-on"><i class="icon-time"></i></span>
							</div>
							<span class="help-block">Usado para construir la agenda semanal</span>

							<label>Duraci&oacute;n de las citas</label>
							<div class="input-append">
								<input type="number" placeholder="Escriba la duraci&oacute;n..." style="width:81%;">
								<span class="add-on">minutos</span>
							</div>
							
						</div>
						<div class="span5">
							<label>Hora de fin</label>
							<div class="input-append bootstrap-timepicker">
								<input id="hora_fin" type="text" class="input-small" style="width:90%">
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
			//cargarTabla();

			$('#lnkAgregar').click(function(){ manto.agregar(); });
			$('#lnkBorrar').click(function(){ manto.borrar(); });
			$('#guardarBtn').click(function(){ manto.guardar(); });

			$('#hora_inicio').timepicker({ 
				minuteStep: 1, showInputs: true, showSeconds: false, showMeridian: true 
			}).on("changeTime.timepicker",function(e){ manto.procesarMinutos(e.time,"inicio"); });
			$('#hora_fin').timepicker({ 
				minuteStep: 1, showInputs: true, showSeconds: false, showMeridian: true 
			}).on("changeTime.timepicker",function(e){ manto.procesarMinutos(e.time,"fin"); });
			
			
		});

		function validarForm(){
			var errores=0;
			var iv1 = $('#nombreTipo').val();
			if(iv1==''){ $('#nombreTipo').addClass('error_requerido'); errores++; }
			if(iv1.length>45){ $('#nombreTipo').addClass('error_requerido').attr('title','No debe sobrepasar de 45 caracteres'); errores++; }
			if(errores>0){
				humane.log('Complete los campos requeridos');
				return false;
			}else{
				return true;
			}
		}

		function cargarTabla(){
			$.ajax({
				url:'stores/documentos.php',
				data:'action=gd_tipo', dataType:'json', type:'POST',
				complete:function(datos){
					$("#contenedorTabla").html(datos.responseText);
				}
			});
		}



		var manto = {
			estado: 'agregar',
			id:'',

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






			agregar:function(){
				this.estado = 'agregar';
				$('#modalHead').html("Agregar Tipo de Documento");
				this.id = '';
				$('#nombreTipo').removeClass('error_requerido');
				$('#nombreTipo').val('');
				$('#AgregarTipo').modal('show');
			},
			editar:function(id){
				this.estado = 'editar';
				$('#modalHead').html("Editar Tipo de Documento");
				this.id = id;
				$.ajax({
					url:'stores/documentos.php',
					data:'action=rt_tipo&id='+id, dataType:'json', type:'POST',
					complete:function(datos){
						var T = jQuery.parseJSON(datos.responseText);
						
						$('#nombreTipo_label').removeClass('error_requerido');
						$('#nombreTipo').val(T.nombre);
						$('#AgregarTipo').modal('show');
					}
				});

			},
			borrar:function(id){
				var tipo = (id)?'uno':'varios';
				var seleccion = gridCheck.getSelectionJSON('gridTipos');
				if(tipo=='varios' && seleccion==false){
					humane.log('No ha seleccionado ning&uacute;n registro');
					return;
				}

				var ids = (tipo=='uno')?id:seleccion;
				var action = (tipo=='uno')?'br_tipo':'br_variostipos' ;
				
				bootbox.confirm("¿Esta seguro de eliminar los registros?", function(confirm) {
					if(confirm){
						$.ajax({
							url:'stores/documentos.php',
							data:'action='+action+'&id='+ids, dataType:'json', type:'POST',
							complete:function(datos){
								var T = jQuery.parseJSON(datos.responseText);
								
								humane.log(T.msg)
								if(T.success=='true') cargarTabla();
							}
						});
					}
				}); 
			},

			guardar:function(){
				if(!validarForm()){ return; }
				manto.toggle(false);
				var nombre = $('#nombreTipo').val();
				
				if(this.estado=='agregar'){ this.id=''; }
				var datos = 'action=sv_tipo&nombre='+nombre+'&id='+this.id;

				$.ajax({
					url:'stores/documentos.php',
					data:datos, dataType:'json', type:'POST',
					complete:function(datos){
						var T = jQuery.parseJSON(datos.responseText);

						humane.log(T.msg);
						if(T.success=="true"){
							$('#AgregarTipo').modal('hide');
							manto.toggle(true);
							cargarTabla();
						}
						manto.toggle(true);
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

