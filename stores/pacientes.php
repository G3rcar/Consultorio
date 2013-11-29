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
	case 'gd_pacientes':

		$conexion->execManto("SET lc_time_names = 'es_ES'");

		$query="";
		if(isset($_POST["query"]) && $_POST["query"]!=""){
			$q = $conexion->escape($_POST["query"]);
			$query = " WHERE pac_nom LIKE '%{$q}%' OR pac_ape LIKE '%{$q}%' OR con_desc LIKE '%{$q}%' OR con_diag LIKE '%{$q}%' ";
		}

		$selResult = " SELECT p.pac_id,p.pac_nom,p.pac_ape,mu.mun_nom,de.dep_nom,DATE_FORMAT(p.pac_fecha_cre,'%d/%m/%Y') AS 'fecha'
					FROM paciente AS p
					INNER JOIN direccion AS di ON p.pac_iddir = di.dir_id
					INNER JOIN municipio AS mu ON di.dir_idmun = mu.mun_id
					INNER JOIN departamento AS de ON mu.mun_iddep = de.dep_id
					ORDER BY p.pac_fecha_cre ";

		$res = $conexion->execSelect($selResult);
		$headers = array(
			"Nombre","Apellido","Direcci&oacute;n","Creaci&oacute;n",
			array("width"=>"15","text"=>"&nbsp;"),
			array("width"=>"15","text"=>"&nbsp;")
		);
		$tabla = new GridCheck($headers,"gridPaciente");
		if($res["num"]>0){
			$i=0;
			while($iRes = $conexion->fetchArray($res["result"])){
				//Iconos
				$editar = "<a href='#' onClick='manto.editar({$iRes["pac_id"]});' title='Editar' ><i class='icon-edit'></i></a>";
				$borrar = "<a href='#' onClick='manto.borrar({$iRes["pac_id"]});' title='Borrar' ><i class='icon-remove'></i></a>";
				
				$valoresFila = array(
					utf8_encode($iRes["pac_nom"]),
					utf8_encode($iRes["pac_ape"]),
					utf8_encode($iRes["mun_nom"].", ".$iRes["dep_nom"]),
					utf8_encode($iRes["fecha"]),
					$editar,$borrar);
				$fila = array("id"=>$iRes["pac_id"],"valores"=>$valoresFila);
				$tabla->nuevaFila($fila);
			}
		}

		$html = $tabla->obtenerCodigo();
		echo $html;
		
	break;
}


?>