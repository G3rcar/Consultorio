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
	case 'gd_sucursal':

		$selSuc = " SELECT su.suc_id,su.suc_nom,mu.mun_nom,de.dep_nom,DATE_FORMAT(di.dir_fecha_cre,'%d/%m/%Y') AS 'dir_fecha_cre'
					FROM sucursal AS su
					INNER JOIN direccion AS di ON su.suc_iddir = di.dir_id
					INNER JOIN municipio AS mu ON di.dir_idmun = mu.mun_id
					INNER JOIN departamento AS de ON mu.mun_iddep = de.dep_id
					ORDER BY suc_id ";



		$res = $conexion->execSelect($selSuc);
		$headers = array(
			"Nombre",
			array("width"=>"200","text"=>"Direccion"),
			array("width"=>"200","text"=>"Fecha de creaci&oacute;n"),
			array("width"=>"15","text"=>"&nbsp;"),
			array("width"=>"15","text"=>"&nbsp;")
		);
		$tabla = new GridCheck($headers,"gridSucursales");
		if($res["num"]>0){
			$i=0;
			while($iSuc = $conexion->fetchArray($res["result"])){
				//Iconos
				$editar = "<a href='#' onClick='manto.editar({$iSuc["suc_id"]});' title='Editar' ><i class='icon-edit'></i></a>";
				$borrar = "<a href='#' onClick='manto.borrar({$iSuc["suc_id"]});' title='Borrar' ><i class='icon-remove'></i></a>";
				
				$valoresFila = array(utf8_encode($iSuc["suc_nom"]),$iSuc["mun_nom"].", ".$iSuc["dep_nom"],$iSuc["dir_fecha_cre"],$editar,$borrar);
				$fila = array("id"=>$iSuc["suc_id"],"valores"=>$valoresFila);
				$tabla->nuevaFila($fila);
			}
		}

		$html = $tabla->obtenerCodigo();
		echo $html;
		
	break;

	case 'sv_sucursal':
		if(!isset($_POST["nombre"])) exit();

		$tipo = ($_POST["id"]=="")?'nuevo':'editar';

		$id = (int)$conexion->escape($_POST["id"]);
		$nombre  = $conexion->escape(utf8_decode($_POST["nombre"]));
		$municipio  = (int)$conexion->escape(utf8_decode($_POST["municipio"]));
		$distrito = $conexion->escape(utf8_decode($_POST["distrito"]));
		$colonia = $conexion->escape(utf8_decode($_POST["colonia"]));
		$calle = $conexion->escape(utf8_decode($_POST["calle"]));
		$calleComplemento = $conexion->escape(utf8_decode($_POST["calleComplemento"]));
		$condominio = $conexion->escape(utf8_decode($_POST["condominio"]));
		$condominio2 = $conexion->escape(utf8_decode($_POST["condominio2"]));
		$casa = $conexion->escape(utf8_decode($_POST["casa"]));
		$referencia = $conexion->escape(utf8_decode($_POST["referencia"]));
		$nuevoSuc = "";

		$res = 0;
		if($tipo=='nuevo'){
			$mantoSuc = "INSERT INTO direccion(dir_cond,dir_cond2,dir_calle,dir_compcalle, dir_casa, dir_col, dir_dist, dir_ref, dir_idmun,dir_fecha_cre) 
						VALUES('{$condominio}','{$condominio2}','{$calle}','{$calleComplemento}','{$casa}','{$colonia}','{$distrito}','{$referencia}','{$municipio}',NOW()) ";
			$res = $conexion->execManto($mantoSuc);
			$idDir = $conexion->lastId();
			$mantoSuc = "INSERT INTO sucursal(suc_nom,suc_iddir) VALUES('{$nombre}','{$idDir}') ";
			$res = $conexion->execManto($mantoSuc);
		}else{
			$selIdDir = "SELECT suc_iddir FROM sucursal WHERE suc_id = {$id} ";
			$res = $conexion->execSelect($selIdDir);
			if($res["num"]>0){
				$iD = $conexion->fetchArray($res["result"]);
				$mantoSuc = "UPDATE direccion SET dir_cond='{$condominio}', dir_cond2='{$condominio2}', dir_calle='{$calle}',dir_compcalle='{$calleComplemento}',
							dir_casa='{$casa}', dir_col='{$colonia}',dir_dist='{$distrito}',dir_ref='{$referencia}',dir_idmun='{$municipio}' WHERE dir_id = '".$iD["suc_iddir"]."' ";
				$res = $conexion->execManto($mantoSuc);
			}
			$mantoSuc = "UPDATE sucursal SET suc_nom='{$nombre}' WHERE suc_id = {$id} ";
			$res = $conexion->execManto($mantoSuc);
		}
		

		//if($res>0){
			$success = array("success"=>"true","msg"=>"La sucursal se ha guardado");
		//}else{
		//	$success = array("success"=>"false","msg"=>"Ha ocurrido un error");
		//}
		echo json_encode($success);

	break;

	case 'rt_suc':
		$result = array("success"=>"false","msg"=>"");

		if(!isset($_POST["id"])){ exit(); }
		$id = $conexion->escape($_POST["id"]);

		$selSuc = "SELECT suc_id,suc_nom   FROM sucursal WHERE suc_id = {$id} ";
		$res = $conexion->execSelect($selSuc);

		if($res["num"]>0){
			$iSuc = $conexion->fetchArray($res["result"]);
			$result = array("id"=>$iSuc["suc_id"],"suc_nom"=>utf8_encode($iSuc["suc_nom"]));
		}

		echo json_encode($result);

	break;

	case 'br_suc':
		$result = array("success"=>"false","msg"=>"");

		if(!isset($_POST["id"])){ exit(); }
		$id = json_decode($_POST["id"],true);

		$borrarSuc = "DELETE FROM sucursal WHERE suc_id = {$id} ";
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

			$borrarSuc = "DELETE FROM sucursal WHERE suc_id = {$id} ";
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


	case 'ls_muni':
		$query = "";
		if(!isset($_POST["depto"])) exit();

		$idDepto = $conexion->escape($_POST["depto"]);
		if(isset($_POST["q"]) && $_POST["q"]!=""){
			$q = $conexion->escape($_POST["q"]);
			$query = " AND mun_nom LIKE '%{$q}%' ";
		}

		$selRes = "SELECT mun_id AS 'id',mun_nom AS 'nombre' FROM municipio WHERE mun_iddep = {$idDepto} {$query} ORDER BY mun_id";
		$res = $conexion->execSelect($selRes);
		
		$registros=array();
		if($res["num"]>0){
			$i=0;
			while($iMun = $conexion->fetchArray($res["result"])){
				$registros[]=array("id"=>$iMun["id"],"text"=>utf8_encode($iMun["nombre"]));
			}
		}

		$results = array("results"=>$registros,"more"=>false);
		echo json_encode($results);
	break;
}


?>