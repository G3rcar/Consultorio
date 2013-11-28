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
	case 'gd_consultas':

		$conexion->execManto("SET lc_time_names = 'es_ES'");

		$selResult = "SELECT c.con_id,p.pac_nom,p.pac_ape,c.con_desc,c.con_diag,
					DATE_FORMAT(ci.cit_fecha_cita,'%d/%b/%Y %h:%i %p') AS 'fecha' 
					FROM consulta AS c INNER JOIN cita AS ci ON c.con_idcit = ci.cit_id 
					INNER JOIN paciente AS p ON ci.cit_idpac = p.pac_id
					ORDER BY ci.cit_fecha_cita";
		$res = $conexion->execSelect($selResult);
		$headers = array(
			"Paciente","Descripci&oacute;n","Diagn&oacute;stico","Fecha",
			array("width"=>"15","text"=>"&nbsp;"),
			array("width"=>"15","text"=>"&nbsp;")
		);
		$tabla = new GridCheck($headers,"gridConsulta");
		if($res["num"]>0){
			$i=0;
			while($iRes = $conexion->fetchArray($res["result"])){
				//Iconos
				$editar = "<a href='#' onClick='manto.editar({$iRes["con_id"]});' title='Editar' ><i class='icon-edit'></i></a>";
				$borrar = "<a href='#' onClick='manto.borrar({$iRes["con_id"]});' title='Borrar' ><i class='icon-remove'></i></a>";
				
				$valoresFila = array(
					utf8_encode($iRes["pac_nom"]." ".$iRes["pac_ape"]),
					utf8_encode($iRes["con_desc"]),
					utf8_encode($iRes["con_diag"]),
					utf8_encode($iRes["fecha"]),
					$editar,$borrar);
				$fila = array("id"=>$iRes["con_id"],"valores"=>$valoresFila);
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




	case 'sv_consulta':
		if(!isset($_POST["idc"])) exit();

		$tipo = ($_POST["id"]=="")?'nuevo':'editar';


		$id = (int)$conexion->escape($_POST["id"]);
		$idC = (int)$conexion->escape($_POST["idc"]);
		$descripcion = $conexion->escape($_POST["descripcion"]);
		$diagnostico = $conexion->escape($_POST["diagnostico"]);
		$detalle = $conexion->escape($_POST["detalle"]);
		$medicinas = $conexion->escape($_POST["medicinas"]);
		

		$mantoConsulta = "";
		if($tipo=='nuevo'){
			$mantoConsulta = "INSERT INTO consulta(con_diag,con_desc,con_idcit) VALUES('{$diagnostico}','{$descripcion}','{$idC}') ";
		}else{
			$mantoConsulta = "UPDATE consulta SET con_diag='{$diagnostico}',con_desc='{$descripcion}' WHERE con_id = {$id} ";
		}
		
		$res = 0;
		$res = $conexion->execManto($mantoConsulta);

		if($tipo=='nuevo'){
			$idCon = $conexion->lastId();
			$mantoReceta = "INSERT INTO receta(rec_desc,rec_idcon,rec_fecha_cre) VALUES('{$detalle}','{$idCon}',NOW()) ";
		}else{
			$mantoReceta = "UPDATE receta SET rec_desc='{$detalle}' WHERE rec_idcon = '{$id}' ";
		}
		$res = $conexion->execManto($mantoReceta);

		$rec = $conexion->execSelect("SELECT rec_id FROM receta WHERE rec_idcon='{$id}'");
		if($rec["num"]>0){
			$iR = $conexion->fetchArray($rec["result"]);
			$idRec = $iR["rec_id"];
			$res = $conexion->execManto("DELETE FROM detalle_receta WHERE dtr_idrec={$idRec}");

			$tmpMed = explode("####--####", $medicinas);
			for($i=0;$i<count($tmpMed);$i++){
				$newMed = "INSERT INTO detalle_receta(dtr_idrec,dtr_desc,dtr_fecha_cre) VALUES('{$idRec}','".$tmpMed[$i]."',NOW()) "; 
				$res = $conexion->execManto($newMed);
			}
		}
		
		



		$success = array("success"=>"true","msg"=>"La consulta se ha guardado");
		
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