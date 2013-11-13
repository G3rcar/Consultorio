<?php
include("sesion.php");
//- Incluimos la clase de conexion e instanciamos del objeto principal
include_once("libs/php/class.connection.php");
include_once("libs/php/class.objetos.base.php");

$botones_menu["limpio"]=true;
$botones_configuracion["configuracion"]=true;

$conexion = new Conexion();

//$paises="<option value='0'>-</option>";
$selectPaises = "SELECT pai_id,pai_nom FROM pais ORDER BY pai_nom";
$res = $conexion->execSelect($selectPaises);
if($res["num"]>0){
	while($iPai = $conexion->fetchArray($res["result"])){
		$paises .= "<option value='".$iPai["pai_id"]."'>".$iPai["pai_nom"]."</option>";
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


	<h3>Sucursales</h3>

	<div class="container-fluid">
		<div class="row-fluid">
			
			<!-- Columna fluida con peso 3/12 -->
			<div class="span3">
				<?php include_once('res/partes/herramientas.formularios.php'); ?>
			</div>
			<!-- /Columna fluida con peso 3/12 -->


			<!-- Columna fluida con peso 9/12 -->
			<div id="AgregarSuc" class="span9">
				<form id="frmSucursal">
					<fieldset>
						<legend>General</legend>
						<div class="span5">
							<label id="nombreSuc_label" class="requerido">Nombre de la Sucursal</label>
							<input id="nombreSuc" type="text" min-length="2" class="input-block-level" >
						</div>
						
					</fieldset>
					<br>
					<fieldset>

						<legend>Direccion</legend>
							<div class="span5">
								<label id="pais_label">Pais</label>
								<select id="pais" class="input-block-level" >
									<?php echo $paises; ?>
								</select>
							</div>
							<div class="span5">
								<label id="departamento_label">Departamento</label>
								<select id="departamento" class="input-block-level" >
								</select>
							</div>
							<div class="span5">
								<label id="municipio_label" class="requerido">Municipio</label>
								<select id="municipio" class="input-block-level">
								</select>
							</div>
							<div class="span5">
								<label id="distritoDir_label">Distrito</label>
								<input id="distritoDir" type="text" min-length="2" class="input-block-level" >
							</div>
							<div class="span5">
								<label id="coloniaDir_label" >Colonia</label>
								<input id="coloniaDir" type="text" min-length="2" class="input-block-level" >
							</div>
							<div class="span5">
								<label id="calleDir_label" class="requerido">Calle</label>
								<input id="calleDir" type="text" min-length="2" class="input-block-level" >
							</div>
							<div class="span5">
								<label id="complementocalleDir_label" >Complemento Calle</label>
								<input id="complementocalleDir" type="text" min-length="2" class="input-block-level" >
							</div>
							<div class="span5">
								<label id="condominioDir_label">Condominio</label>
								<input id="condominioDir" type="text" min-length="2" class="input-block-level" >
							</div>
							<div class="span5">
								<label id="condominio2Dir_label" >Condominio 2</label>
								<input id="condominio2Dir" type="text" min-length="2" class="input-block-level" >
							</div>
							<div class="span5">
								<label id="casaDir_label">Casa</label>
								<input id="casaDir" type="text" min-length="2" class="input-block-level" >
							</div>
							<div class="span10">
								<label id="referenciaDir_label">Referencia</label>
								<textarea id="referenciaDir" type="text" min-length="2" class="input-block-level" ></textarea>
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
			$('#lnkCancelar').attr('href','sucursales.php');
			$('#lnkLimpiar').click(function(){
				document.getElementById('frmSucursal').reset();
			});
			
			$("#pais").select2();
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
				
				bootbox.confirm("¿Esta seguro de eliminar los registros?", function(confirm) {
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

