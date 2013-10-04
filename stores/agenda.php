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
		$selPacientes = "SELECT id,CONCAT(nombres,' ',apellidos) AS 'nombre' FROM paciente {$query}";
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





	case 'sv_depto':
		if(!isset($_POST["nombre"])) exit();

		$tipo = ($_POST["id"]=="")?'nuevo':'editar';

		$id = (int)$conexion->escape($_POST["id"]);
		$nombre = $conexion->escape($_POST["nombre"]);
		
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
			$result = array("id"=>$iDepto["id"],"nombre"=>$iDepto["nombre"]);
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
			$result = array("success"=>"true","msg"=>"Los departamentos se han borrado {$errores} {$tot}");
			
		}
		echo json_encode($result);
		
	break;
}


?>