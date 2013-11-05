<?php

if(!isset($_SESSION)){ session_start(); }
if($_SESSION["iduser"]==""){ exit(); }

include_once('../libs/php/constantes.php');
include_once('../libs/php/class.objetos.base.php'); 
$data = new Configuracion();
$conf = $data->obtenerConfiguracion();

?>