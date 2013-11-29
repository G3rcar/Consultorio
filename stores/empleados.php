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
	case 'gd_empleados':

		$selSuc = "SELECT emp.emp_id,emp.emp_nom,mu.mun_nom,de.dep_nom,DATE_FORMAT(di.dir_fecha_cre,'%d/%m/%Y') AS 'dir_fecha_cre'
					FROM empleado AS emp
					INNER JOIN direccion AS di ON emp.emp_iddir = di.dir_id
					INNER JOIN municipio AS mu ON di.dir_idmun = mu.mun_id
					INNER JOIN departamento AS de ON mu.mun_iddep = de.dep_id
					ORDER BY emp_id;";



		$res = $conexion->execSelect($selSuc);
		$headers = array(
			"Nombre",
                        array("width"=>"200","text"=>"Apellido"),
			array("width"=>"200","text"=>"Direccion"),
			array("width"=>"200","text"=>"Fecha de creaci&oacute;n"),
			array("width"=>"15","text"=>"&nbsp;"),
			array("width"=>"15","text"=>"&nbsp;")
		);
		$tabla = new GridCheck($headers,"gridEmpleados");
		if($res["num"]>0){
			$i=0;
			while($iEmp = $conexion->fetchArray($res["result"])){
				//Iconos
				$editar = "<a href='#' onClick='manto.editar({$iEmp["emp_id"]});' title='Editar' ><i class='icon-edit'></i></a>";
				$borrar = "<a href='#' onClick='manto.borrar({$iEmp["emp_id"]});' title='Borrar' ><i class='icon-remove'></i></a>";
				
				$valoresFila = array(utf8_encode($iEmp["emp_nom"]),$iEmp["mun_nom"].", ".$iEmp["dep_nom"],$iEmp["dir_fecha_cre"],$editar,$borrar);
				$fila = array("id"=>$iEmp["emp_id"],"valores"=>$valoresFila);
				$tabla->nuevaFila($fila);
			}
		}

		$html = $tabla->obtenerCodigo();
		echo $html;
		
	break;

	case 'empl':
		if(!isset($_POST["nombre"])) exit();

		$tipo = ($_POST["id"]=="")?'nuevo':'editar';

		$id = (int)$conexion->escape($_POST["id"]);
		$nombre  = $conexion->escape(utf8_decode($_POST["nombre"]));
                $apellido  = $conexion->escape(utf8_decode($_POST["apellido"]));
                $fecha_nac  = $conexion->escape(utf8_decode($_POST["fecha"]));
                $genero  = $conexion->escape(utf8_decode($_POST["genero"]));
                $sucursal  = $conexion->escape(utf8_decode($_POST["sucursal"]));
                $cargo  = $conexion->escape(utf8_decode($_POST["cargo"]));
                
		$condominio = $conexion->escape(utf8_decode($_POST["condominio"]));
		$condominio2 = $conexion->escape(utf8_decode($_POST["condominio2"]));
		$calle = $conexion->escape(utf8_decode($_POST["calle"]));
		$calleComplemento = $conexion->escape(utf8_decode($_POST["calleComplemento"]));
		$casa = $conexion->escape(utf8_decode($_POST["casa"]));
		$colonia = $conexion->escape(utf8_decode($_POST["colonia"]));
		$distrito = $conexion->escape(utf8_decode($_POST["distrito"]));
		$referencia = $conexion->escape(utf8_decode($_POST["referencia"]));
		$nuevoEmp = "";
		if($tipo=='nuevo'){
			$mantoSuc = "INSERT INTO direccion(dir_cond,dir_cond2,dir_calle,dir_compcalle, dir_casa, dir_col, dir_dist, dir_ref, dir_fecha_cre) VALUES('{$condominio}','{$condominio2}','{$calle}','{$calleComplemento}','{$casa}','{$colonia}','{$distrito}','{$referencia}',NOW()) ";
			"INSERT INTO empleado 
                        (emp_nom,emp_ape,emp_fecha_nac,emp_gen,emp_idsuc,emp_idcar) 
                         VALUES
                        ('{$nombre}','{$apellido}','{$fecha_nac}','{$genero}', '{$sucursal}','{$cargo}') ";
		}else{
			$mantoSuc = "UPDATE sucursal SET suc_nombre='{$nombre}' WHERE emp_id = {$id} ";
			"UPDATE sucursal SET suc_nombre='{$nombre}' WHERE emp_id = {$id} ";
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

		$selSuc = "SELECT emp_id,suc_nom   FROM sucursal WHERE emp_id = {$id} ";
		$res = $conexion->execSelect($selSuc);

		if($res["num"]>0){
			$iEmp = $conexion->fetchArray($res["result"]);
			$result = array("id"=>$iEmp["emp_id"],"suc_nom"=>utf8_encode($iEmp["suc_nom"]));
		}

		echo json_encode($result);

	break;

	case 'br_Suc':
		$result = array("success"=>"false","msg"=>"");

		if(!isset($_POST["id"])){ exit(); }
		$id = json_decode($_POST["id"],true);

		$borrarEmp = "DELETE FROM sucursal WHERE emp_id = {$id} ";
		$res = $conexion->execManto($borrarEmp);
		if($res>0){
			$result = array("success"=>"true","msg"=>"El empleado se ha borrado");
		}else{
			$result = array("success"=>"false","msg"=>"El empleado tiene datos relacionados");
		}
		echo json_encode($result);
		
	break;

	case 'br_variosemp':
		$result = array("success"=>"false","msg"=>"");

		if(!isset($_POST["id"])){ exit(); }
		$ids = json_decode($_POST["id"],true);
		$tot = count($ids);

		$errores=0;
		$res = 0;

		for($i=0;$i<$tot;$i++){
			$id = $ids[$i];

			$borrarSuc = "DELETE FROM empleado WHERE emp_id = {$id} ";
			$res = $conexion->execManto($borrarSuc);
			if(!($res>0)) $errores++;
		}
		if($errores>0 && $errores<$tot){
			$result = array("success"=>"true","msg"=>"Algunas empleados no se pudieron eliminar");
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