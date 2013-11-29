<?php
include("sesion.php");
//- Incluimos la clase de conexion e instanciamos del objeto principal
include_once("libs/php/class.connection.php");

$botones_menu["consultas"]=true;


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
.bootbox-input{
	width: 95%;
}

</style>
<link href="res/css/select2/select2.css" rel="stylesheet"/>
<!-- /Estilo extra -->

<!-- Scripts extra -->
<script type="text/javascript" src="libs/js/select2/select2.js"></script>
<script type="text/javascript" src="libs/js/select2/select2_locale_es.js"></script>
<script type="text/javascript" src="libs/js/custom/objetos-comunes.js"></script>

<!-- /Scripts extra -->


	<h3>Consultas</h3>

	<div class="container-fluid">
		<div class="row-fluid">
			
			<!-- Columna fluida con peso 3/12 -->
			<div class="span3">
				<div class="well sidebar-nav">
					<img id="progressBar_main" src="res/img/loading.gif" class="loading_indicator_mannto" />
					<ul class="nav nav-list">
						<li class="nav-header">Opciones</li>
						<li><a id="lnkAgregar" href="consultas.form.php"><i class="icon-plus"></i> Agregar</a></li>
						<li><a id="lnkBorrar" href="#"><i class="icon-remove"></i> Borrar</a></li>
						
						<li class="nav-header">Herramientas</li>
						<li><a id="lnkFiltrar" href="#"><i class="icon-filter"></i> Filtrar</a></li>
						<!--<li><a id="lnkReceta" href="#"><i class="icon-list-alt"></i> Mostrar Receta</a></li>-->
						<li><a href="agenda.php"><i class="icon-calendar"></i> Agenda</a></li>
						<li><a href="pacientes.php"><i class="icon-user"></i> Pacientes</a></li>
					</ul>
				</div>
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
			$('#lnkFiltrar').click(function(){ manto.filtrar(); });
			$('#lnkReceta').click(function(){ manto.verReceta(); });
			cargarLista();

		});

		function cargarLista(){
			$.ajax("stores/municipios.php", {
				data:'action=ls_depto', dataType:'json', type:'POST'
			}).success(function(data) { preloadedDeptos = data.results; console.log(preloadedDeptos); });
		}

		function validarForm(){
			var errores=0;
			limpiarValidacion(false);

			var iv1 = $('#idPais').val();
			var iv2 = $('#idDepto').val();
			var iv3 = $('#nombreMuni').val();
			
			if(iv1==''){ $('#s2id_idPais').addClass('error_requerido_sel2'); errores++; }
			if(iv2==''){ $('#s2id_idDepto').addClass('error_requerido_sel2'); errores++; }
			if(iv3==''){ $('#nombreMuni').addClass('error_requerido'); errores++; }
			if(iv3.length>45){ $('#nombreMuni').addClass('error_requerido').attr('title','No debe sobrepasar los 45 caracteres'); errores++; }
			if(errores>0){
				humane.log('Complete los campos requeridos');
				return false;
			}else{
				return true;
			}
		}
		function limpiarValidacion(conTexto){
			$('#s2id_idPais').removeClass('error_requerido_sel2');
			$('#s2id_idDepto').removeClass('error_requerido_sel2');
			$('#nombreMuni').removeClass('error_requerido');
			if(conTexto){
				$('#idPais').val('');
				$('#idDepto').val('');
				$('#nombreMuni').val('');
			}
			manto.toggle(true);
		}

		function cargarTabla(s){
			var str = (typeof(s)!="undefined")?s:"";
			$.ajax({
				url:'stores/consultas.php',
				data:'action=gd_consultas&query='+str, dataType:'json', type:'POST',
				complete:function(datos){
					$("#contenedorTabla").html(datos.responseText);
				}
			});
		}



		var manto = {
			estado: 'agregar',
			id:'',

			editar:function(id){
				document.location.href="consultas.form.php?i="+id;
			},

			filtrar:function(){
				bootbox.prompt("Escriba una palabra para buscar", function(result) {
                    cargarTabla(result);
                });
			},
			
			verReceta:function(id){
				$.ajax({
					url:'stores/consultas.php', type:'POST',
					data:{action:'rt_receta',id:id},
					complete:function(datos){
						$("#body_receta").html(datos.responseText);
						$("#VerReceta").modal('show');
					}
				});

			},

			borrar:function(id){
				event.preventDefault();

				var tipo = (id)?'uno':'varios';
				var seleccion = gridCheck.getSelectionJSON('gridConsulta');
				if(tipo=='varios' && seleccion==false){
					humane.log('No ha seleccionado ning&uacute;n registro');
					return;
				}

				var ids = (tipo=='uno')?id:seleccion;
				var action = (tipo=='uno')?'br_consulta':'br_variasconsulta' ;
				
				bootbox.confirm("&iquest;Esta seguro de eliminar los registros?", function(confirm) {
					if(confirm){
						$.ajax({
							url:'stores/consultas.php',
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

		}


	</script>


	<!-- Modales -->

	<!-- Agregar -->
	<div id="VerReceta" class="modal hide fade modalPequena" role="dialog" aria-labelledby="VerReceta" aria-hidden="true">
		
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h3 id="modalHead">Receta</h3>
		</div>
		<div class="modal-body" id="body_receta">
			<label>Detalle</label>
			<div class="well">Dsadsdasd</div>
			<label>Medicinas</label>
			<div class="well">Uno, Dos, Tres</div>

		</div>
		<div class="modal-footer">
			<button class="btn" data-dismiss="modal" aria-hidden="true">Cerrar</button>
		</div>

	</div>



<?php include('res/partes/pie.pagina.php'); ?>

