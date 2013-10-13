<?php
include("../stores/sesion.back.php");


//- Incluimos la clase de conexion e instanciamos del objeto principal
include_once("../libs/php/class.connection.php");
$conexion = new Conexion();



$selCitas = "SELECT c.id,CONCAT(e.nombres,' ',e.apellidos) AS 'empleado',CONCAT(p.nombres,' ',p.apellidos) AS 'paciente', 
				DATE_FORMAT(c.fecha,'%d/%m/%Y %h:%i %p') AS 'fecha'
				FROM cita AS c 
				INNER JOIN paciente AS p ON c.idpaciente = p.id
				INNER JOIN empleado AS e ON c.idempleado = e.id ORDER BY c.fecha ASC ";

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