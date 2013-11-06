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
	case 'gd_cargo':

		$selRes = "SELECT car_id,car_nom,car_es_doctor FROM cargo";
		$res = $conexion->execSelect($selRes);
		$headers = array( 
			"Nombre", 
			array("width"=>"250","text"=>"&nbsp;"),
			array("width"=>"15","text"=>"&nbsp;"),
			array("width"=>"15","text"=>"&nbsp;")
		);

		$tabla = new GridCheck($headers,"gridCargos");
		if($res["num"]> 0){
			$i=0;
			while($iCargo = $conexion->fetchArray($res["result"])){
				//Iconos
				$editar = "<a href='#' onClick='manto.editar({$iCargo["car_id"]});' title='Editar' ><i class='icon-edit'></i></a>";
				$borrar = "<a href='#' onClick='manto.borrar({$iCargo["car_id"]});' title='Borrar' ><i class='icon-remove'></i></a>";
				$visibilidad = ($iCargo["car_es_doctor"]=="true")?"<i class='icon-ok-circle'></i> &nbsp;Aparece en listado de doctores":"-";

				$valoresFila = array(utf8_encode($iCargo["car_nom"]),$visibilidad,$editar,$borrar);
				$fila = array("id"=>$iCargo["car_id"],"valores"=>$valoresFila);
				$tabla->nuevaFila($fila);
			}	
		}

		$html = $tabla->obtenerCodigo();
		echo $html;
		
	break;

	case 'ls_empleado':
		$query = "";
		if(isset($_POST["q"]) && $_POST["q"]!=""){
			$q = $conexion->escape($_POST["q"]);
			$query = " WHERE emp_nom LIKE '%{$q}%' ";
		}
		$selRes = "SELECT emp_id AS 'id',emp_nom AS 'nombre' FROM empleado {$query} ORDER BY emp_id";
		$res = $conexion->execSelect($selRes);
		
		$registros=array();
		if($res["num"]>0){
			$i=0;
			while($iCargo = $conexion->fetchArray($res["result"])){
				$registros[]=array("id"=>$iCargo["id"],"text"=>utf8_encode($iCargo["nombre"]));
			}
		}

		$results = array("results"=>$registros,"more"=>false);
		echo json_encode($results);
	break;

	case 'sv_cargo':
		if(!isset($_POST["nombre"])) exit();

		$tipo = ($_POST["id"]=="")?'nuevo':'editar';

		$id = (int)$conexion->escape($_POST["id"]);
		$nombre = $conexion->escape(utf8_decode($_POST["nombre"]));
		$esDoctor = $conexion->escape(utf8_decode($_POST["esDoctor"]));
		
		$mantoCargo = "";
		if($tipo=='nuevo'){
			$mantoCargo = "INSERT INTO cargo(car_nom,car_es_doctor) VALUES('{$nombre}','{$esDoctor}') ";
		}else{
			$mantoCargo = "UPDATE cargo SET car_nom='{$nombre}', car_es_doctor='{$esDoctor}' WHERE car_id = {$id} ";
		}
		
		$res = 0;
		$res = $conexion->execManto($mantoCargo);

		if($res>0){
			$success = array("success"=>"true","msg"=>"El cargo se ha guardado");
		}else{
			$success = array("success"=>"false","msg"=>"Ha ocurrido un error");
		}
		echo json_encode($success);

	break;

	case 'rt_cargo':
		$result = array("success"=>"false","msg"=>"");

		if(!isset($_POST["id"])){ exit(); }
		$id = $conexion->escape($_POST["id"]);

		$selCargo = "SELECT car_id,car_nom,car_es_doctor FROM cargo WHERE car_id = {$id} ";
		$res = $conexion->execSelect($selCargo);

		if($res["num"]>0){
			$iCargo = $conexion->fetchArray($res["result"]);
			$result = array(
				"id"=>$iCargo["car_id"],
				"nombre"=>utf8_encode($iCargo["car_nom"]),
				"esDoctor"=>$iCargo["car_es_doctor"]
			);
		}

		echo json_encode($result);

	break;

	case 'br_cargo':
		$result = array("success"=>"false","msg"=>"");

		if(!isset($_POST["id"])){ exit(); }
		$id = json_decode($_POST["id"],true);

		$borrarCargo = "DELETE FROM cargo WHERE car_id = {$id} ";
		$res = $conexion->execManto($borrarCargo);
		if($res>0){
			$result = array("success"=>"true","msg"=>"El cargo se ha borrado");
		}else{
			$result = array("success"=>"false","msg"=>"El cargo tiene datos relacionados");
		}
		echo json_encode($result);
		
	break;

	case 'br_varioscargo':
		$result = array("success"=>"false","msg"=>"");

		if(!isset($_POST["id"])){ exit(); }
		$ids = json_decode($_POST["id"],true);
		$tot = count($ids);

		$errores=0;
		$res = 0;

		for($i=0;$i<$tot;$i++){
			$id = $ids[$i];

			$borrarCargo = "DELETE FROM cargo WHERE car_id = {$id} ";
			$res = $conexion->execManto($borrarCargo);
			if(!($res>0)) $errores++;
		}
		if($errores>0 && $errores<$tot){
			$result = array("success"=>"true","msg"=>"Algunos cargos no se pudieron eliminar");
		}elseif($errores==$tot){
			$result = array("success"=>"false","msg"=>"No se pudo eliminar ningun cargo");
		}else{
			$result = array("success"=>"true","msg"=>"Los cargos se han borrado");
			
		}
		echo json_encode($result);
		
	break;
}


?>