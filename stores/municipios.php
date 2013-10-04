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
	case 'gd_muni':

		$selDeptos = "SELECT m.id,m.nombre,d.nombre AS 'depto',DATE_FORMAT(m.creacion,'%d/%m/%Y %h:%i %p') AS 'creacion' 
						FROM departamento AS d INNER JOIN municipio AS m ON m.iddepartamento = d.id
						ORDER BY d.nombre,m.nombre";
		$res = $conexion->execSelect($selDeptos);
		$headers = array(
			"Nombre","Departamento",
			array("width"=>"200","text"=>"Fecha de creaci&oacute;n"),
			array("width"=>"15","text"=>"&nbsp;"),
			array("width"=>"15","text"=>"&nbsp;")
		);
		$tabla = new GridCheck($headers,"gridMuni");
		if($res["num"]>0){
			$i=0;
			while($iMuni = $conexion->fetchArray($res["result"])){
				//Iconos
				$editar = "<a href='#' onClick='manto.editar({$iMuni["id"]});' title='Editar' ><i class='icon-edit'></i></a>";
				$borrar = "<a href='#' onClick='manto.borrar({$iMuni["id"]});' title='Borrar' ><i class='icon-remove'></i></a>";
				
				$valoresFila = array(utf8_encode($iMuni["nombre"]),utf8_encode($iMuni["depto"]),$iMuni["creacion"],$editar,$borrar);
				$fila = array("id"=>$iMuni["id"],"valores"=>$valoresFila);
				$tabla->nuevaFila($fila);
			}
		}

		$html = $tabla->obtenerCodigo();
		echo $html;
		
	break;

	case 'ls_depto':
		$query = "";
		if(isset($_POST["q"]) && $_POST["q"]!=""){
			$q = $conexion->escape($_POST["q"]);
			$query = " WHERE nombre LIKE '%{$q}%' ";
		}
		$selDeptos = "SELECT id,nombre FROM departamento {$query} ORDER BY id";
		$res = $conexion->execSelect($selDeptos);
		
		$registros=array();
		if($res["num"]>0){
			$i=0;
			while($iDepto = $conexion->fetchArray($res["result"])){
				$registros[]=array("id"=>$iDepto["id"],"text"=>utf8_encode($iDepto["nombre"]));
			}
		}

		$results = array("results"=>$registros,"more"=>false);
		echo json_encode($results);
	break;




	case 'sv_muni':
		if(!isset($_POST["nombre"])) exit();

		$tipo = ($_POST["id"]=="")?'nuevo':'editar';

		$id = (int)$conexion->escape($_POST["id"]);
		$idDepto = (int)$conexion->escape($_POST["idDepto"]);
		$nombre = $conexion->escape(utf8_decode($_POST["nombre"]));
		
		$nuevoDepto = "";
		if($tipo=='nuevo'){
			$mantoDepto = "INSERT INTO municipio(nombre,iddepartamento,creacion) VALUES('{$nombre}','{$idDepto}',NOW()) ";
		}else{
			$mantoDepto = "UPDATE municipio SET nombre='{$nombre}',iddepartamento='{$idDepto}' WHERE id = {$id} ";
		}
		
		$res = 0;
		$res = $conexion->execManto($mantoDepto);

		if($res>0){
			$success = array("success"=>"true","msg"=>"El municipio se ha guardado");
		}else{
			$success = array("success"=>"false","msg"=>"Ha ocurrido un error");
		}
		echo json_encode($success);

	break;

	case 'rt_muni':
		$result = array("success"=>"false","msg"=>"");

		if(!isset($_POST["id"])){ exit(); }
		$id = $conexion->escape($_POST["id"]);

		$selMuni = "SELECT m.id,m.nombre,m.iddepartamento,d.nombre AS 'depto' 
					FROM municipio AS m INNER JOIN departamento AS d ON m.iddepartamento = d.id WHERE m.id = {$id} ";
		$res = $conexion->execSelect($selMuni);

		if($res["num"]>0){
			$iMuni = $conexion->fetchArray($res["result"]);
			$result = array("id"=>$iMuni["id"],"nombre"=>$iMuni["nombre"],"idDepto"=>$iMuni["iddepartamento"],"depto"=>$iMuni["depto"]);
		}

		echo json_encode($result);

	break;

	case 'br_muni':
		$result = array("success"=>"false","msg"=>"");

		if(!isset($_POST["id"])){ exit(); }
		$id = json_decode($_POST["id"],true);

		$borrarDepto = "DELETE FROM municipio WHERE id = {$id} ";
		$res = $conexion->execManto($borrarDepto);
		if($res>0){
			$result = array("success"=>"true","msg"=>"El municipio se ha borrado");
		}else{
			$result = array("success"=>"false","msg"=>"El municipio tiene datos relacionados");
		}
		echo json_encode($result);
		
	break;

	case 'br_variosmuni':
		$result = array("success"=>"false","msg"=>"");

		if(!isset($_POST["id"])){ exit(); }
		$ids = json_decode($_POST["id"],true);
		$tot = count($ids);

		$errores=0;
		$res = 0;

		for($i=0;$i<$tot;$i++){
			$id = $ids[$i];

			$borrarDepto = "DELETE FROM municipio WHERE id = {$id} ";
			$res = $conexion->execManto($borrarDepto);
			if(!($res>0)) $errores++;
		}
		if($errores>0 && $errores<$tot){
			$result = array("success"=>"true","msg"=>"Algunos municipios no se pudieron eliminar");
		}elseif($errores==$tot){
			$result = array("success"=>"false","msg"=>"No se pudo eliminar ningun municipio");
		}else{
			$result = array("success"=>"true","msg"=>"Los municipios se han borrado");
			
		}
		echo json_encode($result);
		
	break;
}


?>