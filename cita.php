<html>
<body>
<?php
$link = mysql_connect("localhost","root");
mysql_selct_db("mydb",$link);
$result = mysql_query("SELECT * FROM cita", $link);
echo "nombre:".mysql_result($result, o, "nombre");
?>

</body>
	</html>