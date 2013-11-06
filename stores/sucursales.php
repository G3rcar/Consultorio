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
	case 'gd_suc':

		$selSuc = " SELECT suc_id,suc_nom,dir_cond,dir_cond2,dir_calle,dir_compcalle, dir_casa, dir_col, dir_dist, dir_ref, dir_fecha_cre, dir_idmun
		FROM sucursal
		INNER JOIN direccion ON suc_iddir = dir_id
		ORDER BY suc_id ";



		$res = $conexion->execSelect($selSuc);
		$headers = array(
			"Nombre",
			array("width"=>"200","text"=>"Fecha de creaci&oacute;n"),
			array("width"=>"200","text"=>"Direccion;"),
			array("width"=>"15","text"=>"&nbsp;")
		);
		$tabla = new GridCheck($headers,"gridSucursales");
		if($res["num"]>0){
			$i=0;
			while($iSuc = $conexion->fetchArray($res["result"])){
				//Iconos
				$editar = "<a href='#' onClick='manto.editar({$iSuc["id"]});' title='Editar' ><i class='icon-edit'></i></a>";
				$borrar = "<a href='#' onClick='manto.borrar({$iSuc["id"]});' title='Borrar' ><i class='icon-remove'></i></a>";
				
				$valoresFila = array(utf8_encode($iSuc["nombre"]),$iSuc["creacion"],$editar,$borrar);
				$fila = array("id"=>$iSuc["id"],"valores"=>$valoresFila);
				$tabla->nuevaFila($fila);
			}
		}

		$html = $tabla->obtenerCodigo();
		echo $html;
		
	break;

	case 'suc':
		if(!isset($_POST["nombre"])) exit();

		$tipo = ($_POST["id"]=="")?'nuevo':'editar';

		$id = (int)$conexion->escape($_POST["id"]);
		$nombre = $conexion->escape(utf8_decode($_POST["nombre"]));
		
		$nuevoSuc = "";
		if($tipo=='nuevo'){
			$mantoSuc = "INSERT INTO direccion(nombre,creacion) VALUES('{$nombre}',NOW()) ";
			"INSERT INTO sucursal(nombre,creacion) VALUES('{$nombre}',NOW()) ";
		}else{
			$mantoSuc = "UPDATE sucursal SET nombre='{$nombre}' WHERE id = {$id} ";
		}
		
		$res = 0;
		$res = $conexion->execManto($mantoSuc);

		if($res>0){
			$success = array("success"=>"true","msg"=>"La sucursal se ha guardado");
		}else{
			$success = array("success"=>"false","msg"=>"Ha ocurrido un error");
		}
		echo json_encode($success);

	break;

	case 'rt_suc':
		$result = array("success"=>"false","msg"=>"");

		if(!isset($_POST["id"])){ exit(); }
		$id = $conexion->escape($_POST["id"]);

		$selSuc = "SELECT id,nombre FROM sucursal WHERE id = {$id} ";
		$res = $conexion->execSelect($selSuc);

		if($res["num"]>0){
			$iSuc = $conexion->fetchArray($res["result"]);
			$result = array("id"=>$iSuc["id"],"nombre"=>utf8_encode($iSuc["nombre"]));
		}

		echo json_encode($result);

	break;

	case 'br_Suc':
		$result = array("success"=>"false","msg"=>"");

		if(!isset($_POST["id"])){ exit(); }
		$id = json_decode($_POST["id"],true);

		$borrarSuc = "DELETE FROM sucursal WHERE id = {$id} ";
		$res = $conexion->execManto($borrarSuc);
		if($res>0){
			$result = array("success"=>"true","msg"=>"La sucursal se ha borrado");
		}else{
			$result = array("success"=>"false","msg"=>"La sucursal tiene datos relacionados");
		}
		echo json_encode($result);
		
	break;

	case 'br_variossuc':
		$result = array("success"=>"false","msg"=>"");

		if(!isset($_POST["id"])){ exit(); }
		$ids = json_decode($_POST["id"],true);
		$tot = count($ids);

		$errores=0;
		$res = 0;

		for($i=0;$i<$tot;$i++){
			$id = $ids[$i];

			$borrarSuc = "DELETE FROM sucursal WHERE id = {$id} ";
			$res = $conexion->execManto($borrarSuc);
			if(!($res>0)) $errores++;
		}
		if($errores>0 && $errores<$tot){
			$result = array("success"=>"true","msg"=>"Algunas sucursales no se pudieron eliminar");
		}elseif($errores==$tot){
			$result = array("success"=>"false","msg"=>"No se pudo eliminar ninguna sucursal");
		}else{
			$result = array("success"=>"true","msg"=>"Las sucursales se han borrado");
			
		}
		echo json_encode($result);
		
	break;
}


?>