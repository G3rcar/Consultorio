<?php
include("sesion.php");
//- Incluimos la clase de conexion e instanciamos del objeto principal
include_once("libs/php/class.connection.php");

$botones_menu["limpio"]=true;
$botones_configuracion["cargos"]=true;


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


	<h3>Cat&aacute;logos: cargos</h3>

	<div class="container-fluid">
		<div class="row-fluid">
			
			<!-- Columna fluida con peso 3/12 -->
			<div class="span3">
				<?php include('res/partes/herramientas.configuracion.php'); ?>
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
		var preloadedEmpleados = [];

		$(document).ready(function(){
			cargarTabla();

			$('#lnkAgregar').click(function(){ manto.agregar(); });
			$('#lnkBorrar').click(function(){ manto.borrar(); });
			$('#guardarCargo').click(function(){ manto.guardar(); });
			//cargarLista();

		});

		function cargarLista(){
			$.ajax("stores/cargos.php", {
				data:'action=ls_cargo', dataType:'json', type:'POST'
			}).success(function(data) { preloadedEmpleados = data.results; console.log(preloadedEmpleados); });
		}

		function validarForm(){
			var errores=0;
			var iv1 = $('#idEmpleado').val();
			var iv2 = $('#nombreCargo').val();
			if(iv1==''){ $('#s2id_idEmpleado').addClass('error_requerido_sel2'); errores++; }
			if(iv2==''){ $('#nombreCargo').addClass('error_requerido'); errores++; }
			if(errores>0){
				humane.log('Complete los campos requeridos');
				return false;
			}else{
				return true;
			}
		}

		function cargarTabla(){
			$.ajax({
				url:'stores/cargos.php',
				data:'action=gd_cargo', dataType:'json', type:'POST',
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
				$('#modalHead').html("Agregar Cargo");
				this.id = '';
				$('#nombreCargo').removeClass('error_requerido');
				$('#nombreCargo').val('');
				$('#esDoctor').removeAttr('checked');

				$('#AgregarCargo').modal('show');
				
			},
			editar:function(id){
				this.estado = 'editar';
				$('#modalHead').html("Editar Cargo");
				this.id = id;
				$.ajax({
					url:'stores/cargos.php',
					data:'action=rt_cargo&id='+id, dataType:'json', type:'POST',
					complete:function(datos){
						var T = jQuery.parseJSON(datos.responseText);
						
						$('#nombreCargo_label').removeClass('error_requerido');
						$('#nombreCargo').val(T.nombre);
						if(T.esDoctor){
							$('#esDoctor').attr('checked','checked');
						}
						
						$('#AgregarCargo').modal('show');
					}
				});

			},
			borrar:function(id){
				var tipo = (id)?'uno':'varios';
				var seleccion = gridCheck.getSelectionJSON('gridCargos');
				if(tipo=='varios' && seleccion==false){
					humane.log('No ha seleccionado ning&uacute;n registro');
					return;
				}

				var ids = (tipo=='uno')?id:seleccion;
				var action = (tipo=='uno')?'br_cargo':'br_varioscargo' ;
				
				bootbox.confirm("&iquest;Esta seguro de eliminar los registros?", function(confirm) {
					if(confirm){
						$.ajax({
							url:'stores/cargos.php',
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
				var nombre = $('#nombreCargo').val();
				var esDoctor = $('#esDoctor').is(':checked');
				
				if(this.estado=='agregar'){ this.id=''; }
				var datos = 'action=sv_cargo&nombre='+nombre+'&esDoctor='+esDoctor+'&id='+this.id;

				$.ajax({
					url:'stores/cargos.php',
					data:datos, dataType:'json', type:'POST',
					complete:function(datos){
						var T = jQuery.parseJSON(datos.responseText);

						humane.log(T.msg);
						if(T.success=="true"){
							$('#AgregarCargo').modal('hide');
							manto.toggle(true);
							cargarTabla();
						}
						manto.toggle(true);
					}
				});
			},

			toggle:function(v){
				if(v){ $('#guardarCargo').removeClass('disabled').html('Guardar'); }
				else{ $('#guardarCargo').addClass('disabled').html('Guardando...'); }
			}
		}


	</script>


	<!-- Modales -->

	<!-- Agregar -->
	<div id="AgregarCargo" class="modal hide fade modalPequena" tabindex="-1" role="dialog" aria-labelledby="AgregarCargo" aria-hidden="true">
		
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h3 id="modalHead">Cargo</h3>
		</div>
		<div class="modal-body">
			<form>
				<fieldset>
					<label id="nombreCargo_label" class="requerido">Nombre</label>
					<input id="nombreCargo" type="text" min-length="2" class="input-block-level" placeholder="Escribir..." >
					<label class="checkbox">
						<input type="checkbox" id="esDoctor"> Mostrar en listados de doctores
					</label>
				</fieldset>
			</form>
		</div>
		<div class="modal-footer">
			<button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
			<button id="guardarCargo" class="btn btn-primary">Guardar</button>
		</div>

	</div>


<?php include('res/partes/pie.pagina.php'); ?>