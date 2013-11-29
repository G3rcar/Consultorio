<?php
include("sesion.php");
//- Incluimos la clase de conexion e instanciamos del objeto principal
include_once("libs/php/class.connection.php");

$botones_menu["limpio"]=true;
$botones_herramientas["pacientes"]=true;

$conexion = new Conexion();
$ed = false;
$campos = "";
$dataP = "";

$fecha_actual = strtotime(date("Y-m-d"));


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
<link href="res/css/datepicker.css" rel="stylesheet"/>
<!-- /Estilo extra -->

<!-- Scripts extra -->
<script type="text/javascript" src="libs/js/select2/select2.js"></script>
<script type="text/javascript" src="libs/js/select2/select2_locale_es.js"></script>
<script type="text/javascript" src="libs/js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="libs/js/bootstrap-datepicker.es.js"></script>
<script type="text/javascript" src="libs/js/custom/objetos-comunes.js"></script>
<!-- /Scripts extra -->

<h3> Nuevo paciente </h3>
<div class="container-fluid">
		<div class="row-fluid">
			
			<!-- Columna fluida con peso 3/12 -->
			<div class="span3">
				<?php include_once('res/partes/herramientas.formularios.php'); ?>
			</div>
			<!-- /Columna fluida con peso 3/12 -->

			
			<div class="span9">
			
				<form id="frmPaciente">
					
					<fieldset>
						<legend>Datos generales</legend>
						<div class="span5">
							<label>Nombres</label> 
							<input id="txtNombre" type="text" placeholder="Escriba el nombre" style="width:95%;" >
						</div>
						<div class="span5">
							<label>Apellidos</label>
							<input id="txtApellido" type="text" placeholder="Escriba el Apellido" style="width:95%;" >
	                	</div>
	                	<div class="span5">
		                	<label>Fecha de Nacimiento</label>
						<input type="text" style="width:95%" placeholder="dd/mm/yyyy" id="dateFechaNac" >
						</div>
					 	<div class="span5">
							<label>Peso</label>
							<input id="txtPeso" type="text" placeholder="Escriba el peso" style="width:95%;" ><br>
						</div>
						<div class="span5">
							<label>Altura</label>
							<input id="txtAltura" type="text" placeholder="Escriba la altura" style="width:95%;"  >
					    </div>
					    <div class="span5">
					    	<label>Genero</label>
		                    <input type="radio" name="rbtnGenero" id="rbtnMasculino" value="M" > Masculino 
							<input type="radio" name="rbtnGenero" id="rbtnFemenino" value="F" >  Femenino <br>
					    </div>
						<div class="span10">
							<label>Alergias</label>
	  						<textarea rows="3"  name="alergiaspac" cols= "50" class="span9" placeholder="Escriba Alergias" style="width:100%;" ></textarea>
	  					</div>
	  					<div class="span5">
	  						<label>Telefono Casa</label>
	  						<input id="txtTelpac" type="text" placeholder="Escriba el telefono" value="" style="width:95%;" >
	  					</div>
	  					<div class="span5">
	  						<label>Telefono Celular</label>
	  						<input id="txtCelc" type="text" placeholder="Escriba el telefono" value="" style="width:95%;" >
	  					</div>

					</fieldset>

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


				</form>
			
			</div>
		</div>



	<script>
		$(document).ready(function(){
			$('#lnkGuardar').click(function(){ manto.guardar(); });
			$('#lnkCancelar').attr('href','pacientes.php');
			$('#lnkLimpiar').click(function(){
				document.getElementById('frmPaciente').reset();
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

			$("#dateFechaNac").datepicker({
				format:'dd/mm/yyyy', endDate:nowText, autoclose:true, language:'es',
			})

		});
	
		var nowText = '<?php echo $fecha_actual; ?>';

		var mantoPaciente = {

			estado:'agregar',
			
			validarForm:function(){
				var errores=0;
				var iv1 = $('#txtNompaciente').val();
				var iv2 = $('txtApellidoPac').val();
				var iv3 = $('#date').val();
				var iv4 = $('#txtPesopac').val();
				var iv5 = $('#txtAltpac').val();
				var iv6 = $('#alergiaspac').val();
				var iv7 = $('#dirpac').val();
				var iv8 = $('#txtTelpac').val();
				

				if(iv1==''){ $('#txtNompaciente').addClass('error_requerido'); errores++; }
				if(iv2==''){ $('txtApellidoPac').addClass('error_requerido'); errores++; }
				if(iv3==''){ $('#date').addClass('error_requerido'); errores++; }
				if(iv4==''){ $('#txtPesopac').addClass('error_requerido'); errores++; }
				if(iv5==''){ $('#txtAltpac').addClass('error_requerido'); errores++; }
				if(iv6==''){ $('#alergiaspac').addClass('error_requerido'); errores++; }
				if(iv7==''){ $('#dirpac').addClass('error_requerido'); errores++; }
				if(iv8==''){ $('#txtTelpac').addClass('error_requerido'); errores++; }

			

				if(iv1.length>50){ $('#txtNompaciente').addClass('error_requerido').attr('title','No debe sobrepasar de 50 caracteres'); errores++; }
				if(iv2.length>50){ $('txtApellidoPac').addClass('error_requerido').attr('title','No debe sobrepasar de 50 caracteres'); errores++; }
				if(iv7.length>60){ $('#dirpac').addClass('error_requerido').attr('title','No debe sobrepasar de 60 caracteres'); errores++; }
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
				
				var nombre = $('#txtNompaciente').val();
				var apellido = $('txtApellidoPac').val();
				var fecha_nac = $('#date').val();
				var peso = $('#txtPesopac').val();
				var altura = $('#txtAltpac').val();
				var alergias = $('#alergiaspac').val();
				var direccion = $('#dirpac').val();
				var telcasa = $('#txtTelpac').val();
				var telcel = $('#txtCelc').val();
				var frecha_cre = $('#pac_fecha_cre').val();

				var datos = 'action=sv_conf&nombre='+nombre+'&apellido='+apellido+'&fecha_nac='+fecha_nac+'&peso='+peso+'&altura='+altura+'&alergias='+altura+
				'&alergias='+alergias+'&direccion='+direccion+'&telcasa='+telcasa+'&telcel='+telcel+'&frecha_cre'+frecha_cre;

				$.ajax({
					url:'stores/expediente.php',
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
<?php include('res/partes/pie.pagina.php'); ?>




			
			
				