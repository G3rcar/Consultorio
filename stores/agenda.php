<?php
include("sesion.back.php");


//- Incluimos la clase de conexion e instanciamos del objeto principal
include_once("../libs/php/class.connection.php");
include_once("../libs/php/class.objetos.base.php");
$conexion = new Conexion();

$minutos_citas = 40;
$hora_inicio = 1379854800;
$hora_fin = 1379887200;


//- Si la variable action no viene se detenemos la ejecucion
if(!isset($_POST["action"])){ exit(); }

$accion = $_POST["action"];

switch ($accion) {
	case 'ls_pacientes':
		$query = "";
		if(isset($_POST["q"]) && $_POST["q"]!=""){
			$q = $conexion->escape($_POST["q"]);
			$query = " WHERE CONCAT(nombres,' ',apellidos) LIKE '%{$q}%' ";
		}
		$selPacientes = "SELECT id,CONCAT(nombres,' ',apellidos) AS 'nombre' FROM paciente {$query} ORDER BY nombres,apellidos";
		$res = $conexion->execSelect($selPacientes);
		
		$registros=array();
		if($res["num"]>0){
			$i=0;
			while($iPaci = $conexion->fetchArray($res["result"])){
				$registros[]=array("id"=>$iPaci["id"],"text"=>utf8_encode($iPaci["nombre"]));
			}
		}

		$results = array("results"=>$registros,"more"=>false);
		echo json_encode($results);
		
	break;

	case 'rt_agenda':

		$selCitas = "SELECT c.id,CONCAT(p.nombres,' ',p.apellidos) AS 'nombre', DATE_FORMAT(c.fecha,'%Y/%m/%d') AS 'fecha',
						DATE_FORMAT(c.fecha,'%H:%i') AS 'hora'
						FROM cita AS c INNER JOIN paciente AS p ON c.idpaciente = p.id";
		
		$res = $conexion->execSelect($selCitas);
		$citas = array();

		$registros=array();
		$i=0;
		if($res["num"]>0){
			while($iCita = $conexion->fetchArray($res["result"])){

				$posicion = calcularCuadroAgenda($iCita["fecha"],$iCita["hora"]);

				$registros[]=array(
					"id_cita"=>$iCita["id"],
					"posicion"=>$posicion,
					"texto_uno"=>utf8_encode($iCita["nombre"]),
					"texto_dos"=>"&nbsp;"
				);
				$i++;
			}
		}

		$results = array("citas"=>$registros,"total"=>$i);
		echo json_encode($results);

	break;

	case 'sv_cita':
		if(!isset($_POST["idpaciente"])||!isset($_POST["hinicio"])||!isset($_POST["idempleado"])) exit();

		$tipo = ($_POST["id"]=="")?'nuevo':'editar';

		$id = (int)$conexion->escape($_POST["id"]);
		$idPaciente = (int)$conexion->escape($_POST["idpaciente"]);
		$idEmpleado = (int)$conexion->escape($_POST["idempleado"]);
		$hi = ((int)$_POST["hinicio"])*60;
		//$hf = (int)$_POST["hfin"]);
		$fe = (int)$_POST["fecha"];
		$fecha = date("Y-m-d H:i:s",$fe+$hi);
		
		$mantoCita = "";
		if($tipo=='nuevo'){
			$mantoCita = "INSERT INTO cita(idpaciente,fecha,idempleado,estado,creacion) VALUES('{$idPaciente}','{$fecha}','{$idEmpleado}','1',NOW()) ";
		}else{
			$mantoCita = "UPDATE cita SET idpaciente='{$idPaciente}',idemplado='{$idEmpleado}',fecha='{$fecha}' WHERE id = {$id} ";
		}
		
		$res = 0;
		$res = $conexion->execManto($mantoCita);

		if($res>0){
			$success = array("success"=>"true","msg"=>"La cita se ha guardado");
		}else{
			$success = array("success"=>"false","msg"=>"Ha ocurrido un error");
		}
		echo json_encode($success);
	break;



	case 'br_cita':
		$result = array("success"=>"false","msg"=>"");

		if(!isset($_POST["id"])){ exit(); }
		$id = json_decode($_POST["id"],true);

		$borrarCita = "DELETE FROM cita WHERE id = {$id} ";
		$res = $conexion->execManto($borrarCita);
		if($res>0){
			$result = array("success"=>"true","msg"=>"La cita se ha borrado");
		}else{
			$result = array("success"=>"false","msg"=>"La cita tiene una consulta relacionada");
		}
		echo json_encode($result);
	break;


}



function calcularCuadroAgenda($fecha,$hora){
	global $minutos_citas,$hora_inicio,$hora_fin;
	$hi = strtotime(date("Y-m-d")." ".date("H:i",$hora_inicio));
	$hf = strtotime(date("Y-m-d")." ".date("H:i",$hora_fin));
	$hc = strtotime(date("Y-m-d")." ".$hora);
	$hMaximo = entero(($hi-$hf)/($minutos_citas*60));

	$diff = $hc-$hi;
	$posh = 0;
	if($diff<=0){ $posh = 0; }
	elseif($diff>=($hf-$hi)){ $posh=$hMaximo; }
	else{ $posh = entero($diff/($minutos_citas*60)); }
	

	$posd = date("N",strtotime($fecha));

	$id = "h_{$posh}_d_{$posd}";
	return $id;
}

function entero($n){
	$nTmp = (string)$n;
	if($nTmp=="") return 0;
	if(strstr($nTmp,".") === false) return (int)$n;
	$nE = explode(".",$n);
	return (int)$nE[0];
}

?>