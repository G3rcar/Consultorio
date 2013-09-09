<?
include("sesion.php");
//- Incluimos la clase de conexion e instanciamos del objeto principal
include_once("libs/php/class.connection.php");

$botones_menu["limpio"]=true;


//- Hacerlo hasta el final de cada codigo embebido; incluye el head, css y el menu
include("res/partes/encabezado.php");

?>
<!-- Estilo extra -->
<style>
.sidebar-nav { padding: 9px 0; }
.error_requerido { color:#F00000; }
.requerido::after {
	content: "*";
	color: #C00;
	font-size: 16px;
}
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
				<div class="well sidebar-nav">
					<ul class="nav nav-list">
						<li class="nav-header">Opciones</li>
						<li><a id="lnkAgregar" href="#"><i class="icon-plus"></i> Agregar</a></li>
						<li><a href="#"><i class="icon-pencil"></i> Modificar</a></li>
						<li><a href="#"><i class="icon-trash"></i> Borrar</a></li>
						
						<li class="nav-header">Otros</li>
						<li class="active"><a href="#">Departamentos</a></li>
						<li><a href="#">Municipios</a></li>
						<li><a href="#">Productos</a></li>
						<li><a href="#">Proveedores</a></li>
					</ul>
				</div>
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

			$('#AgregarDepto').on('show',function(){
				$('#nombreDepto_label').removeClass('error_requerido');
				$('#nombreDepto').val('');
			});
			$('#lnkAgregar').click(function(){
				$('#AgregarDepto').modal('show');
			});

			$('#guardarDepto').click(function(){
				if(!validarAgregar()){ return; }
				toggle(false);

				var nombre = $('#nombreDepto').val();
				$.ajax({
					url:'stores/departamentos.php',
					data:'action=nv_depto&nombre='+nombre, dataType:'json', type:'POST',
					complete:function(datos){
						var T = jQuery.parseJSON(datos.responseText);

						humane.log(T.msg);
						if(T.success=="true"){
							$('#AgregarDepto').modal('hide');
							toggle(true);
							cargarTabla();
						}
						toggle(true);
					}
				});

				function toggle(v){
					if(v){ $('#guardarDepto').removeClass('disabled').html('Guardar'); }
					else{ $('#guardarDepto').addClass('disabled').html('Guardando...'); }
				}
			});
		});

		function validarAgregar(){
			var v = $('#nombreDepto').val();
			if(v==''){
				humane.log('Complete los campos requeridos');
				$('#nombreDepto_label').addClass('error_requerido');
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


	</script>


	<!-- Modales -->

	<!-- Agregar -->
	<div id="AgregarDepto" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="AgregarDepto" aria-hidden="true" style="width:350px;margin-left:-175px;">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 id="modalHead">Agregar departamento</h3>
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



<? include('res/partes/pie.pagina.php'); ?>

