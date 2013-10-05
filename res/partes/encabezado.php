<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<title><?php echo TITULO_SISTEMA; ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="Proyecto ASI 2">
	<meta name="author" content="@G3rcar">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta charset="utf-8">

	<link href="res/css/bootstrap/css/bootstrap.css" rel="stylesheet">
	<link href="res/css/bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
	<link href="res/css/humane.css" rel="stylesheet">
	<link href="res/css/default.css" rel="stylesheet">



	<!-- javascript ================================================== -->
	<script type="text/javascript" src="libs/js/jquery-1.10.2.min.js"></script>
	<script type="text/javascript" src="libs/js/humane.min.js"></script>
	<script type="text/javascript" src="libs/js/bootstrap/bootstrap.js"></script>
	<script type="text/javascript" src="libs/js/bootbox.min.js"></script>
	<script type="text/javascript" src="libs/js/custom/objetos-comunes.js"></script>

	<script type="text/javascript">
		$(document).ready(function(){
			bootbox.setDefaults({ className:'modalPequena', locale:'es' });

			$(document).bind("ajaxSend", function(){
				console.log('cargando');
				$("#progressBar_main").show();
			}).bind("ajaxComplete", function(){
				console.log('terminando de cargar');
				$("#progressBar_main").hide();
		 	});

		})
	</script>

	<!-- Favicon -->
	<link rel="shortcut icon" href="res/img/favicon.png">
</head>

<body>
	<div id="wrap">
    
    	<?php include('pestanas.php'); ?>

		<div class="container cm-main-containter">


<?php

/*
*	Se incluyen todos los CSS necesarios y las pestañas
*/

?>