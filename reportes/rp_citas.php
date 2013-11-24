<?php
include("../stores/sesion.back.php");


//- Incluimos la clase de conexion e instanciamos del objeto principal
include_once("../libs/php/class.connection.php");
$conexion = new Conexion();



$selCitas = "SELECT c.cit_id AS 'id',CONCAT(e.emp_nom,' ',e.emp_ape) AS 'empleado',
				CONCAT(p.pac_nom,' ',p.pac_ape) AS 'paciente', 
				DATE_FORMAT(c.cit_fecha_cita,'%d/%m/%Y %h:%i %p') AS 'fecha' 
				FROM cita AS c 
				INNER JOIN paciente AS p ON c.cit_idpac= p.pac_id 
				INNER JOIN empleado AS e ON c.cit_idemp= e.emp_id 
				ORDER BY c.cit_fecha_cita ASC";

$res = $conexion->execSelect($selCitas);

$reporte = "<table class='table table-bordered table-striped table-hover' style='width:100%;'><thead>
			<tr class='headGrid'><th>Doctor</th><th>Paciente</th><th width='150'>Fecha y Hora</th></tr></thead><tbody>";

if($res["num"]>0){
	$i=0;
	while($iCita = $conexion->fetchArray($res["result"])){
		$reporte .= "<tr>";
		$reporte .= "<td>".utf8_encode($iCita["empleado"])."</td>";
		$reporte .= "<td>".utf8_encode($iCita["paciente"])."</td>";
		$reporte .= "<td>".$iCita["fecha"]."</td>";
		$reporte .= "<tr>";
	}
}

$reporte .= "</tbody></table>";


echo $reporte;

?>