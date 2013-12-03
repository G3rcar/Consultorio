<?php
include("sesion.back.php");


//- Incluimos la clase de conexion e instanciamos del objeto principal
include_once("../libs/php/class.connection.php");
include_once("../libs/php/class.objetos.base.php");
$conexion = new Conexion();

$minutos_citas = $conf["duracion"]; //40;
$hora_inicio = $conf["horaInicio"]; //1379854800;
$hora_fin = $conf["horaFin"]; //1379887200;
$arrayDias = array("1"=>"Lunes","2"=>"Martes","3"=>"Mi&eacute;rcoles","4"=>"Jueves","5"=>"Viernes","6"=>"S&aacute;bado","7"=>"Domingo");


//- Si la variable action no viene se detenemos la ejecucion
if(!isset($_POST["action"])){ exit(); }

$accion = $_POST["action"];

switch ($accion) {
	case 'ls_pacientes':
		$query = "";
		if(isset($_POST["q"]) && $_POST["q"]!=""){
			$q = $conexion->escape($_POST["q"]);
			$query = " WHERE CONCAT(pac_nom,' ',pac_ape) LIKE '%{$q}%' ";
		}
		$selPacientes = "SELECT pac_id AS 'id',CONCAT(pac_nom,' ',pac_ape) AS 'nombre',pac_correo AS 'mail' FROM paciente {$query} ORDER BY pac_nom,pac_ape";
		$res = $conexion->execSelect($selPacientes);
		
		$registros=array();
		if($res["num"]>0){
			$i=0;
			while($iPaci = $conexion->fetchArray($res["result"])){
				$registros[]=array("id"=>$iPaci["id"],"text"=>utf8_encode($iPaci["nombre"]."<br />".$iPaci["mail"]));
			}
		}

		$results = array("results"=>$registros,"more"=>false);
		echo json_encode($results);
		
	break;

	case 'rt_agenda':

		$fecha_inicial = date('Y/m/d',$_POST["fechainicial"]);
		$fecha_final = date('Y/m/d',strtotime("+7 days",$_POST["fechainicial"]));

		$idDoctor = $conexion->escape($_POST["iddoctor"]);

		$selCitas = "SELECT c.cit_id AS 'id',CONCAT(p.pac_nom,' ',p.pac_ape) AS 'nombre', DATE_FORMAT(c.cit_fecha_cita,'%Y/%m/%d') AS 'fecha',
						DATE_FORMAT(c.cit_fecha_cita,'%H:%i:%s') AS 'horaC', DATE_FORMAT(c.cit_fecha_cita,'%h:%i %p') AS 'hora'
						FROM cita AS c INNER JOIN paciente AS p ON c.cit_idpac = p.pac_id
						WHERE c.cit_fecha_cita BETWEEN '{$fecha_inicial}' AND '{$fecha_final}' AND c.cit_idemp = {$idDoctor} AND c.cit_estado = 'a' ";
		
		$res = $conexion->execSelect($selCitas);
		$citas = array();

		$registros=array();
		$i=0;
		if($res["num"]>0){
			while($iCita = $conexion->fetchArray($res["result"])){

				$posicion = calcularCuadroAgenda($iCita["fecha"],$iCita["horaC"]);

				$registros[]=array(
					"id_cita"=>$iCita["id"],
					"posicion"=>$posicion["id"],
					"offset"=>$posicion["offset"],
					"texto_uno"=>utf8_encode($iCita["nombre"]),
					"texto_dos"=>strtolower($iCita["hora"])
				);
				$i++;
			}
		}

		$results = array("citas"=>$registros,"total"=>$i);
		echo json_encode($results);

	break;

	case 'rt_cita':
		if(!isset($_POST["id"])) exit();

		$id = (int)$conexion->escape($_POST["id"]);

		$selInfo = "SELECT c.cit_id AS 'id', c.cit_idemp AS 'idEm', CONCAT(e.emp_nom,' ',e.emp_ape) AS 'empleado', 
					c.cit_idpac AS 'idPa', CONCAT(p.pac_nom,' ',p.pac_ape) AS 'paciente',c.cit_com AS 'comentario',
					DATE_FORMAT(c.cit_fecha_cita,'%Y/%m/%d') AS 'fecha', DATE_FORMAT(c.cit_fecha_cita,'%d/%m/%Y') AS 'fechaF',
					DATE_FORMAT(c.cit_fecha_cita,'%h:%i %p') AS 'hora'
					FROM cita AS c INNER JOIN empleado AS e ON c.cit_idemp = e.emp_id
					INNER JOIN paciente AS p ON c.cit_idpac = p.pac_id
					WHERE c.cit_id = {$id} ";

		$res = $conexion->execSelect($selInfo);
		if($res["num"]>0){
			$iC = $conexion->fetchArray($res["result"]);
			$result = array(
				"success"=>true,
				"fechaTS"=>strtotime($iC["fecha"]),
				"fecha"=>$iC["fechaF"],
				"hora"=>$iC["hora"],
				"idPa"=>$iC["idPa"],
				"nomPa"=>utf8_encode($iC["paciente"]),
				"idEm"=>$iC["idEm"],
				"nomEm"=>utf8_encode($iC["empleado"]),
				"com"=>utf8_encode($iC["comentario"])
				);
		}else{
			$result = array("success"=>false);
		}

		echo json_encode($result);

	break;

	case 'sv_cita':
		if(!isset($_POST["idpaciente"])||!isset($_POST["hinicio"])||!isset($_POST["idempleado"])) exit();

		$tipo = ($_POST["id"]=="")?'nuevo':'editar';
		$id = (int)$conexion->escape($_POST["id"]);
		$tipo = ($id==0)?'nuevo':$tipo;

		$idPaciente = (int)$conexion->escape($_POST["idpaciente"]);
		$idEmpleado = (int)$conexion->escape($_POST["idempleado"]);
		$comentario = utf8_decode((string)$conexion->escape($_POST["comentario"]));
		$hi = ((int)$_POST["hinicio"])*60;
		//$hf = (int)$_POST["hfin"]);
		$fe = (int)$_POST["fecha"];
		if($id!=0){ 
			$tmpF = explode("/",$_POST["fechaT"]);
			$fe = strtotime($tmpF[2]."-".$tmpF[1]."-".$tmpF[0]);
		}
		//$fe = strtotime(date('Y-m-d',(int)$_POST["fecha"]));
		$fecha = date("Y-m-d H:i:s",$fe+$hi);

		$confCit = sePuedeGuardar($id,$fecha);
		if(!$confCit["result"]){
			if($confCit["tipo"]=="medio"){
				$success = array("success"=>"false","msg"=>"Ya hay citas la hora que ha seleccionado");
			}else{//fuera
				$success = array("success"=>"false","msg"=>"La hora seleccionada no es v&aacute;lida");
			}
			echo json_encode($success);
			exit();
		}

		$idSucursal = $_SESSION["idsucursal"];

		$mantoCita = "";
		if($tipo=='nuevo'){
			$mantoCita = "INSERT INTO cita(cit_idpac,cit_fecha_cita,cit_idemp,cit_com,cit_estado,cit_idsuc,cit_idslc,cit_fecha_cre) VALUES('{$idPaciente}','{$fecha}','{$idEmpleado}','{$comentario}','a','{$idSucursal}',NULL,NOW()) ";
		}else{
			$mantoCita = "UPDATE cita SET cit_idpac='{$idPaciente}',cit_idemp='{$idEmpleado}',cit_fecha_cita='{$fecha}',cit_com='{$comentario}' WHERE cit_id = {$id} ";
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

		$borrarCita = "UPDATE cita SET cit_estado = 'c' WHERE cit_id = {$id} ";
		$res = $conexion->execManto($borrarCita);
		if($res>0){
			$result = array("success"=>"true","msg"=>"La cita se ha borrado");
		}else{
			$result = array("success"=>"false","msg"=>"La cita tiene una consulta relacionada");
		}
		echo json_encode($result);
	break;

	case 'data_semanas':
		if(!isset($_POST["tipo_cambio"]) || !isset($_POST["fecha"])) exit();

		$fecha_actual = (int)$_POST["fecha"];
		$tipo = $_POST["tipo_cambio"];

		if($tipo=="data_anterior"){
			$inicial = strtotime("-7 days",$fecha_actual);
		}elseif($tipo=="data_siguiente"){
			$inicial = strtotime("+7 days",$fecha_actual);
		}else{
			$inicial = $fecha_actual;
		}
		$numSemana = date("W",$inicial);
		$actual = $inicial;
		$dias = array();
		$abreviatura_inicial=$abreviatura_final="";
		for($i=1;$i<=7;$i++){

			$diaI = date("d",$actual);
			$mesI = date("m",$actual);
			if($i==1) $abreviatura_inicial = "{$diaI}/{$mesI}";
			if($i==7) $abreviatura_final = "{$diaI}/{$mesI}";

			$nomDiaI = $arrayDias[date("N",$actual)];
			$dias[]=$nomDiaI." ".date("d/m",$actual);
			$actual = strtotime("+1 day",$actual);
		}

		$textoInfo = "Semana {$numSemana}: {$abreviatura_inicial} - {$abreviatura_final}";

		$response = array("primerDia"=>$inicial,"numSemana"=>$numSemana,"textoInfo"=>$textoInfo,"dias"=>$dias);
		echo json_encode($response);

	break;


}



function calcularCuadroAgenda($fecha,$hora){
	global $minutos_citas,$hora_inicio,$hora_fin;
	$hi = strtotime(date("Y-m-d")." ".date("H:i",$hora_inicio));
	$hf = strtotime(date("Y-m-d")." ".date("H:i",$hora_fin));
	$hc = strtotime(date("Y-m-d")." ".$hora);
	$hMaximo = entero(($hf-$hi)/($minutos_citas*60));

	$diff = $hc-$hi;
	$posh = $offset = 0;
	if($diff<=0){ $posh = 0; }
	elseif($diff>=($hf-$hi)){ $posh=$hMaximo; }
	else{ 
		$tmpN = ($diff/($minutos_citas*60));
		$posh = entero($tmpN);
		$offset = entero(43*($tmpN-$posh));
	}
	

	$posd = date("N",strtotime($fecha));

	$id = "h_{$posh}_d_{$posd}";
	return array("id"=>$id,"offset"=>$offset);
}

function entero($n){
	$nTmp = (string)$n;
	if($nTmp=="") return 0;
	if(strstr($nTmp,".") === false) return (int)$n;
	$nE = explode(".",$n);
	return (int)$nE[0];
}

function sePuedeGuardar($id,$hora){
	global $conexion,$minutos_citas,$hora_inicio,$hora_fin;

	
	$hi = strtotime(date("Y-m-d")." ".date("H:i:s",$hora_inicio));
	$fe = strtotime(date("Y-m-d")." ".date("H:i:s",strtotime($hora)));
	$hf = strtotime(date("Y-m-d")." ".date("H:i:s",$hora_fin));

	if($fe<$hi){ return array("result"=>false,"tipo"=>"fuera"); }
	if(($fe+($minutos_citas*60))>$hf){ return array("result"=>false,"tipo"=>"fuera"); }
	


	$fecha1 = date('Y-m-d H:i:s',strtotime("-{$minutos_citas} minutes",strtotime($hora)));
	$fecha2 = date('Y-m-d H:i:s',strtotime("+{$minutos_citas} minutes",strtotime($hora)));
	$selH = "SELECT COUNT(cit_id) AS 'total' FROM cita WHERE cit_id <> {$id} AND cit_fecha_cita > '{$fecha1}' AND cit_fecha_cita < '{$fecha2}' ";
	$resH = $conexion->execSelect($selH);
	$iH = $conexion->fetchArray($resH["result"]);

	if($iH["total"]!="0"){
		return array("result"=>false,"tipo"=>"medio");
	}

	return array("result"=>true,"tipo"=>"valido");
}

?>