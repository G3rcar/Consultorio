<?php
include("sesion.back.php");


//- Incluimos la clase de conexion e instanciamos del objeto principal
include_once("../libs/php/class.connection.php");
include_once("../libs/php/class.objetos.base.php");
$conexion = new Conexion();

$minutos_citas = 40;
$hora_inicio = 1379854800;
$hora_fin = 1379887200;

$data = new Configuracion();

//- Si la variable action no viene se detenemos la ejecucion
if(!isset($_POST["action"])){ exit(); }

$accion = $_POST["action"];

switch ($accion) {

	case 'sv_conf':
		if(
			!isset($_POST["empresa"])||
			!isset($_POST["sistema"])||
			!isset($_POST["duracion"])||
			!isset($_POST["hinicio"])||
			!isset($_POST["hfin"])
		) exit();

		$fe = strtotime(date('Y-m-d'));
		$hi = $fe+(((int)$_POST["hinicio"])*60);
		$hf = $fe+(((int)$_POST["hfin"])*60	);

		$conf = array(
			"nombreEmpresa"=>htmlentities($_POST["empresa"]),
			"nombreSistema"=>htmlentities($_POST["sistema"]),
			"horaInicio"=>$hi,
			"horaFin"=>$hf,
			"duracion"=>((int)$_POST["duracion"])
		);

		$data->guardarConfiguracion($conf);

		$success = array("success"=>"true","msg"=>"La configuracion se ha guardado");
		echo json_encode($success);


	break;

}



function calcularCuadroAgenda($fecha,$hora){
	global $minutos_citas,$hora_inicio,$hora_fin;
	$hi = strtotime(date("Y-m-d")." ".date("H:i",$hora_inicio));
	$hf = strtotime(date("Y-m-d")." ".date("H:i",$hora_fin));
	$hc = strtotime(date("Y-m-d")." ".$hora);
	$hMaximo = entero(($hf-$hi)/($minutos_citas*60));

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