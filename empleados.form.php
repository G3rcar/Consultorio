<?php
include("sesion.php");
//- Incluimos la clase de conexion e instanciamos del objeto principal
include_once("libs/php/class.connection.php");
include_once("libs/php/class.objetos.base.php");

$botones_menu["limpio"]=true;
$botones_configuracion["configuracion"]=true;

$conexion = new Conexion();

$paises="";
$idPrimerPais="0";
$selectPaises = "SELECT pai_id,pai_nom FROM pais ORDER BY pai_nom";
$res = $conexion->execSelect($selectPaises);
if($res["num"]>0){
	while($iPai = $conexion->fetchArray($res["result"])){
		$idPrimerPais = ($idPrimerPais=="0")?$iPai["pai_id"]:$idPrimerPais;
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
				<form id="frmEmpleado">
					<fieldset>
						<legend>Datos Generales  del Empleado</legend>
						<div class="span5">
							<label id="nombreEmp_label" class="requerido">Nombre del empleado</label>
							<input id="nombreEmp" type="text" min-length="2" class="input-block-level" >
						</div>
						
                                                <div class="span5">
							<label id="nombreApe_label" class="requerido">Apellido del empleado</label>
							<input id="nombreApe" type="text" min-length="2" class="input-block-level" >
						</div>
                                                
                                                <div class="span5">
							<label id="nombreFecha_nac_label" class="requerido">Fecha de nacimiento</label>
							<input id="nombreFecha_nac" type="text" min-length="2" class="input-block-level" >
						</div>
                                                
                                                <div class="span5">
							<label id="nombreSuc_label" class="requerido">Sucursal</label>
							<input id="nombreSuc" type="text" min-length="2" class="input-block-level" >
						</div>
						
                                                <div class="span5">
							<label id="nombreCar_label" class="requerido">Cargo</label>
							<input id="nombreCar" type="text" min-length="2" class="input-block-level" >
						</div>
                                                
					</fieldset>
					<br>
					<fieldset>

						<legend>Direccion</legend>
							<div class="span5">
								<label id="pais_label">Pais</label>
								<select id="idPais" class="input-block-level" >
									<?php echo $paises; ?>
								</select>
							</div>
							<div class="span5">
								<label id="departamento_label">Departamento</label>
								<input type="hidden" id="idDepto" class="input-block-level" />
							</div>
							<div class="span5">
								<label id="municipio_label" class="requerido">Municipio</label>
								<input type="hidden" id="idMuni" class="input-block-level" />
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
                                        
                                        <fieldset>
						<legend>Usuario</legend>
						<div class="span5">
							<label id="nombreEmp_label" class="requerido">Nombre del empleado</label>
							<input id="nombreEmp" type="text" min-length="2" class="input-block-level" >
						</div>
						
                                                <div class="span5">
							<label id="nombreApe_label" class="requerido">Apellido del empleado</label>
							<input id="nombreApe" type="text" min-length="2" class="input-block-level" >
						</div>
                                                
                                                <div class="span5">
							<label id="nombreFecha_nac_label" class="requerido">Fecha de nacimiento</label>
							<input id="nombreFecha_nac" type="text" min-length="2" class="input-block-level" >
						</div>
                                                
                                                <div class="span5">
							<label id="nombreSuc_label" class="requerido">Sucursal</label>
							<input id="nombreSuc" type="text" min-length="2" class="input-block-level" >
						</div>
						
                                                <div class="span5">
							<label id="nombreCar_label" class="requerido">Cargo</label>
							<input id="nombreCar" type="text" min-length="2" class="input-block-level" >
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
			$('#lnkCancelar').attr('href','empleados.php');
			$('#lnkLimpiar').click(function(){
				document.getElementById('frmEmpleados').reset();
			});
			
			$("#idPais").select2();
			$("#idPais").change(function(){
				var idPais = $(this).val();
				$("#idDepto").select2({
					placeholder: "Seleccionar",
					ajax: {
						url: "stores/municipios.php", dataType: 'json', type:'POST',
						data: function (term, page) {
							return { q: term, action:'ls_depto', pais:idPais };
						},
						results: function (data, page) {
							return {results: data.results};
						}
					}
				});
				$("#idDepto").select2("enable",true);
			});
			$("#idDepto").select2({
				placeholder: "Seleccionar", enable:false,
				ajax: {
					url: "stores/municipios.php", dataType: 'json', type:'POST',
					data: function (term, page) {
						return { q: term, action:'ls_depto', pais:'<?php echo $idPrimerPais; ?>' };
					},
					results: function (data, page) {
						return {results: data.results};
					}
				}
			});
			$("#idDepto").change(function(){
				var idDepto = $(this).val();
				$("#idMuni").select2({
					placeholder: "Seleccionar",
					ajax: {
						url: "stores/sucursales.php", dataType: 'json', type:'POST',
						data: function (term, page) {
							return { q: term, action:'ls_muni', depto:idDepto };
						},
						results: function (data, page) {
							return {results: data.results};
						}
					}
				});
				$("#idMuni").select2("enable",true);
			});

			$("#idMuni").select2({
				placeholder: "Seleccionar", enable:false,
				ajax: {
					url: "stores/empleados.php", dataType: 'json', type:'POST',
					data: function (term, page) {
						return { q: term, action:'ls_muni' };
					},
					results: function (data, page) {
						return {results: data.results};
					}
				}
			});
			$("#idMuni").select2("enable",false);
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
				url:'stores/empleados.php',
				data:'action=gd_emp', dataType:'json', type:'POST',
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
				$('#nombreEmp_label').removeClass('error_requerido');
				$('#nombreEmp').val('');
				$('#AgregarEmp').modal('show');


			},
			editar:function(id){
				this.estado = 'editar';
				this.id = id;
				$.ajax({
					url:'stores/empleados.php',
					data:'action=rt_emp&id='+id, dataType:'json', type:'POST',
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
				var action = (tipo=='uno')?'br_suc':'br_variosemp' ;
				
				bootbox.confirm("&iquest;Esta seguro de eliminar los registros?", function(confirm) {
					if(confirm){
						$.ajax({
							url:'stores/empleados.php',
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
				var nombre = $('#nombreEmp').val();
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
					url:'stores/empleados.php',
					data:datos, dataType:'json', type:'POST',
					complete:function(datos){
						var T = jQuery.parseJSON(datos.responseText);

						humane.log(T.msg);
						if(T.success=="true"){
							$('#AgregarEmp').modal('hide');
							manto.toggle(true);
							cargarTabla();
						}
						manto.toggle(true);
					}
				});
			},

			toggle:function(v){
				if(v){ $('#guardarEmp').removeClass('disabled').html('Guardar'); }
				else{ $('#guardarEmp').addClass('disabled').html('Guardando...'); }
			}
		}


	</script>


	<!-- Modales -->

	<!-- Agregar -->
	


<?php include('res/partes/pie.pagina.php'); ?>

