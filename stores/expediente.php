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

	case 'sv_expe':
		if(
			!isset($_POST["nombre"])||
			!isset($_POST["apellido"])||
			!isset($_POST["fecha_nac"])||
			!isset($_POST["peso"])||
			!isset($_POST["altura"])||
			!isset($_POST["alergias"])||
			!isset($_POST["direccion"])||
			!isset($_POST["direccion"])||
			!isset($_POST["correo"])||
			!isset($_POST["telcel"])||
			!isset($_POST["fecha_cre"])||
			
		) exit();

		

	
		);

		$data->guardarConfiguracion($conf);

		$success = array("success"=>"true","msg"=>"La configuracion se ha guardado");
		echo json_encode($success);


	break;

}
 
?>