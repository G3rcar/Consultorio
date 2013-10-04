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
	case 'gd_depto':

		$selDeptos = "SELECT id,nombre,DATE_FORMAT(creacion,'%d/%m/%Y %h:%i %p') AS 'creacion' FROM departamento ORDER BY id ";
		$res = $conexion->execSelect($selDeptos);
		$headers = array(
			"Nombre",
			array("width"=>"200","text"=>"Fecha de creaci&oacute;n"),
			array("width"=>"15","text"=>"&nbsp;"),
			array("width"=>"15","text"=>"&nbsp;")
		);
		$tabla = new GridCheck($headers,"gridDeptos");
		if($res["num"]>0){
			$i=0;
			while($iDepto = $conexion->fetchArray($res["result"])){
				//Iconos
				$editar = "<a href='#' onClick='manto.editar({$iDepto["id"]});' title='Editar' ><i class='icon-edit'></i></a>";
				$borrar = "<a href='#' onClick='manto.borrar({$iDepto["id"]});' title='Borrar' ><i class='icon-remove'></i></a>";
				
				$valoresFila = array(utf8_encode($iDepto["nombre"]),$iDepto["creacion"],$editar,$borrar);
				$fila = array("id"=>$iDepto["id"],"valores"=>$valoresFila);
				$tabla->nuevaFila($fila);
			}
		}

		$html = $tabla->obtenerCodigo();
		echo $html;
		
	break;

	case 'sv_depto':
		if(!isset($_POST["nombre"])) exit();

		$tipo = ($_POST["id"]=="")?'nuevo':'editar';

		$id = (int)$conexion->escape($_POST["id"]);
		$nombre = $conexion->escape(utf8_decode($_POST["nombre"]));
		
		$nuevoDepto = "";
		if($tipo=='nuevo'){
			$mantoDepto = "INSERT INTO departamento(nombre,creacion) VALUES('{$nombre}',NOW()) ";
		}else{
			$mantoDepto = "UPDATE departamento SET nombre='{$nombre}' WHERE id = {$id} ";
		}
		
		$res = 0;
		$res = $conexion->execManto($mantoDepto);

		if($res>0){
			$success = array("success"=>"true","msg"=>"El departamento se ha guardado");
		}else{
			$success = array("success"=>"false","msg"=>"Ha ocurrido un error");
		}
		echo json_encode($success);

	break;

	case 'rt_depto':
		$result = array("success"=>"false","msg"=>"");

		if(!isset($_POST["id"])){ exit(); }
		$id = $conexion->escape($_POST["id"]);

		$selDepto = "SELECT id,nombre FROM departamento WHERE id = {$id} ";
		$res = $conexion->execSelect($selDepto);

		if($res["num"]>0){
			$iDepto = $conexion->fetchArray($res["result"]);
			$result = array("id"=>$iDepto["id"],"nombre"=>utf8_encode($iDepto["nombre"]));
		}

		echo json_encode($result);

	break;

	case 'br_depto':
		$result = array("success"=>"false","msg"=>"");

		if(!isset($_POST["id"])){ exit(); }
		$id = json_decode($_POST["id"],true);

		$borrarDepto = "DELETE FROM departamento WHERE id = {$id} ";
		$res = $conexion->execManto($borrarDepto);
		if($res>0){
			$result = array("success"=>"true","msg"=>"El departamento se ha borrado");
		}else{
			$result = array("success"=>"false","msg"=>"El departamento tiene datos relacionados");
		}
		echo json_encode($result);
		
	break;

	case 'br_variosdepto':
		$result = array("success"=>"false","msg"=>"");

		if(!isset($_POST["id"])){ exit(); }
		$ids = json_decode($_POST["id"],true);
		$tot = count($ids);

		$errores=0;
		$res = 0;

		for($i=0;$i<$tot;$i++){
			$id = $ids[$i];

			$borrarDepto = "DELETE FROM departamento WHERE id = {$id} ";
			$res = $conexion->execManto($borrarDepto);
			if(!($res>0)) $errores++;
		}
		if($errores>0 && $errores<$tot){
			$result = array("success"=>"true","msg"=>"Algunos departamentos no se pudieron eliminar");
		}elseif($errores==$tot){
			$result = array("success"=>"false","msg"=>"No se pudo eliminar ningun departamento");
		}else{
			$result = array("success"=>"true","msg"=>"Los departamentos se han borrado");
			
		}
		echo json_encode($result);
		
	break;
}


?>