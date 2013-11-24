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

		$selDeptos = "SELECT m.mun_id AS 'id',m.mun_nom AS 'muni',d.dep_nom AS 'depto',p.pai_nom AS 'pais' 
						FROM departamento AS d INNER JOIN municipio AS m ON m.mun_iddep = d.dep_id
						INNER JOIN pais AS p ON d.dep_idpai = p.pai_id
						ORDER BY p.pai_nom,d.dep_nom,m.mun_nom";
		$res = $conexion->execSelect($selDeptos);
		$headers = array(
			"Nombre","Departamento","Pa&iacute;s",
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
				
				$valoresFila = array(utf8_encode($iMuni["muni"]),utf8_encode($iMuni["depto"]),utf8_encode($iMuni["pais"]),$editar,$borrar);
				$fila = array("id"=>$iMuni["id"],"valores"=>$valoresFila);
				$tabla->nuevaFila($fila);
			}
		}

		$html = $tabla->obtenerCodigo();
		echo $html;
		
	break;

	case 'ls_pais':
		$query = "";
		
		if(isset($_POST["q"]) && $_POST["q"]!=""){
			$q = $conexion->escape($_POST["q"]);
			$query = " WHERE pai_nom LIKE '%{$q}%' ";
		}
		$selDeptos = "SELECT pai_id AS 'id', pai_nom AS 'nombre' FROM pais {$query} ORDER BY id";
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

	case 'ls_depto':
		$query = "";
		if(!isset($_POST["pais"])) exit();

		$idPais = $conexion->escape($_POST["pais"]);
		if(isset($_POST["q"]) && $_POST["q"]!=""){
			$q = $conexion->escape($_POST["q"]);
			$query = " AND dep_nom LIKE '%{$q}%' ";
		}
		$selDeptos = "SELECT dep_id AS 'id', dep_nom AS 'nombre' FROM departamento WHERE dep_idpai = {$idPais} {$query} ORDER BY id";
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
		
		$mantoMuni = "";
		if($tipo=='nuevo'){
			$mantoMuni = "INSERT INTO municipio(mun_nom,mun_iddep) VALUES('{$nombre}','{$idDepto}') ";
		}else{
			$mantoMuni = "UPDATE municipio SET mun_nom='{$nombre}',mun_iddep='{$idDepto}' WHERE mun_id = {$id} ";
		}
		
		$res = 0;
		$res = $conexion->execManto($mantoMuni);

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

		$selMuni = "SELECT m.mun_id,m.mun_nom,d.dep_id,d.dep_nom AS 'depto',p.pai_id,p.pai_nom AS 'pais' 
					FROM municipio AS m INNER JOIN departamento AS d ON m.mun_iddep = d.dep_id 
					INNER JOIN pais AS p ON d.dep_idpai = p.pai_id
					WHERE m.mun_id = {$id} ";
		$res = $conexion->execSelect($selMuni);

		if($res["num"]>0){
			$iMuni = $conexion->fetchArray($res["result"]);
			$result = array("id"=>$iMuni["mun_id"],"nombre"=>utf8_encode($iMuni["mun_nom"]),"idDepto"=>$iMuni["dep_id"],"depto"=>utf8_encode($iMuni["depto"]),"idPais"=>$iMuni["pai_id"],"pais"=>$iMuni["pais"]);
		}

		echo json_encode($result);

	break;

	case 'br_muni':
		$result = array("success"=>"false","msg"=>"");

		if(!isset($_POST["id"])){ exit(); }
		$id = json_decode($_POST["id"],true);

		$borrarDepto = "DELETE FROM municipio WHERE mun_id = {$id} ";
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

			$borrarDepto = "DELETE FROM municipio WHERE mun_id = {$id} ";
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