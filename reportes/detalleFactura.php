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
	case 'rep_facs':

		$selRes = "SELECT * FROM facturacion WHERE fac_tipo = 'Factura'";
		$res = $conexion->execSelect($selRes);

		$headers = array(
			"Nombre Cliente",
			"Descripcion",
			"Cantidad",
			"Total",
			"Fecha Factura",
			"Fecha Creacion",
			array("width"=>"15","text"=>"Detalle")
		);
		$tabla = new GridCheck($headers,"gridDeptos");
		if($res["num"]>0){
			$i=0;
			while($iDepto = $conexion->fetchArray($res["result"])){
				//Iconos
				$editar = "<a href='#' onClick='manto.detalle({$iDepto["fac_id"]});' title='Editar'><center><i class='icon-edit'></i></center></a>";
				
				$valoresFila = array(utf8_encode($iDepto["fac_nom_cli"] . ' ' . $iDepto["fac_ape_cli"]),utf8_encode($iDepto["fac_desc"]),$iDepto["fac_can"],$iDepto["fac_tot"],$iDepto["fac_fecha"],$iDepto["fac_fecha_cre"],$editar);
				$fila = array("id"=>$iDepto["fac_id"],"valores"=>$valoresFila);
				$tabla->nuevaFila($fila);
			}
		}	

		$html = $tabla->obtenerCodigo();
		echo $html;
		
	break;

	case 'rep_det':
		$result = array("success"=>"false","msg"=>"");

		if(!isset($_POST["id"])){ exit(); }
		$id = $conexion->escape($_POST["id"]);

		$selDepto = "
						SELECT 
							f.fac_id, f.fac_desc, f.fac_fecha, f.fac_dir, f.fac_can, f.fac_tot, CONCAT(f.fac_nom_cli,' ' ,f.fac_ape_cli) as nombreCliente, f.fac_tipo, f.fac_registro, f.fac_fecha_cre, 
							d.dtf_can, d.dtf_pre_uni, d.dtf_tot,  d.dtf_fecha_cre, 
							p.pro_nom, p.pro_ubi, p.pro_salant_uni, p.pro_salant_mon, p.pro_costo_uni, p.pro_ult_cost, p.pro_ult_ven, p.pro_fecha_cre, 
							s.suc_nom,
							m.mar_nom 
						FROM 
							facturacion as f 
							INNER JOIN detalle_facturacion as d ON d.dtf_idpro = f.fac_id 
							INNER JOIN producto as p ON p.pro_id = d.dtf_idpro
							INNER JOIN sucursal as s ON p.pro_idsuc = s.suc_id 
							INNER JOIN marca as m ON p.pro_idmar = m.mar_id 

						WHERE 
							f.fac_id = {$id} and fac_tipo = 'Factura';


						";
		$res = $conexion->execSelect($selDepto);

		if($res["num"]>0){
			$i=0;
			while($iDepto = $conexion->fetchArray($res["result"])){
				$registros[] = array("fac_id"=>$iDepto["fac_id"],"nombreCliente"=>$iDepto["nombreCliente"],"fac_fecha"=>$iDepto["fac_fecha"],"fac_dir"=>$iDepto["fac_dir"],"dtf_can"=>$iDepto["dtf_can"],"fac_desc"=>$iDepto["fac_desc"],"dtf_pre_uni"=>$iDepto["dtf_pre_uni"],"dtf_tot"=>$iDepto["dtf_tot"],"fac_tot"=>$iDepto["fac_tot"]);
			}
		}	

		$header = "
			<table style='border: 0px none; width: 100%; text-align: left;'>
				<tr>
					<th style='width: 100px;'>Cliente</th>
					<td style='width: 500px;'>" . $registros['0']['nombreCliente'] . "</td>
					<th style='width: 100px;'>Fecha:</th>
					<td style='width: 200px;'>" . $registros['0']['fac_fecha'] . "</td>
				</tr>
				<tr>
					<th>Direccion:</th>
					<td>" . $registros['0']['fac_dir'] . "</td>
					<th>Nit o DUI</th>
					<td></td>
				</tr>
			</table>
			</br>

		";

		$header_detalle = "
							<table style='border: 0px none; width: 100%; text-align: center;'>
								<tr>
									<th style='width: 7%;'>CANT.</th>
									<th style='width: 68%; '>DESCRIPCION</th>
									<th style='width: 20%;'>PRECIO UNITARIO</th>
									<th style='width: 5%;'>TOTAL</th>
								</tr>			
		";
		$det_detalle = '';
			for ($j=0; $j <count($registros) ; $j++) { 
				$det_detalle .= "
					<tr>
						<td>" . $registros[$j]['dtf_can'] . "</td>
						<td>" . $registros[$j]['fac_desc'] . "</td>
						<td>" . $registros[$j]['dtf_pre_uni'] . "</td>
						<td>" . $registros[$j]['dtf_tot'] . "</td>
					<tr/>
				";
			}

		$det_footer = "
			<tr>
				<th colspan='3'  style='text-align: right; padding-right: 20px;'>Venta Total</th>
				<td>" . $registros['0']['fac_tot'] . "</td>
			</tr>
			</table>

			<br>
			<br>
		";


		$detalle_total = $header . $header_detalle . $det_detalle . $det_footer;

		echo $detalle_total;
	break;












	case 'rep_facs':

		$selRes = "SELECT * FROM facturacion WHERE fac_tipo = 'Factura'";
		$res = $conexion->execSelect($selRes);

		$headers = array(
			"Nombre Cliente",
			"Descripcion",
			"Cantidad",
			"Total",
			"Fecha Factura",
			"Fecha Creacion",
			array("width"=>"15","text"=>"Detalle")
		);
		$tabla = new GridCheck($headers,"gridDeptos");
		if($res["num"]>0){
			$i=0;
			while($iDepto = $conexion->fetchArray($res["result"])){
				//Iconos
				$editar = "<a href='#' onClick='manto.detalle({$iDepto["fac_id"]});' title='Editar'><center><i class='icon-edit'></i></center></a>";
				
				$valoresFila = array(utf8_encode($iDepto["fac_nom_cli"] . ' ' . $iDepto["fac_ape_cli"]),utf8_encode($iDepto["fac_desc"]),$iDepto["fac_can"],$iDepto["fac_tot"],$iDepto["fac_fecha"],$iDepto["fac_fecha_cre"],$editar);
				$fila = array("id"=>$iDepto["fac_id"],"valores"=>$valoresFila);
				$tabla->nuevaFila($fila);
			}
		}	

		$html = $tabla->obtenerCodigo();
		echo $html;
		
	break;

	case 'rep_sea':
		$result = array("success"=>"false","msg"=>"");


		if(!isset($_POST["desde"])){ exit(); }else{ $desde = $_POST["desde"]; }
		if(!isset($_POST["hasta"])){ exit(); }else{ $hasta = $_POST["hasta"]; }
		
		if ($desde != '' && $hasta != '') {
			$where = " and fac_fecha BETWEEN '" . $desde . "' AND '" . $hasta . "' ";
		}elseif ($desde != '') {
			$where = " and fac_fecha >= '" . $desde . "'";
		}elseif ($hasta != '') {
			$where = " and fac_fecha <= '" . $hasta . "'";
		}


		$selRes = "SELECT * FROM facturacion WHERE fac_tipo = 'Factura'" . $where;
		$res = $conexion->execSelect($selRes);

		$headers = array(
			"Nombre Cliente",
			"Descripcion",
			"Cantidad",
			"Total",
			"Fecha Factura",
			"Fecha Creacion",
			array("width"=>"15","text"=>"Detalle")
		);
		$tabla = new GridCheck($headers,"gridDeptos");
		if($res["num"]>0){
			$i=0;
			while($iDepto = $conexion->fetchArray($res["result"])){
				//Iconos
				$editar = "<a href='#' onClick='manto.detalle({$iDepto["fac_id"]});' title='Editar'><center><i class='icon-edit'></i></center></a>";
				
				$valoresFila = array(utf8_encode($iDepto["fac_nom_cli"] . ' ' . $iDepto["fac_ape_cli"]),utf8_encode($iDepto["fac_desc"]),$iDepto["fac_can"],$iDepto["fac_tot"],$iDepto["fac_fecha"],$iDepto["fac_fecha_cre"],$editar);
				$fila = array("id"=>$iDepto["fac_id"],"valores"=>$valoresFila);
				$tabla->nuevaFila($fila);
			}
		}	

		$html = $tabla->obtenerCodigo();
		echo $html;


	break;
}





?>