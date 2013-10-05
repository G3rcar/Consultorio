<?php
include("sesion.php");
//- Incluimos la clase de conexion e instanciamos del objeto principal
include_once("libs/php/class.connection.php");

$botones_menu["limpio"]=true;
$botones_herramientas["municipios"]=true;


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
<!-- /Estilo extra -->

<!-- Scripts extra -->
<script type="text/javascript" src="libs/js/select2/select2.js"></script>
<script type="text/javascript" src="libs/js/select2/select2_locale_es.js"></script>
<script type="text/javascript" src="libs/js/custom/objetos-comunes.js"></script>

<!-- /Scripts extra -->


	<h3>Cat&aacute;logos: municipios</h3>

	<div class="container-fluid">
		<div class="row-fluid">
			
			<!-- Columna fluida con peso 3/12 -->
			<div class="span3">
				<?php include('res/partes/herramientas.catalogos.php'); ?>
			</div>
			<!-- /Columna fluida con peso 3/12 -->


			<!-- Columna fluida con peso 9/12 -->
			<div id="contenedorTabla" class="span9">
				<!-- Aqui se cargaran los datos del catalogo -->
			</div>
			<!-- /Columna fluida con peso 9/12 -->
			

		</div>
	</div>

	<!-- Scripts -->

	<script>
		var preloadedDeptos = [];

		$(document).ready(function(){
			cargarTabla();

			$('#lnkAgregar').click(function(){ manto.agregar(); });
			$('#lnkBorrar').click(function(){ manto.borrar(); });
			$('#guardarMuni').click(function(){ manto.guardar(); });
			cargarLista();

		});

		function cargarLista(){
			$.ajax("stores/municipios.php", {
				data:'action=ls_depto', dataType:'json', type:'POST'
			}).success(function(data) { preloadedDeptos = data.results; console.log(preloadedDeptos); });
		}

		function validarForm(){
			var errores=0;
			var iv1 = $('#idDepto').val();
			var iv2 = $('#nombreMuni').val();
			if(iv1==''){ $('#s2id_idDepto').addClass('error_requerido_sel2'); errores++; }
			if(iv2==''){ $('#nombreMuni').addClass('error_requerido'); errores++; }
			if(errores>0){
				humane.log('Complete los campos requeridos');
				return false;
			}else{
				return true;
			}
		}

		function cargarTabla(){
			$.ajax({
				url:'stores/municipios.php',
				data:'action=gd_muni', dataType:'json', type:'POST',
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
				$('#s2id_idDepto').removeClass('error_requerido_sel2');
				$('#nombreMuni').removeClass('error_requerido');
				$('#idDepto').val('');
				$('#nombreMuni').val('');
				$('#AgregarMuni').modal('show');
				$("#idDepto").select2({
					placeholder: "Seleccionar",
					ajax: {
						url: "stores/municipios.php", dataType: 'json', type:'POST',
						data: function (term, page) {
							return { q: term, action:'ls_depto' };
						},
						results: function (data, page) {
							return {results: data.results};
						}
					}
				});


			},
			editar:function(id){
				this.estado = 'editar';
				this.id = id;
				$.ajax({
					url:'stores/municipios.php',
					data:'action=rt_muni&id='+id, dataType:'json', type:'POST',
					complete:function(datos){
						var T = jQuery.parseJSON(datos.responseText);
						
						$('#s2id_idDepto').removeClass('error_requerido_sel2');
						$('#nombreMuni_label').removeClass('error_requerido');
						$('#nombreMuni').val(T.nombre);
						$('#AgregarMuni').modal('show');
						$("#idDepto").select2({
							placeholder: "Seleccionar",
							ajax: {
								url: "stores/municipios.php", dataType: 'json', type:'POST',
								data: function (term, page) {
									return { q: term, action:'ls_depto' };
								},
								results: function (data, page) {
									return {results: data.results};
								}
							}
						});
						$("#idDepto").select2("data",{id:T.idDepto,text:T.depto});
					}
				});

			},
			borrar:function(id){
				var tipo = (id)?'uno':'varios';
				var seleccion = gridCheck.getSelectionJSON('gridMuni');
				if(tipo=='varios' && seleccion==false){
					humane.log('No ha seleccionado ning&uacute;n registro');
					return;
				}

				var ids = (tipo=='uno')?id:seleccion;
				var action = (tipo=='uno')?'br_muni':'br_variosmuni' ;
				
				bootbox.confirm("¿Esta seguro de eliminar los registros?", function(confirm) {
					if(confirm){
						$.ajax({
							url:'stores/municipios.php',
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
				var nombre = $('#nombreMuni').val();
				var idDepto = $('#idDepto').val();
				
				if(this.estado=='agregar'){ this.id=''; }
				var datos = 'action=sv_muni&nombre='+nombre+'&idDepto='+idDepto+'&id='+this.id;

				$.ajax({
					url:'stores/municipios.php',
					data:datos, dataType:'json', type:'POST',
					complete:function(datos){
						var T = jQuery.parseJSON(datos.responseText);

						humane.log(T.msg);
						if(T.success=="true"){
							$('#AgregarMuni').modal('hide');
							manto.toggle(true);
							cargarTabla();
						}
						manto.toggle(true);
					}
				});
			},

			toggle:function(v){
				if(v){ $('#guardarMuni').removeClass('disabled').html('Guardar'); }
				else{ $('#guardarMuni').addClass('disabled').html('Guardando...'); }
			}
		}


	</script>


	<!-- Modales -->

	<!-- Agregar -->
	<div id="AgregarMuni" class="modal hide fade modalPequena" role="dialog" aria-labelledby="AgregarMuni" aria-hidden="true">
		
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 id="modalHead">Municipio</h3>
		</div>
		<div class="modal-body">
			<form>
				<fieldset>
					<label id="idDepto_label" class="requerido">Departamento</label>
					<input id="idDepto" type="hidden" style="width:100%" >
					<label id="nombreMuni_label" class="requerido" style="margin-top:5px;">Nombre</label>
					<input id="nombreMuni" type="text" min-length="2" class="input-block-level" placeholder="Escribir..." >
				</fieldset>
			</form>
		</div>
		<div class="modal-footer">
			<button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
			<button id="guardarMuni" class="btn btn-primary">Guardar</button>
		</div>

	</div>



<?php include('res/partes/pie.pagina.php'); ?>

