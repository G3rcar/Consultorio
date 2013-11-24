<?php
include("sesion.php");
//- Incluimos la clase de conexion e instanciamos del objeto principal
include_once("libs/php/class.connection.php");

$botones_menu["limpio"]=true;
$botones_herramientas["sucursales"]=true;


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


	<h3>Cat&aacute;logos: sucursales</h3>

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

			$('#lnkAgregar').attr('href','sucursales.form.php');
			//$('#lnkAgregar').click(function(){ manto.agregar(); });
			$('#lnkBorrar').click(function(){ manto.borrar(); });
			$('#guardarSuc').click(function(){ manto.guardar(); });
			
		});

		function validarForm(){
			var errores = 0;
			var v1 = $('#nombreSuc').val();
			if(v1==''){ $('#nombreSuc').addClass('error_requerido'); errores++; }
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
				data:'action=gd_sucursal', dataType:'json', type:'POST',
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
	<div id="AgregarSuc" class="modal hide fade modalPequena" tabindex="-1" role="dialog" aria-labelledby="AgregarSuc" aria-hidden="true">
		
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h3 id="modalHead">Agregar sucursal</h3>
		</div>
		<div class="modal-body">
			<form>
				<fieldset>
					<label id="nombreSuc_label" class="requerido">Nombre</label>
					<input id="nombreSuc" type="text" min-length="2" class="input-block-level" placeholder="Escribir..." >
					<label id="condominioDir_label">Condominio</label>
					<input id="condominioDir" type="text" min-length="2" class="input-block-level" placeholder="Escribir..." >
					<label id="condominio2Dir_label" >Condominio 2</label>
					<input id="condominio2Dir" type="text" min-length="2" class="input-block-level" placeholder="Escribir..." >
					<label id="calleDir_label" class="requerido">Calle</label>
					<input id="calleDir" type="text" min-length="2" class="input-block-level" placeholder="Escribir..." >
					<label id="complementocalleDir_label" >Complemento Calle</label>
					<input id="complementocalleDir" type="text" min-length="2" class="input-block-level" placeholder="Escribir..." >
					<label id="casaDir_label" class="requerido">Casa</label>
					<input id="casaDir" type="text" min-length="2" class="input-block-level" placeholder="Escribir..." >
					<label id="coloniaDir_label" >Colonia</label>
					<input id="coloniaDir" type="text" min-length="2" class="input-block-level" placeholder="Escribir..." >
					<label id="distritoDir_label">Distrito</label>
					<input id="distritoDir" type="text" min-length="2" class="input-block-level" placeholder="Escribir..." >
					<label id="referenciaDir_label">Referencia</label>
					<input id="referenciaDir" type="text" min-length="2" class="input-block-level" placeholder="Escribir..." >
					
					
				</fieldset>
			</form>
		</div>
		<div class="modal-footer">
			<button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
			<button id="guardarSuc" class="btn btn-primary">Guardar</button>
		</div>

	</div>



<?php include('res/partes/pie.pagina.php'); ?>

