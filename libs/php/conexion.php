<?


//===================Conexion====================

$server="localhost";
$user="root";
$password="";
$bd="consultorio";


$conexion = mysqli_connect($server,$user,$password);
mysqli_select_db($bd,$conexion)


?>