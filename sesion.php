<?php

if(!isset($_SESSION)){ session_start(); }
if($_SESSION["iduser"]==""){ header("Location: login.php"); exit(); }

$botones_menu = array("citas"=>false,"consultas"=>false,"pacientes"=>false,"facturas"=>false,"reportes"=>false,"limpio"=>false);
$botones_herramientas = array("paises"=>false,"departamentos"=>false,"municipios"=>false,"sucursales"=>false,"documentos"=>false,
								"movimientos"=>false,"tiposangre"=>false,"cargos"=>false,"roles"=>false,"configuraciones"=>false);

include('libs/php/constantes.php');

?>