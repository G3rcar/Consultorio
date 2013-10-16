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
	case 'gd_tipo':

		$selRes = "SELECT tps_id AS 'id',tps_tipo_san AS 'nombre' FROM tipo_sangre ORDER BY tps_id ";
		$res = $conexion->execSelect($selRes);
		$headers = array(
			"Nombre",
			//array("width"=>"200","text"=>"Fecha de creaci&oacute;n"),
			array("width"=>"15","text"=>"&nbsp;"),
			array("width"=>"15","text"=>"&nbsp;")
		);
		$tabla = new GridCheck($headers,"gridTipos");
		if($res["num"]>0){
			$i=0;
			while($iTipo = $conexion->fetchArray($res["result"])){
				//Iconos
				$editar = "<a href='#' onClick='manto.editar({$iTipo["id"]});' title='Editar' ><i class='icon-edit'></i></a>";
				$borrar = "<a href='#' onClick='manto.borrar({$iTipo["id"]});' title='Borrar' ><i class='icon-remove'></i></a>";
				
				$valoresFila = array(utf8_encode($iTipo["nombre"]),$editar,$borrar);
				$fila = array("id"=>$iTipo["id"],"valores"=>$valoresFila);
				$tabla->nuevaFila($fila);
			}
		}

		$html = $tabla->obtenerCodigo();
		echo $html;
		
	break;

	case 'sv_tipo':
		if(!isset($_POST["nombre"])) exit();

		$tipo = ($_POST["id"]=="")?'nuevo':'editar';

		$id = (int)$conexion->escape($_POST["id"]);
		$nombre = $conexion->escape(utf8_decode($_POST["nombre"]));
		
		$nuevoDepto = "";
		if($tipo=='nuevo'){
			$mantoTipo = "INSERT INTO tipo_sangre(tps_tipo_san) VALUES('{$nombre}') ";
		}else{
			$mantoTipo = "UPDATE tipo_sangre SET tps_tipo_san='{$nombre}' WHERE tps_id = {$id} ";
		}
		
		$res = 0;
		$res = $conexion->execManto($mantoTipo);

		if($res>0){
			$success = array("success"=>"true","msg"=>"El registro se ha guardado");
		}else{
			$success = array("success"=>"false","msg"=>"Ha ocurrido un error");
		}
		echo json_encode($success);

	break;

	case 'rt_tipo':
		$result = array("success"=>"false","msg"=>"");

		if(!isset($_POST["id"])){ exit(); }
		$id = $conexion->escape($_POST["id"]);

		$selTipo = "SELECT tps_id,tps_tipo_san FROM tipo_sangre WHERE tps_id = {$id} ";
		$res = $conexion->execSelect($selTipo);

		if($res["num"]>0){
			$iTipo = $conexion->fetchArray($res["result"]);
			$result = array("id"=>$iTipo["tps_id"],"nombre"=>utf8_encode($iTipo["tps_tipo_san"]));
		}

		echo json_encode($result);

	break;

	case 'br_tipo':
		$result = array("success"=>"false","msg"=>"");

		if(!isset($_POST["id"])){ exit(); }
		$id = json_decode($_POST["id"],true);

		$borrarDepto = "DELETE FROM tipo_sangre WHERE tps_id = {$id} ";
		$res = $conexion->execManto($borrarDepto);
		if($res>0){
			$result = array("success"=>"true","msg"=>"El registro se ha borrado");
		}else{
			$result = array("success"=>"false","msg"=>"El registro tiene datos relacionados");
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

			$borrarDepto = "DELETE FROM tipo_sangre WHERE tps_id = {$id} ";
			$res = $conexion->execManto($borrarDepto);
			if(!($res>0)) $errores++;
		}
		if($errores>0 && $errores<$tot){
			$result = array("success"=>"true","msg"=>"Algunos registros no se pudieron eliminar");
		}elseif($errores==$tot){
			$result = array("success"=>"false","msg"=>"No se pudo eliminar ningun registros");
		}else{
			$result = array("success"=>"true","msg"=>"Los registros se han borrado");
			
		}
		echo json_encode($result);
		
	break;
}


?>