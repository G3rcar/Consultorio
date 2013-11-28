<?php
include("sesion.php");
//- Incluimos la clase de conexion e instanciamos del objeto principal
include_once("libs/php/class.connection.php");
include_once("libs/php/class.objetos.base.php");

$botones_menu["limpio"]=true;
$botones_configuracion["configuracion"]=true;

$conexion = new Conexion();
$ed = false;
$campos = "";
$dataP = "";
if(isset($_GET["i"])){
	$id = (int)$conexion->escape($_GET["i"]);
	$selNom = "SELECT suc_nom,suc_iddir FROM sucursal WHERE suc_id = {$id} ";
	$res = $conexion->execSelect($selNom);
	if($res["num"]>0){
		$iSu = $conexion->fetchArray($res["result"]);
		$nomSuc = utf8_encode($iSu["suc_nom"]);
		$idDir = utf8_encode($iSu["suc_iddir"]);

		$selDir = "SELECT dir_cond,dir_cond2,dir_calle,dir_compcalle, dir_casa, dir_col, dir_dist, dir_ref,dir_idmun FROM direccion WHERE dir_id = {$idDir} ";
		$res = $conexion->execSelect($selDir);
		if($res["num"]>0){
			$campos = $conexion->fetchArray($res["result"]);
			$selDir = "SELECT pai_id,pai_nom,dep_id,dep_nom,mun_id,mun_nom FROM municipio AS m INNER JOIN departamento AS d ON m.mun_iddep = d.dep_id
						INNER JOIN pais AS p ON d.dep_idpai = p.pai_id WHERE m.mun_id = ".$campos["dir_idmun"];
			$resM = $conexion->execSelect($selDir);
			$dataP = $conexion->fetchArray($resM["result"]);

		}
		$ed = true;
	}
	
}

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


$titulo = (!$ed)?"Agregar sucursal":"Editar sucursal";

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

<h3><?php echo $titulo; ?></h3>

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
							<input id="nombreSuc" type="text" min-length="2" value="<?php echo ($ed)?utf8_encode($nomSuc):""; ?>" class="input-block-level" >
						</div>
						
					</fieldset>
					<br>
					<fieldset>

						<legend>Direccion</legend>
							<div class="span5">
								<label id="pais_label" class="requerido">Pais</label>
								<select id="idPais" class="input-block-level" >
									<?php echo $paises; ?>
								</select>
							</div>
							<div class="span5">
								<label id="departamento_label" class="requerido">Departamento</label>
								<input type="hidden" id="idDepto" class="input-block-level" />
							</div>
							<div class="span5">
								<label id="municipio_label" class="requerido">Municipio</label>
								<input type="hidden" id="idMuni" class="input-block-level" />
							</div>
							<div class="span5">
								<label id="distritoDir_label">Distrito</label>
								<input id="distritoDir" type="text" min-length="2" class="input-block-level" value="<?php echo ($ed)?utf8_encode($campos["dir_dist"]):""; ?>" >
							</div>
							<div class="span5">
								<label id="coloniaDir_label" >Colonia</label>
								<input id="coloniaDir" type="text" min-length="2" class="input-block-level" value="<?php echo ($ed)?utf8_encode($campos["dir_col"]):""; ?>" >
							</div>
							<div class="span5">
								<label id="calleDir_label" class="requerido">Calle</label>
								<input id="calleDir" type="text" min-length="2" class="input-block-level" value="<?php echo ($ed)?utf8_encode($campos["dir_calle"]):""; ?>" >
							</div>
							<div class="span5">
								<label id="complementocalleDir_label" >Complemento Calle</label>
								<input id="complementocalleDir" type="text" min-length="2" class="input-block-level" value="<?php echo ($ed)?utf8_encode($campos["dir_compcalle"]):""; ?>" >
							</div>
							<div class="span5">
								<label id="condominioDir_label">Condominio</label>
								<input id="condominioDir" type="text" min-length="2" class="input-block-level" value="<?php echo ($ed)?utf8_encode($campos["dir_cond"]):""; ?>" >
							</div>
							<div class="span5">
								<label id="condominio2Dir_label" >Condominio 2</label>
								<input id="condominio2Dir" type="text" min-length="2" class="input-block-level" value="<?php echo ($ed)?utf8_encode($campos["dir_cond2"]):""; ?>" >
							</div>
							<div class="span5">
								<label id="casaDir_label">Casa</label>
								<input id="casaDir" type="text" min-length="2" class="input-block-level" value="<?php echo ($ed)?utf8_encode($campos["dir_casa"]):""; ?>" >
							</div>
							<div class="span10">
								<label id="referenciaDir_label">Referencia</label>
								<textarea id="referenciaDir" type="text" min-length="2" class="input-block-level" ><?php echo ($ed)?utf8_encode($campos["dir_ref"]):""; ?></textarea>
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
			//cargarTabla();

			$('#lnkGuardar').click(function(){ manto.guardar(); });
			$('#lnkCancelar').attr('href','sucursales.php');
			$('#lnkLimpiar').click(function(){
				document.getElementById('frmSucursal').reset();
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
					url: "stores/sucursales.php", dataType: 'json', type:'POST',
					data: function (term, page) {
						return { q: term, action:'ls_muni' };
					},
					results: function (data, page) {
						return {results: data.results};
					}
				}
			});
			$("#idMuni").select2("enable",false);

			<?php if($ed){ ?>

			$("#idPais").select2("data",{id:'<?php echo $dataP["pai_id"]; ?>',text:'<?php echo $dataP["pai_nom"]; ?>'});
			$("#idDepto").select2("data",{id:'<?php echo $dataP["dep_id"]; ?>',text:'<?php echo $dataP["dep_nom"]; ?>'});
			$("#idMuni").select2("data",{id:'<?php echo $dataP["mun_id"]; ?>',text:'<?php echo $dataP["mun_nom"]; ?>'});
			$("#idMuni").select2("enable",true);

			<?php } ?>
		});

		function validarForm(){
			var max45 = "Este campo no debe sobrepasar los 45 caracteres";
			var max20 = "Este campo no debe sobrepasar los 20 caracteres";
			var max10 = "Este campo no debe sobrepasar los 10 caracteres";
			var errores = 0;

			var v1 = $('#nombreSuc');//45
			var v2 = $('#idMuni');
			var v3 = $('#calleDir'); //45

			var v4 = $('#distritoDir');//20
			var v5 = $('#coloniaDir');//20
			var v6 = $('#complementocalleDir');//45
			var v7 = $('#condominioDir');//20
			var v8 = $('#condominio2Dir');//20
			var v9 = $('#casaDir');//10
			var v10 = $('#referenciaDir');//45

			if(v1.val()==''){ v1.addClass('error_requerido'); errores++; }
			if(v2.val()==''){ $("#s2id_idMuni").addClass('error_requerido_sel2'); errores++; }
			if(v3.val()==''){ v3.addClass('error_requerido'); errores++; }
			if(v1.val().length>45){ v1.addClass('error_requerido').attr('title',max45); errores++; }
			if(v3.val().length>45){ v3.addClass('error_requerido').attr('title',max45); errores++; }
			if(v6.val().length>45){ v6.addClass('error_requerido').attr('title',max45); errores++; }
			if(v10.val().length>45){ v10.addClass('error_requerido').attr('title',max45); errores++; }
			if(v4.val().length>20){ v4.addClass('error_requerido').attr('title',max20); errores++; }
			if(v5.val().length>20){ v5.addClass('error_requerido').attr('title',max20); errores++; }
			if(v7.val().length>20){ v7.addClass('error_requerido').attr('title',max20); errores++; }
			if(v8.val().length>20){ v8.addClass('error_requerido').attr('title',max20); errores++; }
			if(v9.val().length>10){ v9.addClass('error_requerido').attr('title',max10); errores++; }

			if(errores>0){
				humane.log('Complete los campos requeridos');
				return false;
			}else{
				return true;
			}
		}



		var manto = {
			estado: '<?php echo ($ed)?"editar":"agregar"; ?>',
			standby:true,
			id:'<?php echo ($ed)?$id:''; ?>',

			guardar:function(){
				var _t = this;
				if(!validarForm() || !_t.standby){ return; }
				manto.toggle(false);
				var nombre = $('#nombreSuc').val();
				var municipio = $('#idMuni').val();
				var distrito = $('#distritoDir').val();
				var colonia = $('#coloniaDir').val();
				var calle = $('#calleDir').val();
				var calleComplemento = $('#complementocalleDir').val();
				var condominio = $('#condominioDir').val();
				var condominio2 = $('#condominio2Dir').val();
				var casa = $('#casaDir').val();
				var referencia = $('#referenciaDir').val();

				if(_t.estado=='agregar'){ _t.id=''; }
				var datos = {
					action:'sv_sucursal',
					nombre:nombre, municipio:municipio, distrito:distrito, colonia:colonia, calle:calle, calleComplemento:calleComplemento,
					condominio:condominio, condominio2:condominio2, casa:casa, referencia:referencia, id:_t.id
				}

				$.ajax({
					url:'stores/sucursales.php',
					data:datos, dataType:'json', type:'POST',
					complete:function(datos){
						var T = jQuery.parseJSON(datos.responseText);

						humane.log(T.msg);
						if(T.success=="true"){
							manto.toggle(true);
							window.location.href="sucursales.php";
							//cargarTabla();
						}
						manto.toggle(true);
					}
				});
			},

			toggle:function(v){
				this.standby = v;
			}
		}


	</script>


	<!-- Modales -->

	<!-- Agregar -->
	


<?php include('res/partes/pie.pagina.php'); ?>

