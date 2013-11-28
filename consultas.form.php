<?php
include("sesion.php");
//- Incluimos la clase de conexion e instanciamos del objeto principal
include_once("libs/php/class.connection.php");
include_once("libs/php/class.objetos.base.php");

$botones_menu["limpio"]=true;
$botones_configuracion["configuracion"]=true;

$conexion = new Conexion();

$edicion=false;
$edicion=(isset($_GET["i"]))?true:false;

$idC = (isset($_GET["c"]))?(int)$conexion->escape($_GET["c"]):0;


$citas="<option value='-'>-</option>";
$idPrimerCita="0";
$selectCitas = "SELECT c.cit_id,c.cit_com,p.pac_nom,p.pac_ape,
				DATE_FORMAT(c.cit_fecha_cita,'%d/%b/%Y %h:%i %p') AS 'fecha'
				FROM cita AS c INNER JOIN paciente AS p ON c.cit_idpac = p.pac_id
				WHERE c.cit_fecha_cita >= NOW()";
$res = $conexion->execSelect($selectCitas);
if($res["num"]>0){
	while($iPai = $conexion->fetchArray($res["result"])){
		$citas .= "<option value='".$iPai["cit_id"]."'>".utf8_encode($iPai["pac_nom"]." ".$iPai["pac_ape"])." [".$iPai["fecha"]."] #### ".$iPai["cit_com"]."</option>";
	}
}


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

<h3>Consulta</h3>

	<div class="container-fluid">
		<div class="row-fluid">
			
			<!-- Columna fluida con peso 3/12 -->
			<div class="span3">
				<div id="sidebarNav" class="well sidebar-nav"  data-spy="affix" data-offset-top="200">
					<img id="progressBar_main" src="res/img/loading.gif" class="loading_indicator_mannto" />
					<ul class="nav nav-list">
						<li class="nav-header">Opciones</li>
						<li><a id="lnkGuardar" href="#"><i class="icon-hdd"></i> Guardar</a></li>
						<li><a id="lnkLimpiar" href="#"><i class="icon-repeat"></i> Limpiar</a></li>
						<li><a id="lnkCancelar" href="#"><i class="icon-remove"></i> Cancelar</a></li>

						<li class="nav-header">Herramientas</li>
						<li><a id="lnkFactura" href="#"><i class="icon-shopping-cart" title="Guardar y generar factura"></i> Facturar</a></li>

					</ul>
				</div>
			</div>
			<!-- /Columna fluida con peso 3/12 -->


			<!-- Columna fluida con peso 9/12 -->
			<div id="AgregarSuc" class="span9">
				<form id="frmConsulta">
					<fieldset>
						<legend>Cita</legend>
						<div class="span10">
							<select id="idCita" class="input-block-level" >
								<?php echo $citas; ?>
							</select>
						</div>

						<div class="well span10 row-fluid" style="margin-top:20px;">
							<table class="table" style="margin-bottom:0"> 
								<tr><td style="border-top:none;"><b>Fecha:</b> dd/mm/yyyy </td><td style="border-top:none;"><b>Hora:</b> --:-- </td></tr>
								<tr><td colspan="2" style="border-top:none;"><b>Paciente:</b> </td></tr>
								<tr><td colspan="2" style="border-top:none;"><b>Doctor:</b> </td></tr>
							</table>
						</div>
						
					</fieldset>
					<br>
					<fieldset>

						<legend>Informaci&oacute;n</legend>
							<div class="span10">
								<label id="descripcion_label">Descripci&oacute;n</label>
								<textarea id="descripcion" type="text" min-length="2" class="input-block-level" ></textarea>
							</div>
							<div class="span10">
								<label id="diagnostico_label">Diagn&oacute;stico</label>
								<textarea id="diagnostico" type="text" min-length="2" style="height:100px;" class="input-block-level" ></textarea>
							</div>

					</fieldset>
					<br>
				</form>
			</div>
			<!-- /Columna fluida con peso 9/12 -->
			

		</div>
	</div>

	<!-- Scripts -->

	

	<script>
		$(document).ready(function(){
			cargarTabla();

			$('#lnkGuardar').click(function(){ manto.guardar(); });
			$('#lnkCancelar').attr('href','consultas.php');
			$('#lnkLimpiar').click(function(){ document.getElementById('frmConsulta').reset(); });

			$('#sidebarNav').affix();
			
			function format(obj) {
				if(obj.text=="-") return obj.text;
				var s = obj.text.split('####');
				var c = (typeof(s[1])=="undefined")?"":s[1];
				return "<b>"+s[0] + "</b><br/>" + c;
			}
			function formatSelect(obj){
				var s = obj.text.split('####');
				return s[0];
			}
			$("#idCita").select2({
				placeholder: "Seleccionar",
				formatResult:format,
				formatSelection:formatSelect,
				escapeMarkup: function(m) { return m; }, 
			});
			
		});

		function validarForm(){
			var errores = 0;
			var v1 = $('#nombreSuc').val();
			var v2 = $('#municipio').val();
			var v3 = $('#calleDir').val();

			if(v1==''){ $('#nombreSuc').addClass('error_requerido'); errores++; }
			if(v2==''){ $('#municipio').addClass('error_requerido'); errores++; }
			if(v3==''){ $('#calleDir').addClass('error_requerido'); errores++; }
			if(errores>0){
				humane.log('Complete los campos requeridos');
				return false;
			}else{
				return true;
			}
		}

		function cargarTabla(){
			$.ajax({
				url:'stores/sucursales.php',
				data:'action=gd_suc', dataType:'json', type:'POST',
				complete:function(datos){
					$("#contenedorTabla").html(datos.responseText);
				}
			});
		}



		var manto = {
			estado: 'agregar',
			id:'',

			agregar:function(){
				this.estado = 'agregar';
				this.id = '';
				$('#nombreSuc_label').removeClass('error_requerido');
				$('#nombreSuc').val('');
				$('#AgregarSuc').modal('show');


			},
			editar:function(id){
				this.estado = 'editar';
				this.id = id;
				$.ajax({
					url:'stores/sucursales.php',
					data:'action=rt_suc&id='+id, dataType:'json', type:'POST',
					complete:function(datos){
						var T = jQuery.parseJSON(datos.responseText);
						
						$('#nombreSuc').removeClass('error_requerido');
						$('#nombreSuc').val(T.nombre);
						$('#AgregarSuc').modal('show');
					}
				});

			},
			borrar:function(id){
				var tipo = (id)?'uno':'varios';
				var seleccion = gridCheck.getSelectionJSON('gridSucursales');
				if(tipo=='varios' && seleccion==false){
					humane.log('No ha seleccionado ning&uacute;n registro');
					return;
				}

				var ids = (tipo=='uno')?id:seleccion;
				var action = (tipo=='uno')?'br_suc':'br_variossuc' ;
				
				bootbox.confirm("&iquest;Esta seguro de eliminar los registros?", function(confirm) {
					if(confirm){
						$.ajax({
							url:'stores/sucursales.php',
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
				var nombre = $('#nombreSuc').val();
				var condominio = $('#condominioDir').val();
				var condominio2 = $('#condominio2Dir').val();
				var calle = $('#calleDir').val();
				var calleComplemento = $('#complementocalleDir').val();
				var casa = $('#casaDir').val();
				var colonia = $('#coloniaDir').val();
				var distrito = $('#distritoDir').val();
				var referencia = $('#referenciaDir').val();

				if(this.estado=='agregar'){ this.id=''; }
				var datos = 'action=suc&nombre='+nombre+'&id='+this.id;

				$.ajax({
					url:'stores/sucursales.php',
					data:datos, dataType:'json', type:'POST',
					complete:function(datos){
						var T = jQuery.parseJSON(datos.responseText);

						humane.log(T.msg);
						if(T.success=="true"){
							$('#AgregarSuc').modal('hide');
							manto.toggle(true);
							cargarTabla();
						}
						manto.toggle(true);
					}
				});
			},

			toggle:function(v){
				if(v){ $('#guardarSuc').removeClass('disabled').html('Guardar'); }
				else{ $('#guardarSuc').addClass('disabled').html('Guardando...'); }
			}
		}


	</script>


	<!-- Modales -->

	<!-- Agregar -->
	


<?php include('res/partes/pie.pagina.php'); ?>

