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

		$selPais = "SELECT pai_id,pai_nom,DATE_FORMAT(pai_fecha_cre,'%d/%m/%Y %h:%i %p') AS 'pai_fecha_cre' FROM pais ORDER BY pai_id ";
		$res = $conexion->execSelect($selPais);
		$headers = array(
			"Nombre",
			array("width"=>"200","text"=>"Fecha de creaci&oacute;n"),
			array("width"=>"15","text"=>"&nbsp;"),
			array("width"=>"15","text"=>"&nbsp;")
		);
		$tabla = new GridCheck($headers,"gridPaises");
		if($res["num"]>0){
			$i=0;
			while($iPais = $conexion->fetchArray($res["result"])){
				//Iconos
				$editar = "<a href='#' onClick='manto.editar({$iPais["pai_id"]});' title='Editar' ><i class='icon-edit'></i></a>";
				$borrar = "<a href='#' onClick='manto.borrar({$iPais["pai_id"]});' title='Borrar' ><i class='icon-remove'></i></a>";
				
				$valoresFila = array(utf8_encode($iPais["pai_nom"]),$iPais["pai_fecha_cre"],$editar,$borrar);
				$fila = array("pai_id"=>$iPais["pai_id"],"valores"=>$valoresFila);
				$tabla->nuevaFila($fila);
			}
		}

		$html = $tabla->obtenerCodigo();
		echo $html;
		
	break;

	case 'pais':
		if(!isset($_POST["pai_nom"])) exit();

		$tipo = ($_POST["pai_id"]=="")?'nuevo':'editar';

		$id = (int)$conexion->escape($_POST["pai_id"]);
		$nombre = $conexion->escape(utf8_decode($_POST["pai_nombre"]));
		
		$nuevoPais = "";
		if($tipo=='nuevo'){
			$mantoPais = "INSERT INTO pais(pai_nom,pai_fecha_cre) VALUES('{$nombre}',NOW()) ";
		}else{
			$mantoPais = "UPDATE pais SET pai_nom ='{$nombre}' WHERE pai_id = {$id} ";
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

		if(!isset($_POST["pai_id"])){ exit(); }
		$id = $conexion->escape($_POST["pai_id"]);

		$selPais = "SELECT pai_id,pai_nom FROM pais WHERE pai_id = {$id} ";
		$res = $conexion->execSelect($selPais);

		if($res["num"]>0){
			$iPais = $conexion->fetchArray($res["result"]);
			$result = array("pai_id"=>$iPais["pai_id"],"pai_nombre"=>utf8_encode($iPais["pai_nombre"]));
		}

		echo json_encode($result);

	break;

	case 'br_pais':
		$result = array("success"=>"false","msg"=>"");

		if(!isset($_POST["pai_id"])){ exit(); }
		$id = json_decode($_POST["pai_id"],true);

		$borrarPais = "DELETE FROM pais WHERE pai_id = {$id} ";
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

		if(!isset($_POST["pai_id"])){ exit(); }
		$ids = json_decode($_POST["pai_id"],true);
		$tot = count($ids);

		$errores=0;
		$res = 0;

		for($i=0;$i<$tot;$i++){
			$id = $ids[$i];

			$borrarPais = "DELETE FROM pais WHERE pai_id = {$id} ";
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