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

$ed=false;
$ed=(isset($_GET["i"]))?true:false;

$idC = (isset($_GET["c"]))?(int)$conexion->escape($_GET["c"]):0;


$citas="<option value='-'>Seleccione una cita</option>";
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


$titulo = (!$ed)?"Agregar datos de consulta":"Editar datos de consulta";

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
.well-small{
	padding-top: 3px;
	padding-bottom: 3px; 
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
				<div id="sidebarNav" class="well sidebar-nav"  data-spy="affix" data-offset-top="200">
					<img id="progressBar_main" src="res/img/loading.gif" class="loading_indicator_mannto" />
					<ul class="nav nav-list">
						<li class="nav-header">Opciones</li>
						<li><a id="lnkGuardar" href="#"><i class="icon-hdd"></i> Guardar</a></li>
						<li><a id="lnkLimpiar" href="#"><i class="icon-repeat"></i> Limpiar</a></li>
						<li><a id="lnkCancelar" href="#"><i class="icon-remove"></i> Cancelar</a></li>

						<li class="nav-header">Herramientas</li>
						<li><a id="lnkFactura" href="#"><i class="icon-shopping-cart" title="Guardar y generar factura"></i> Facturar</a></li>
						<li><a id="lnkImprimir" href="#"><i class="icon-print" title="Guardar y generar factura"></i> Imprimir receta</a></li>

					</ul>
				</div>
			</div>
			<!-- /Columna fluida con peso 3/12 -->


			<!-- Columna fluida con peso 9/12 -->
			<div id="AgregarSuc" class="span9">
				<form id="frmConsulta">
					<fieldset>
						<legend>General</legend>
						<div class="span4">
							<select id="idCita" class="input-block-level" >
								<?php echo $citas; ?>
							</select>
						</div>

						<div class="well well-small span6 row-fluid">
							<table class="table" style="margin-bottom:0"> 
								<tr>
									<td style="border-top:none;padding:0;"><b>Fecha:</b>  <span id="lblFecha">dd/mm/YYYY</span>  </td>
									<td style="border-top:none;padding:0;"><b>Hora:</b>  <span id="lblHora">--:--</span> </td>
								</tr>
							</table>
						</div>
						<div class="well well-small span10 row-fluid">
							<table class="table" style="margin-bottom:0"> 
								<tr><td style="border-top:none;width:80px;"><b>Paciente:</b> </td><td style="border-top:none;"> <span id="lblPaciente"></span> </td></tr>
								<tr><td style="border-top:none;"><b>Doctor:</b> </td><td style="border-top:none;"> <span id="lblDoctor"></span> </td></tr>
							</table>
						</div>
						

						<div class="span10">
							<label id="descripcion_label">Descripci&oacute;n</label>
							<textarea id="descripcion" type="text" min-length="2" class="input-block-level" ></textarea>
						</div>
						<div class="span10">
							<label id="diagnostico_label">Diagn&oacute;stico</label>
							<textarea id="diagnostico" type="text" min-length="2" style="height:100px;" class="input-block-level" ></textarea>
						</div>

						<legend>Receta</legend>
						<div class="span10">
							<label id="detalle_receta_label">Detalle</label>
							<textarea id="detalle_receta" type="text" min-length="2" class="input-block-level" ></textarea>
						</div>
						<div class="span10">
							<label id="descripcion_label">Medicinas</label>
							<a class="btn btn-success" id="btnAgregarMedicina"><i class="icon icon-plus icon-white"></i> Agregar medicina</a>
							<div id="contentMedicinas" class="well" style="margin-top:10px; min-height:100px;"></div>
						</div>

					</fieldset>
				</form>
			</div>
			<!-- /Columna fluida con peso 9/12 -->
			

		</div>
	</div>


	<!-- Agregar Medicina -->
	<div id="AgregarMedicina" class="modal hide fade modalPequena" role="dialog" aria-labelledby="AgregarMedicina" aria-hidden="true">
		
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h3 id="modalHead">Agregar</h3>
		</div>
		<div class="modal-body" style="overflow-y:visible;" >
			<form>
				<fieldset>
					<label id="txtMedicina_label" style="margin-top:10px;">Medicina<small>(M&aacute;x. 50)</small></label>
					<input id="txtMedicina" style="width:95%;" type="text" />
				</fieldset>
			</form>
		</div>
		<div class="modal-footer">
			<button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
			<button id="guardarMedicinaE" onClick="manto.insertarMedicina()" class="btn btn-primary">Agregar</button>
		</div>

	</div>



	<!-- Scripts -->

	

	<script>
		$(document).ready(function(){
			cargarTabla();

			$('#lnkGuardar').click(function(){ manto.guardar(); });
			$('#lnkCancelar').attr('href','consultas.php');
			$('#lnkLimpiar').click(function(){ document.getElementById('frmConsulta').reset(); });

			$('#btnAgregarMedicina').click(function(){
				manto.agregarMedicina();
			});

			
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
				escapeMarkup: function(m) { return m; }
			});
			$("#idCita").change(function(){
				var idCita = $(this).val();
				if(idCita!="-") manto.precargarDatos(idCita);
			});

			<?php if($ed){ ?>
			$("#idCita").select2("val",<?php echo ""; ?>);
			
			<?php } ?>

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

			precargarDatos:function(id){
				$.ajax({
					url:'stores/agenda.php', data:{ action:'rt_cita', id:id }, 
					dataType:'json', type:'POST',
					complete:function(datos){
						var T = jQuery.parseJSON(datos.responseText);
						$("#lblDoctor").html(T.nomEm);
						$("#lblPaciente").html(T.nomPa);
						$("#lblFecha").html(T.fecha);
						$("#lblHora").html(T.hora);
						$("#descripcion").val(T.com);
					}
				})
			},

			agregarMedicina:function(){ 
				$("#txtMedicina").val("");
				$('#AgregarMedicina').modal('show'); 
			},

			nMed:0,
			insertarMedicina:function(){
				var _t = this;
				var content = "<b class='itemMedicina' id='item_"+_t.nMed+"'>"+$("#txtMedicina").val()+"</b>"+
							"<a id='btni_"+_t.nMed+"' href='javascript:void(0);' onClick='manto.borrarMedicina("+_t.nMed+")' style='margin-right:10px;'><i class='icon icon-remove'></i></a> ";
				var cM = $("#contentMedicinas");
				cM.html(cM.html()+content);
				_t.nMed++;
				$('#AgregarMedicina').modal('hide');
			},

			borrarMedicina:function(i){
				$("#item_"+i).remove();
				$("#btni_"+i).remove();
			},

			obtenerMedicinas:function(){
				var value="";
				$(".itemMedicina").each(function(index){
					value += (value!=""?"####--####":"")+$(this).html();
				});
				return value;
			},

			guardar:function(){
				if(!validarForm()){ return; }
				manto.toggle(false);
				
				var idCita = $('#idCita').val();
				var descripcion = $('#descripcion').val();
				var diagnostico = $('#diagnostico').val();
				var detalle = $('#detalle_receta').val();
				var medicinas = $('#detalle_receta').val();
				
				var datos = {action:'sv_consulta',idc:idCita,descripcion:descripcion,diagnostico:diagnostico,detalle:detalle,medicinas:medicinas,id:''};

				$.ajax({
					url:'stores/consultas.php',
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

