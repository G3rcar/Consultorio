<?php
include("sesion.back.php");


//- Incluimos la clase de conexion e instanciamos del objeto principal
include_once("../libs/php/class.connection.php");
include_once("../libs/php/class.objetos.base.php");
$conexion = new Conexion();


//- Si la variable action no viene se detenemos la ejecucion
if(!isset($_POST["action"])){ exit(); }

$accion = $_POST["action"];

switch ($accion) {
	case 'ls_pacientes':
		$query = "";
		if(isset($_POST["q"]) && $_POST["q"]!=""){
			$q = $conexion->escape($_POST["q"]);
			$query = " WHERE CONCAT(nombres,' ',apellidos) LIKE '%{$q}%' ";
		}
		$selPacientes = "SELECT id,CONCAT(nombres,' ',apellidos) AS 'nombre' FROM paciente {$query} ORDER BY nombres,apellidos";
		$res = $conexion->execSelect($selPacientes);
		
		$registros=array();
		if($res["num"]>0){
			$i=0;
			while($iPaci = $conexion->fetchArray($res["result"])){
				$registros[]=array("id"=>$iPaci["id"],"text"=>utf8_encode($iPaci["nombre"]));
			}
		}

		$results = array("results"=>$registros,"more"=>false);
		echo json_encode($results);
		
	break;


}


?>