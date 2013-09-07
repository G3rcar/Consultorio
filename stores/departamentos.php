<?
include("sesionBack.php");

//- Incluimos la clase de conexion e instanciamos del objeto principal
include_once("../libs/php/class.connection.php");
$conexion = new Conexion();


//- Si la variable action no viene se detenemos la ejecucion
if(!isset($_POST["action"])){ exit(); }

$accion = $_POST["action"];

switch ($accion) {
	case 'gd_depto':
		$selDeptos = "SELECT id,nombre,DATE_FORMAT(creacion,'%d/%m/%Y %h:%i %p') AS 'creacion' FROM departamento ORDER BY id ";
		$res = $conexion->execSelect($selDeptos);
		$html = '<table class="table table-bordered table-striped table-hover">
					<thead><tr>
						<th width="20"><input type="checkbox" /> </th>
						<th width="20">#</th>
						<th>Nombre</th>
						<th width="200">Fecha de creaci&oacute;n</th>
					</tr></thead><tbody>';

		if($res["num"]>0){
			$i=0;
			while($iDepto = $conexion->fetchArray($res["result"])){
				$i++;
				$html .= '<tr><td><input type="checkbox" /></td>
							<td>'.$i.'</td> <td>'.$iDepto["nombre"].'</td> <td>'.$iDepto["creacion"].'</td> </tr>';
			}
		}

		$html .= '</tbody></table>';

		echo $html;
		
	break;

	case 'nv_depto':
		if(!isset($_POST["nombre"])) exit();

		$nombre = $conexion->escape($_POST["nombre"]);
		$nuevoDepto = "INSERT INTO departamento(nombre,creacion) VALUES('{$nombre}',NOW()) ";
		
		$res = 0;
		$res = $conexion->execManto($nuevoDepto);

		if($res>0){
			$success = array("success"=>"true","msg"=>"El departamento se ha guardado");
		}else{
			$success = array("success"=>"false","msg"=>"Ha ocurrido un error");
		}
		echo json_encode($success);

	break;
}


?>