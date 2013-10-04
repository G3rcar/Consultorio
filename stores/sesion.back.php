<?php

if(!isset($_SESSION)){ session_start(); }
if($_SESSION["iduser"]==""){ exit(); }

include('../libs/php/constantes.php');

?>