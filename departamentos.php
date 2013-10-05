<?php
include("sesion.php");
//- Incluimos la clase de conexion e instanciamos del objeto principal
include_once("libs/php/class.connection.php");

$botones_menu["limpio"]=true;
$botones_herramientas["departamentos"]=true;


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
<!-- /Estilo extra -->

<!-- Scripts extra -->
<script type="text/javascript" src="libs/js/custom/objetos-comunes.js"></script>

<!-- /Scripts extra -->


	<h3>Cat&aacute;logos: departamentos</h3>

	<div class="container-fluid">
		<div class="row-fluid">
			
			<!-- Columna fluida con peso 3/12 -->
			<div class="span3">
				<?php include('res/partes/herramientas.catalogos.php'); ?>
			</div>
			<!-- /Columna fluida con peso 3/12 -->


			<!-- Columna fluida con peso 9/12 -->

			<div id="contenedorTabla" class="span9">
				
			</div>
			<!-- /Columna fluida con peso 9/12 -->
			

		</div>
	</div>

	<!-- Scripts -->

	<script>
		$(document).ready(function(){
			cargarTabla();

			$('#lnkAgregar').click(function(){ manto.agregar(); });
			$('#lnkBorrar').click(function(){ manto.borrar(); });
			$('#guardarDepto').click(function(){ manto.guardar(); });
			
		});

		function validarForm(){
			var errores = 0;
			var v1 = $('#nombreDepto').val();
			if(v1==''){ $('#nombreDepto').addClass('error_requerido'); errores++; }
			if(errores>0){
				humane.log('Complete los campos requeridos');
				return false;
			}else{
				return true;
			}
		}

		function cargarTabla(){
			$.ajax({
				url:'stores/departamentos.php',
				data:'action=gd_depto', dataType:'json', type:'POST',
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
				$('#nombreDepto_label').removeClass('error_requerido');
				$('#nombreDepto').val('');
				$('#AgregarDepto').modal('show');


			},
			editar:function(id){
				this.estado = 'editar';
				this.id = id;
				$.ajax({
					url:'stores/departamentos.php',
					data:'action=rt_depto&id='+id, dataType:'json', type:'POST',
					complete:function(datos){
						var T = jQuery.parseJSON(datos.responseText);
						
						$('#nombreDepto').removeClass('error_requerido');
						$('#nombreDepto').val(T.nombre);
						$('#AgregarDepto').modal('show');
					}
				});

			},
			borrar:function(id){
				var tipo = (id)?'uno':'varios';
				var seleccion = gridCheck.getSelectionJSON('gridDeptos');
				if(tipo=='varios' && seleccion==false){
					humane.log('No ha seleccionado ning&uacute;n registro');
					return;
				}

				var ids = (tipo=='uno')?id:seleccion;
				var action = (tipo=='uno')?'br_depto':'br_variosdepto' ;
				
				bootbox.confirm("¿Esta seguro de eliminar los registros?", function(confirm) {
					if(confirm){
						$.ajax({
							url:'stores/departamentos.php',
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
				var nombre = $('#nombreDepto').val();
				
				if(this.estado=='agregar'){ this.id=''; }
				var datos = 'action=sv_depto&nombre='+nombre+'&id='+this.id;

				$.ajax({
					url:'stores/departamentos.php',
					data:datos, dataType:'json', type:'POST',
					complete:function(datos){
						var T = jQuery.parseJSON(datos.responseText);

						humane.log(T.msg);
						if(T.success=="true"){
							$('#AgregarDepto').modal('hide');
							manto.toggle(true);
							cargarTabla();
						}
						manto.toggle(true);
					}
				});
			},

			toggle:function(v){
				if(v){ $('#guardarDepto').removeClass('disabled').html('Guardar'); }
				else{ $('#guardarDepto').addClass('disabled').html('Guardando...'); }
			}
		}


	</script>


	<!-- Modales -->

	<!-- Agregar -->
	<div id="AgregarDepto" class="modal hide fade modalPequena" tabindex="-1" role="dialog" aria-labelledby="AgregarDepto" aria-hidden="true">
		
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 id="modalHead">Departamento</h3>
		</div>
		<div class="modal-body">
			<form>
				<fieldset>
					<label id="nombreDepto_label" class="requerido">Nombre</label>
					<input id="nombreDepto" type="text" min-length="2" class="input-block-level" placeholder="Escribir..." >
				</fieldset>
			</form>
		</div>
		<div class="modal-footer">
			<button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
			<button id="guardarDepto" class="btn btn-primary">Guardar</button>
		</div>

	</div>



<?php include('res/partes/pie.pagina.php'); ?>

