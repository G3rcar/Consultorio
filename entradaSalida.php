<?php
include("sesion.php");
//- Incluimos la clase de conexion e instanciamos del objeto principal
include_once("libs/php/class.connection.php");

$botones_menu["reportes"]=true;
$botones_herramientas["entradaSalida"]=true;


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


	<h3>Reporte: Entrada y Salidas</h3>

	<div class="container-fluid">
		<div class="row-fluid">
			
			<!-- Columna fluida con peso 3/12 -->
			<div class="span3">
				<?php include('res/partes/herramientas.reporte.php'); ?>
			</div>
			<!-- /Columna fluida con peso 3/12 -->

			<div id="buscador" class="span9">
				<input type="text" id="desde" placeholder="Desde (dd-mm-aaaa)"> - <input type="text" id="hasta" placeholder="hasta (dd-mm-aaaa)"> <button class="btn" id="search">Consultar</button>
			</div>
			<!-- Columna fluida con peso 9/12 -->
			<div id="contenedorTabla" class="span9">
				<!-- Aqui se cargaran los datos del catalogo -->
			</div>
			<!-- /Columna fluida con peso 9/12 -->
			

		</div>
	</div>

	<!-- Scripts -->

	<script>
		var preloadedPaises = [];

		$(document).ready(function(){
			cargarTabla();			
		});

		function cargarTabla(){
			$.ajax({
				url:'reportes/entradaSalida.php',
				data:'action=rep_es', dataType:'json', type:'POST',
				complete:function(datos){
					$("#contenedorTabla").html(datos.responseText);
				}
			});
		};


		function cargarTablaSearch(desde,hasta){
			$.ajax({
				url:'reportes/entradaSalida.php',
				data:'action=rep_sea&desde='+desde+"&hasta="+hasta, dataType:'json', type:'POST',
				complete:function(datos){
					$("#contenedorTabla").html(datos.responseText);
				}
			});

		};



		$('#search').click(function(){
			var desde = $('#desde').val();
			var hasta = $('#hasta').val();

			if (desde != '' || hasta != '') {
				cargarTablaSearch(desde,hasta);				
			}

		});



	</script>




<?php include('res/partes/pie.pagina.php'); ?>

<style type="text/css">
	#buscador button { margin-bottom: 12px;	}
</style>