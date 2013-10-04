<?php
//- Iniciamos la sesion
if(!isset($_SESSION)){ session_start(); }

//- Incluimos la clase de conexion e instanciamos del objeto principal
include_once("../libs/php/class.connection.php");
$conexion = new Conexion();

//- Si la variable de usuario no viene se detenemos la ejecucion
if(!isset($_POST["user"])){ exit(); }

//- Obtenemos las variables y las decodificamos de utf8, a la 
//- vez que limpiamos de caracteres raros para evitar inyecciones SQL 
$user = $conexion->escape(utf8_decode($_POST["user"]));
$pass = $conexion->escape(utf8_decode($_POST["pass"]));

//- Inicializamos el array que usaremos para responder
$success=array();

//- Escribimos la consulta para buscar al usuario
$selUser = "SELECT count(id) AS 'total' FROM usuario WHERE cuenta='{$user}'";
//- Ejecutamos la consulta y asignamos a la variable $res el resultado del select
$res = $conexion->execSelect($selUser);
//- Parseamos el resultado y lo convertimos en un array asociativo
$iUsers = $conexion->fetchArray($res["result"]);

//- Si el usuario no se encuentra detenemos, la ejecucion
if($iUsers["total"]!="1"){ 
	$success = array("success"=>"true","t"=>"false","msg"=>"El usuario  es incorrecta");
	echo json_encode($success); exit(); 
}

//- Repetimos el proceso anterior pero con el usuario y password a la vez
$selPass = "SELECT count(id) AS 'total',id FROM usuario WHERE cuenta='{$user}' AND contrasena='{$pass}' ";
$res = $conexion->execSelect($selPass);
$iUserP = $conexion->fetchArray($res["result"]);

//- Si el usuario y el password no se encuentran, detenemos la ejecucion
if($iUserP["total"]!="1"){ 
	$success = array("success"=>"true","t"=>"false","msg"=>"El usuario o la contrase&ntilde;a es incorrecta");
	echo json_encode($success); exit(); 
}


//- Si llego hasta aqui es porque se encontro el usuario, 
//- por lo tanto se asignan las variables a la sesion
$_SESSION["iduser"] = $iUserP["id"];
$_SESSION["user"] = $user;
$_SESSION["password"] = $pass;

$success = array("success"=>"true","t"=>"true","msg"=>"Correcto");
echo json_encode($success); exit(); 


?>