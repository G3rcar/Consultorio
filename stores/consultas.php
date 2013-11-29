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

		$query="";
		if(isset($_POST["query"]) && $_POST["query"]!=""){
			$q = $conexion->escape($_POST["query"]);
			$query = " WHERE pac_nom LIKE '%{$q}%' OR pac_ape LIKE '%{$q}%' OR con_desc LIKE '%{$q}%' OR con_diag LIKE '%{$q}%' ";
		}

		$selResult = "SELECT c.con_id,p.pac_nom,p.pac_ape,c.con_desc,c.con_diag,
					DATE_FORMAT(ci.cit_fecha_cita,'%d/%m/%Y %h:%i %p') AS 'fecha' 
					FROM consulta AS c INNER JOIN cita AS ci ON c.con_idcit = ci.cit_id 
					INNER JOIN paciente AS p ON ci.cit_idpac = p.pac_id
					{$query}
					ORDER BY ci.cit_fecha_cita DESC";
		$res = $conexion->execSelect($selResult);
		$headers = array(
			"Paciente","Descripci&oacute;n","Diagn&oacute;stico","Fecha",
			array("width"=>"15","text"=>"&nbsp;"),
			array("width"=>"15","text"=>"&nbsp;"),
			array("width"=>"15","text"=>"&nbsp;")
		);
		$tabla = new GridCheck($headers,"gridConsulta");
		if($res["num"]>0){
			$i=0;
			while($iRes = $conexion->fetchArray($res["result"])){
				//Iconos
				$receta = "<a href='#' onClick='manto.verReceta({$iRes["con_id"]});' title='Mostrar receta' ><i class='icon-list-alt'></i></a>";
				$editar = "<a href='#' onClick='manto.editar({$iRes["con_id"]});' title='Editar' ><i class='icon-edit'></i></a>";
				$borrar = "<a href='#' onClick='manto.borrar({$iRes["con_id"]});' title='Borrar' ><i class='icon-remove'></i></a>";
				
				$valoresFila = array(
					utf8_encode($iRes["pac_nom"]." ".$iRes["pac_ape"]),
					utf8_encode($iRes["con_desc"]),
					utf8_encode($iRes["con_diag"]),
					utf8_encode($iRes["fecha"]),
					$receta,$editar,$borrar);
				$fila = array("id"=>$iRes["con_id"],"valores"=>$valoresFila);
				$tabla->nuevaFila($fila);
			}
		}

		$html = $tabla->obtenerCodigo();
		echo $html;
		
	break;


	case 'sv_consulta':
		if(!isset($_POST["idc"])) exit();

		$tipo = ($_POST["id"]=="")?'nuevo':'editar';


		$id = (int)$conexion->escape($_POST["id"]);
		$idC = (int)$conexion->escape($_POST["idc"]);
		$descripcion = utf8_decode($conexion->escape($_POST["descripcion"]));
		$diagnostico = utf8_decode($conexion->escape($_POST["diagnostico"]));
		$detalle = utf8_decode($conexion->escape($_POST["detalle"]));
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
			$id = $conexion->lastId();
			$mantoReceta = "INSERT INTO receta(rec_desc,rec_idcon,rec_fecha_cre) VALUES('{$detalle}','{$id}',NOW()) ";
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
				$newMed = "INSERT INTO detalle_receta(dtr_idrec,dtr_desc,dtr_fecha_cre) VALUES('{$idRec}','".utf8_decode($tmpMed[$i])."',NOW()) "; 
				$res = $conexion->execManto($newMed);
			}
		}


		$success = array("success"=>"true","msg"=>"La consulta se ha guardado");
		
		echo json_encode($success);

	break;



	case 'rt_receta':
		$result = array("success"=>"false","msg"=>"");

		if(!isset($_POST["id"])){ exit(); }
		$id = $conexion->escape($_POST["id"]);

		$body ="<label>Detalle</label><div class='well'>{detalle}</div><label>Medicinas</label><div class='well'>{medicinas}</div>";
		$selReceta = "SELECT rec_id,rec_desc FROM receta WHERE rec_idcon = '{$id}' ";
		$resR = $conexion->execSelect($selReceta);
		if($resR["num"]>0){
			$iRe = $conexion->fetchArray($resR["result"]);
			$desc = utf8_encode($iRe["rec_desc"]);
			$body = str_replace("{detalle}",$desc,$body);

			$selMedi = "SELECT dtr_id,dtr_desc FROM detalle_receta WHERE dtr_idrec = ".$iRe["rec_id"];
			$resM = $conexion->execSelect($selMedi);
			if($resM["num"]>0){
				$mediItems="";
				while ($iReM = $conexion->fetchArray($resM["result"])) {
					$mediItems .= ($mediItems!=""?", ":"").utf8_encode($iReM["dtr_desc"]);
				}
				$body = str_replace("{medicinas}",$mediItems,$body);
			}
		}

		echo $body;

	break;

	case 'br_consulta':
		$result = array("success"=>"false","msg"=>"");

		if(!isset($_POST["id"])){ exit(); }
		$id = json_decode($_POST["id"],true);

		$borrarRes = "DELETE FROM detalle_receta WHERE dtr_idrec IN (SELECT rec_id FROM receta WHERE rec_idcon = {$id})";
		$res = $conexion->execManto($borrarRes);
		$borrarRes = "DELETE FROM receta WHERE rec_idcon = {$id} ";
		$res = $conexion->execManto($borrarRes);
		$borrarRes = "DELETE FROM consulta WHERE con_id = {$id} ";
		$res = $conexion->execManto($borrarRes);
		if($res>0){
			$result = array("success"=>"true","msg"=>"El municipio se ha borrado");
		}else{
			$result = array("success"=>"false","msg"=>"El municipio tiene datos relacionados");
		}
		echo json_encode($result);
		
	break;

	case 'br_variasconsulta':
		$result = array("success"=>"false","msg"=>"");

		if(!isset($_POST["id"])){ exit(); }
		$ids = json_decode($_POST["id"],true);
		$tot = count($ids);

		$errores=0;
		$res = 0;

		for($i=0;$i<$tot;$i++){
			$id = $ids[$i];

			$borrarRes = "DELETE FROM detalle_receta WHERE dtr_idrec IN (SELECT rec_id FROM receta WHERE rec_idcon = {$id})";
			$res = $conexion->execManto($borrarRes);
			$borrarRes = "DELETE FROM receta WHERE rec_idcon = {$id} ";
			$res = $conexion->execManto($borrarRes);
			$borrarRes = "DELETE FROM consulta WHERE con_id = {$id} ";
			$res = $conexion->execManto($borrarRes);

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