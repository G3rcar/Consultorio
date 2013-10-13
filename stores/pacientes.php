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
	case 'gd_paciente':

		$selpaciente = "SELECT id,nombres,DATE_FORMAT(creacion,'%d/%m/%Y %h:%i %p'), apellidos,alergias,tipo_sangre, estado AS 'creacion' FROM paciente ORDER BY id ";
		$res = $conexion->execSelect($selpacicente);
		$headers = array(
			"Nombre",
			array("width"=>"200","text"=>"Fecha de creaci&oacute;n"),
			array("width"=>"15","text"=>"&nbsp;"),
			array("width"=>"15","text"=>"&nbsp;")
		);
		$tabla = new GridCheck($headers,"gridpaciente");
		if($res["num"]>0){
			$i=0;
			while($ipaciente = $conexion->fetchArray($res["result"])){
				//Iconos
				$editar = "<a href='#' onClick='manto.editar({$ipaciente["id"]});' title='Editar' ><i class='icon-edit'></i></a>";
				$borrar = "<a href='#' onClick='manto.borrar({$ipaciente["id"]});' title='Borrar' ><i class='icon-remove'></i></a>";
				
				$valoresFila = array(utf8_encode($ipaciente["nombre"]),$ipaciente["creacion"],$editar,$borrar);
				$fila = array("id"=>$ipaciente["id"],"valores"=>$valoresFila);
				$tabla->nuevaFila($fila);
			}
		}

		$html = $tabla->obtenerCodigo();
		echo $html;
		
	break;

	case 'sv_paciente':
		if(!isset($_POST["nombre"])) exit();

		$tipo = ($_POST["id"]=="")?'nuevo':'editar';

		$id = (int)$conexion->escape($_POST["id"]);
		$nombre = $conexion->escape(utf8_decode($_POST["nombre"]));
		
		$nuevopaciente = "";
		if($tipo=='nuevo'){
			$mantopaciente = "INSERT INTO paciente(nombre,creacion) VALUES('{$nombre}',NOW()) ";
		}else{
			$mantopaciente = "UPDATE paciente SET nombre='{$nombre}' WHERE id = {$id} ";
		}
		
		$res = 0;
		$res = $conexion->execManto($mantopaciente);

		if($res>0){
			$success = array("success"=>"true","msg"=>"El departamento se ha guardado");
		}else{
			$success = array("success"=>"false","msg"=>"Ha ocurrido un error");
		}
		echo json_encode($success);

	break;

	case 'rt_paciente':
		$result = array("success"=>"false","msg"=>"");

		if(!isset($_POST["id"])){ exit(); }
		$id = $conexion->escape($_POST["id"]);

		$selpaciente = "SELECT id,nombre FROM departamento WHERE id = {$id} ";
		$res = $conexion->execSelect($selpaciente);

		if($res["num"]>0){
			$iDepto = $conexion->fetchArray($res["result"]);
			$result = array("id"=>$ipaciente["id"],"nombre"=>utf8_encode($ipaciente["nombre"]));
		}

		echo json_encode($result);

	break;

	case 'br_depto':
		$result = array("success"=>"false","msg"=>"");

		if(!isset($_POST["id"])){ exit(); }
		$id = json_decode($_POST["id"],true);

		$borrarpaciente = "DELETE FROM paciente WHERE id = {$id} ";
		$res = $conexion->execManto($borrarpaciente);
		if($res>0){
			$result = array("success"=>"true","msg"=>"El paciente se ha borrado");
		}else{
			$result = array("success"=>"false","msg"=>"El paciente tiene datos relacionados");
		}
		echo json_encode($result);
		
	break;

	case 'br_variospaciente':
		$result = array("success"=>"false","msg"=>"");

		if(!isset($_POST["id"])){ exit(); }
		$ids = json_decode($_POST["id"],true);
		$tot = count($ids);

		$errores=0;
		$res = 0;

		for($i=0;$i<$tot;$i++){
			$id = $ids[$i];

			$borrarpaciente = "DELETE FROM paciente WHERE id = {$id} ";
			$res = $conexion->execManto($borrarpaciente);
			if(!($res>0)) $errores++;
		}
		if($errores>0 && $errores<$tot){
			$result = array("success"=>"true","msg"=>"Algunos pacientes no se pudieron eliminar");
		}elseif($errores==$tot){
			$result = array("success"=>"false","msg"=>"No se pudo eliminar ningun paciente");
		}else{
			$result = array("success"=>"true","msg"=>"Los pacientes se han borrado");
			
		}
		echo json_encode($result);
		
	break;
}


?>