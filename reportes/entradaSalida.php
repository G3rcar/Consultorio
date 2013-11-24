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
	case 'rep_es':

		$selRes = "SELECT fac_tipo, fac_id, CONCAT(fac_nom_cli, ' ', fac_ape_cli) as nombre, fac_can, fac_tot, fac_fecha FROM facturacion";
		$res = $conexion->execSelect($selRes);
		$headers = array(
			"Tipo",
			"# Doc",
			"Nombre",
			"Entrada",
			"Salida",
			"Valor Total",
			"Fecha",
		);
		$tabla = new GridCheck($headers,"gridDeptos");
		if($res["num"]>0){
			$i=0;
			while($iDepto = $conexion->fetchArray($res["result"])){

				if ($iDepto["fac_tipo"] == 'Factura') {
					$valoresFila = array($iDepto["fac_tipo"],$iDepto["fac_id"],$iDepto["nombre"],$iDepto["fac_can"],'-',$iDepto["fac_tot"],$iDepto["fac_fecha"]);					
				}elseif ($iDepto["fac_tipo"] = 'Compra') {
					$valoresFila = array($iDepto["fac_tipo"],$iDepto["fac_id"],$iDepto["nombre"],'-',$iDepto["fac_can"],$iDepto["fac_tot"],$iDepto["fac_fecha"]);
				}

				
				$fila = array("id"=>$iDepto["dep_id"],"valores"=>$valoresFila);
				$tabla->nuevaFila($fila);
			}
		}

		$html = $tabla->obtenerCodigo();
		echo $html;
		
	break;


	case 'rep_sea':

		if(!isset($_POST["desde"])){ exit(); }else{ $desde = $_POST["desde"]; }
		if(!isset($_POST["hasta"])){ exit(); }else{ $hasta = $_POST["hasta"]; }
		
		if ($desde != '' && $hasta != '') {
			$where = " where fac_fecha BETWEEN '" . $desde . "' AND '" . $hasta . "' ";
		}elseif ($desde != '') {
			$where = " where fac_fecha >= '" . $desde . "'";
		}elseif ($hasta != '') {
			$where = " where fac_fecha <= '" . $hasta . "'";
		}

		$selRes = "SELECT fac_tipo, fac_id, CONCAT(fac_nom_cli, ' ', fac_ape_cli) as nombre, fac_can, fac_tot, fac_fecha FROM facturacion" . $where;
		$res = $conexion->execSelect($selRes);
		$headers = array(
			"Tipo",
			"# Doc",
			"Nombre",
			"Entrada",
			"Salida",
			"Valor Total",
			"Fecha",
		);
		$tabla = new GridCheck($headers,"gridDeptos");
		if($res["num"]>0){
			$i=0;
			while($iDepto = $conexion->fetchArray($res["result"])){

				if ($iDepto["fac_tipo"] == 'Factura') {
					$valoresFila = array($iDepto["fac_tipo"],$iDepto["fac_id"],$iDepto["nombre"],$iDepto["fac_can"],'-',$iDepto["fac_tot"],$iDepto["fac_fecha"]);					
				}elseif ($iDepto["fac_tipo"] = 'Compra') {
					$valoresFila = array($iDepto["fac_tipo"],$iDepto["fac_id"],$iDepto["nombre"],'-',$iDepto["fac_can"],$iDepto["fac_tot"],$iDepto["fac_fecha"]);
				}

				
				$fila = array("id"=>$iDepto["dep_id"],"valores"=>$valoresFila);
				$tabla->nuevaFila($fila);
			}
		}

		$html = $tabla->obtenerCodigo();
		echo $html;
		
	break;


}


?>