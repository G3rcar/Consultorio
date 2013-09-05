<?

if(!isset($_SESSION)){ session_start(); }

if($_SESSION["iduser"]==""){ header("Location: login.php"); exit(); }

include('libs/php/constantes.php');

?>