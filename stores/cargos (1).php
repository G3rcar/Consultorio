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

		$selRes = "SELECT * FROM cargo";
		$res = $conexion->execSelect($selRes);
		$headers = array( "Nombre", "Cargo", array("width"=>"15","text"=>"&nbsp;"),	array("width"=>"15","text"=>"&nbsp;"));
		$tabla = new GridCheck($headers,"gridCargos");
		if($res["num"]> 0){
			$i=0;
			while($iCargo = $conexion->fetchArray($res["result"])){
				//Iconos
				$editar = "<a href='#' onClick='manto.editar({$iCargo["car_id"]});' title='Editar' ><i class='icon-edit'></i></a>";
				$borrar = "<a href='#' onClick='manto.borrar({$iCargo["car_id"]});' title='Borrar' ><i class='icon-remove'></i></a>";
				
				$valoresFila = array(utf8_encode($iCargo["car_nom"]),'',$editar,$borrar);
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
		$empleado = (int)$conexion->escape(utf8_decode($_POST["idEmpleado"]));
		
		$nuevoCargo = "";
		if($tipo=='nuevo'){
			$mantoCargo = "INSERT INTO cargo(cargo_nom,cargo_idemp) VALUES('{$nombre}','{$empleado}') ";
		}else{
			$mantoCargo = "UPDATE cargo SET cargo_nom='{$nombre}', cargo_idpai='{$empleado}' WHERE cargo_id = {$id} ";
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

		$selCargo = "SELECT cargo_id,cargo_nom,emp_id,emp_nom FROM cargo AS d INNER JOIN empleado AS p 
						WHERE emp_id = {$id} ";
		$res = $conexion->execSelect($selCargo);

		if($res["num"]>0){
			$iCargo = $conexion->fetchArray($res["result"]);
			$result = array("id"=>$iCargo["cargo_id"],"nombre"=>utf8_encode($iCargo["cargo_nom"]),"idEmpleado"=>$iCargo["emp_id"],"empleado"=>utf8_encode($iCargo["emp_nom"]));
		}

		echo json_encode($result);

	break;

	case 'br_cargo':
		$result = array("success"=>"false","msg"=>"");

		if(!isset($_POST["id"])){ exit(); }
		$id = json_decode($_POST["id"],true);

		$borrarCargo = "DELETE FROM cargo WHERE id = {$id} ";
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

			$borrarCargo = "DELETE FROM cargo WHERE id = {$id} ";
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