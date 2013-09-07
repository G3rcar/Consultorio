<?

if(!isset($_SESSION)){ session_start(); }
if($_SESSION["iduser"]==""){ header("Location: login.php"); exit(); }

$botones_menu = array("citas"=>false,"medicinas"=>false,"pacientes"=>false,"limpio"=>false);
include('libs/php/constantes.php');

?>