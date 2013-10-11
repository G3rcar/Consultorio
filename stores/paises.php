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
	case 'gd_pais':

		$selPais = "SELECT id,nombre,DATE_FORMAT(creacion,'%d/%m/%Y %h:%i %p') AS 'creacion' FROM pais ORDER BY id ";
		$res = $conexion->execSelect($selPais);
		$headers = array(
			"Nombre",
			array("width"=>"200","text"=>"Fecha de creaci&oacute;n"),
			array("width"=>"15","text"=>"&nbsp;"),
			array("width"=>"15","text"=>"&nbsp;")
		);
		$tabla = new GridCheck($headers,"gridPais");
		if($res["num"]>0){
			$i=0;
			while($iPais = $conexion->fetchArray($res["result"])){
				//Iconos
				$editar = "<a href='#' onClick='manto.editar({$iPais["id"]});' title='Editar' ><i class='icon-edit'></i></a>";
				$borrar = "<a href='#' onClick='manto.borrar({$iPais["id"]});' title='Borrar' ><i class='icon-remove'></i></a>";
				
				$valoresFila = array(utf8_encode($iPais["nombre"]),$iPais["creacion"],$editar,$borrar);
				$fila = array("id"=>$iPais["id"],"valores"=>$valoresFila);
				$tabla->nuevaFila($fila);
			}
		}

		$html = $tabla->obtenerCodigo();
		echo $html;
		
	break;

	case 'pais':
		if(!isset($_POST["nombre"])) exit();

		$tipo = ($_POST["id"]=="")?'nuevo':'editar';

		$id = (int)$conexion->escape($_POST["id"]);
		$nombre = $conexion->escape(utf8_decode($_POST["nombre"]));
		
		$nuevoPais = "";
		if($tipo=='nuevo'){
			$mantoPais = "INSERT INTO pais(nombre,creacion) VALUES('{$nombre}',NOW()) ";
		}else{
			$mantoPais = "UPDATE pais SET nombre='{$nombre}' WHERE id = {$id} ";
		}
		
		$res = 0;
		$res = $conexion->execManto($mantoPais);

		if($res>0){
			$success = array("success"=>"true","msg"=>"El pais se ha guardado");
		}else{
			$success = array("success"=>"false","msg"=>"Ha ocurrido un error");
		}
		echo json_encode($success);

	break;

	case 'rt_pais':
		$result = array("success"=>"false","msg"=>"");

		if(!isset($_POST["id"])){ exit(); }
		$id = $conexion->escape($_POST["id"]);

		$selPais = "SELECT id,nombre FROM pais WHERE id = {$id} ";
		$res = $conexion->execSelect($selPais);

		if($res["num"]>0){
			$iPais = $conexion->fetchArray($res["result"]);
			$result = array("id"=>$iPais["id"],"nombre"=>utf8_encode($iPais["nombre"]));
		}

		echo json_encode($result);

	break;

	case 'br_pais':
		$result = array("success"=>"false","msg"=>"");

		if(!isset($_POST["id"])){ exit(); }
		$id = json_decode($_POST["id"],true);

		$borrarPais = "DELETE FROM pais WHERE id = {$id} ";
		$res = $conexion->execManto($borrarPais);
		if($res>0){
			$result = array("success"=>"true","msg"=>"El pais se ha borrado");
		}else{
			$result = array("success"=>"false","msg"=>"El pais tiene datos relacionados");
		}
		echo json_encode($result);
		
	break;

	case 'br_variospais':
		$result = array("success"=>"false","msg"=>"");

		if(!isset($_POST["id"])){ exit(); }
		$ids = json_decode($_POST["id"],true);
		$tot = count($ids);

		$errores=0;
		$res = 0;

		for($i=0;$i<$tot;$i++){
			$id = $ids[$i];

			$borrarPais = "DELETE FROM pais WHERE id = {$id} ";
			$res = $conexion->execManto($borrarPais);
			if(!($res>0)) $errores++;
		}
		if($errores>0 && $errores<$tot){
			$result = array("success"=>"true","msg"=>"Algunos paises no se pudieron eliminar");
		}elseif($errores==$tot){
			$result = array("success"=>"false","msg"=>"No se pudo eliminar ningun pais");
		}else{
			$result = array("success"=>"true","msg"=>"Los paises se han borrado");
			
		}
		echo json_encode($result);
		
	break;
}


?>