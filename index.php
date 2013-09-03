<?


?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<title>Consultorio M&eacute;dico Cerna y Alvarado</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="Proyecto ASI 2">
	<meta name="author" content="@G3rcar">

	<link href="res/css/bootstrap/css/bootstrap.css" rel="stylesheet">
	<link href="res/css/bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
	<link href="res/css/agenda.css" rel="stylesheet">

	<!-- Fav and touch icons -->
	<link rel="shortcut icon" href="res/img/favicon.png">
	<style type="text/css">
		.cs_superior{
			margin-top:2px;
		}

	</style>
</head>

<body>

	<div class="container">
    
    	<div class="navbar cs_superior">
    		<div class="navbar-inner">
    			<a class="brand" href="#">Cerna y Alvarado</a>
    			<ul class="nav pull-right">
    				<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							Gerardo Calder&oacute;n <b class="caret"></b>
						</a>
						<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu">
							<li><a tabindex="-1" href="#">Cuenta</a></li>
							<li class="divider"></li>
							<li><a tabindex="-1" href="#">Salir</a></li>
						</ul>
					</li>

    				<a href="#" class="navbar-link"></a>
    			</ul>
			    <ul class="nav">
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							Catalogos
							<b class="caret"></b>
						</a>
						<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu">
							<li><a tabindex="-1" href="#">Departamentos</a></li>
							<li><a tabindex="-1" href="#">Municipios</a></li>
							<li><a tabindex="-1" href="#">Productos</a></li>
							<li><a tabindex="-1" href="#">Proveedores</a></li>
							<li><a tabindex="-1" href="#">Empleados/Usuarios</a></li>
						</ul>
					</li>
					<li class="active"> <a href="#">Agenda de citas</a> </li>
					<li> <a href="#">Medicinas</a> </li>
					<li> <a href="#">Pacientes</a> </li>
				</ul>
			</div>
		</div>




		<!-- Agenda -->

		<table class="calendar table table-bordered">
		    <thead>
		        <tr>
		            <th>&nbsp;</th>
		            <th width="14%">Domingo</th>
		            <th width="14%">Lunes</th>
		            <th width="15%">Martes</th>
		            <th width="14%">Mi&eacute;rcoles</th>
		            <th width="15%">Jueves</th>
		            <th width="14%">Viernes</th>
		            <th width="14%">S&aacute;bado</th>
		        </tr>
		    </thead>
		    <tbody>
		        <tr>
		            <td>08:00</td>
					<td class=" no-events" rowspan="1"></td>
					<td class=" no-events" rowspan="1"></td>
					<td class=" no-events" rowspan="1"></td>
					<td class=" no-events" rowspan="1"></td>
					<td class=" no-events" rowspan="1"></td>
					<td class=" no-events" rowspan="1"></td>
					<td class=" no-events" rowspan="1"></td>
		        </tr>
		        <tr>
					<td>08:30</td>
					<td class=" no-events" rowspan="1"></td>
					<td class=" no-events" rowspan="1"></td>
					<td class=" no-events" rowspan="1"></td>
					<td class=" no-events" rowspan="1"></td>
					<td class=" no-events" rowspan="1"></td>
					<td class=" no-events" rowspan="1"></td>
					<td class=" no-events" rowspan="1"></td>
				</tr>
				<tr>
		        	<td>09:00</td>
					<td class=" no-events" rowspan="1"></td>
					<td class=" no-events" rowspan="1"></td>
					<td class=" no-events" rowspan="1"></td>
					<td class=" no-events" rowspan="1"></td>
					<td class=" no-events" rowspan="1"></td>
					<td class=" no-events" rowspan="1"></td>
					<td class=" no-events" rowspan="1"></td>
		        </tr>
		        <tr>
		            <td>09:30</td>
					<td class=" no-events" rowspan="1"></td>
					<td class=" no-events" rowspan="1"></td>
					<td class=" no-events" rowspan="1"></td>
					<td class=" no-events" rowspan="1"></td>
					<td class=" no-events" rowspan="1"></td>
					<td class=" no-events" rowspan="1"></td>
					<td class=" no-events" rowspan="1"></td>
		        </tr>
		        <tr>
		            <td>10:00</td>
					<td class=" has-events" rowspan="4">
						<div class="row-fluid practice" style="width: 99%; height: 100%;">
							<span class="title">Cita con Juan P&eacute;rez</span> 
							<span class="lecturer">Doc. Cerna</span>
						</div>
					</td>

					<td class=" has-events" rowspan="4">
						<div class="row-fluid lecture" style="width: 99%; height: 100%;">
							<span class="title">Cita con Manuel Mercadillo</span> 
							<span class="lecturer">Doc. Alvarado</span>
						</div>
					</td>
					<td class=" no-events" rowspan="1"></td>
					<td class=" has-events" rowspan="4">
						<div class="row-fluid practice" style="width: 99%; height: 100%;">
							<span class="title">Cita con Julia Marroqu&iacute;n</span> 
							<span class="lecturer">Doc. Cerna</span>
						</div>
					</td>
					<td class=" no-events" rowspan="1"></td>
					<td class=" no-events" rowspan="1"></td>
					<td class=" no-events" rowspan="1"></td>
				</tr>
				<tr>
					<td>10:30</td>
					<td class=" no-events" rowspan="1"></td>
					<td class=" no-events" rowspan="1"></td>
					<td class=" no-events" rowspan="1"></td>
					<td class=" no-events" rowspan="1"></td>
				</tr>
				<tr>
					<td>11:00</td>
					<td class=" no-events" rowspan="1"></td>
					<td class=" no-events" rowspan="1"></td>
					<td class=" no-events" rowspan="1"></td>
					<td class=" no-events" rowspan="1"></td>
				</tr>
				<tr>
					<td>11:30</td>
					<td class=" no-events" rowspan="1"></td>
					<td class=" no-events" rowspan="1"></td>
					<td class=" no-events" rowspan="1"></td>
					<td class=" no-events" rowspan="1"></td>
				</tr>
				<tr>
					<td>12:00</td>
					<td class=" no-events" rowspan="1"></td>
					<td class=" has-events conflicts " rowspan="4">
						<div class="row-fluid practice" style="width: 49%; height: 100%;">
							<span class="title">Cita con Mar&iacute;a Alvarenga</span> 
							<span class="lecturer">Doc. Cerna</span>
						</div>
						<div class="row-fluid lecture" style="width: 49%; height: 100%;">
							<span class="title">Cita con Rita L&oacute;pez</span>
							<span class="lecturer">Doc. Alvarado</span>
						</div>
					</td>
					<td class=" no-events" rowspan="1"></td>
					<td class=" has-events" rowspan="4">
						<div class="row-fluid lecture" style="width: 99%; height: 100%;">
							<span class="title">Cita con Jorge Camacho</span> 
							<span class="lecturer">Doc. Alvarado</span>
						</div>
					</td>
					<td class=" no-events" rowspan="1"></td>
					<td class=" no-events" rowspan="1"></td>
					<td class=" no-events" rowspan="1"></td>
				</tr>
				<tr>
					<td>12:30</td>
					<td class=" no-events" rowspan="1"></td>
					<td class=" no-events" rowspan="1"></td>
					<td class=" no-events" rowspan="1"></td>
					<td class=" no-events" rowspan="1"></td>
					<td class=" no-events" rowspan="1"></td>
				</tr>
				<tr>
					<td>13:00</td>
					<td class=" no-events" rowspan="1"></td>
					<td class=" no-events" rowspan="1"></td>
					<td class=" no-events" rowspan="1"></td>
					<td class=" no-events" rowspan="1"></td>
					<td class=" no-events" rowspan="1"></td>
				</tr>
				<tr>
					<td>13:30</td>
					<td class=" no-events" rowspan="1"></td>
					<td class=" no-events" rowspan="1"></td>
					<td class=" no-events" rowspan="1"></td>
					<td class=" no-events" rowspan="1"></td>
					<td class=" no-events" rowspan="1"></td>
				</tr>
				<tr>
					<td>14:00</td>
					<td class=" no-events" rowspan="1"></td>
					<td class=" no-events" rowspan="1"></td>
					<td class=" has-events" rowspan="4">
						<div class="row-fluid lecture" style="width: 99%; height: 100%;">
							<span class="title">Data Structures</span> 
							<span class="lecturer">Doc. Alvarado</span>
						</div>
					</td>
					<td class=" no-events" rowspan="1"></td>
					<td class=" has-events" rowspan="6">
						<div class="row-fluid lecture" style="width: 99%; height: 100%;">
							<span class="title">Cita con Luis Mej&iacute;a</span> 
							<span class="lecturer">Dr. Alvarado</span>
						</div>
					</td>
					<td class=" no-events" rowspan="1"></td>
					<td class=" no-events" rowspan="1"></td>
				</tr>
				<tr>
					<td>14:30</td>
					<td class=" no-events" rowspan="1"></td>
					<td class=" no-events" rowspan="1"></td>
					<td class=" no-events" rowspan="1"></td>
					<td class=" no-events" rowspan="1"></td>
					<td class=" no-events" rowspan="1"></td>
				</tr>
				<tr>
					<td>15:00</td>
					<td class=" no-events" rowspan="1"></td>
					<td class=" no-events" rowspan="1"></td>
					<td class=" no-events" rowspan="1"></td>
					<td class=" no-events" rowspan="1"></td>
					<td class=" no-events" rowspan="1"></td>
				</tr>
				<tr>
					<td>15:30</td>
					<td class=" no-events" rowspan="1"></td>
					<td class=" no-events" rowspan="1"></td>
					<td class=" no-events" rowspan="1"></td>
					<td class=" no-events" rowspan="1"></td>
					<td class=" no-events" rowspan="1"></td>
				</tr>
				<tr>
					<td>16:00</td>
					<td class=" has-events" rowspan="4">
						<div class="row-fluid practice" style="width: 99%; height: 100%;">
							<span class="title">Cita con Carlos Carrillo</span> 
							<span class="lecturer">Dr. Cerna</span>
						</div>
					</td>
					<td class=" has-events" rowspan="4">
						<div class="row-fluid lecture" style="width: 99%; height: 100%;">
							<span class="title">Cita con Joel Mart&iacute;nez</span> 
							<span class="lecturer">Dr. Alvarado</span>
						</div>
					</td>
					<td class=" has-events" rowspan="4">
						<div class="row-fluid practice" style="width: 99%; height: 100%;">
							<span class="title">Cita con Omar Lemus</span>
							<span class="lecturer">Dr. Cerna</span>
						</div>
					</td>
					<td class=" has-events" rowspan="4">
						<div class="row-fluid practice" style="width: 99%; height: 100%;">
							<span class="title">Cita con Jos&eacute; Aguilar</span> 
							<span class="lecturer">Dr. Cerna</span>
						</div>
					</td>
					<td class=" no-events" rowspan="1"></td>
					<td class=" no-events" rowspan="1"></td>
				</tr>
				<tr>
					<td>16:30</td>
					<td class=" no-events" rowspan="1"></td>
					<td class=" no-events" rowspan="1"></td>
				</tr>
				<tr>
					<td>17:00</td>
					<td class=" no-events" rowspan="1"></td>
					<td class=" no-events" rowspan="1"></td>
					<td class=" no-events" rowspan="1"></td>
				</tr>
				<tr>
					<td>17:30</td>
					<td class=" no-events" rowspan="1"></td>
					<td class=" no-events" rowspan="1"></td>
					<td class=" no-events" rowspan="1"></td>
				</tr>
				<tr>
					<td>18:00</td>
					<td class=" no-events" rowspan="1"></td>
					<td class=" no-events" rowspan="1"></td>
					<td class=" no-events" rowspan="1"></td>
					<td class=" no-events" rowspan="1"></td>
					<td class=" no-events" rowspan="1"></td>
					<td class=" no-events" rowspan="1"></td>
					<td class=" no-events" rowspan="1"></td>
				</tr>
				<tr>
					<td>18:30</td>
					<td class=" no-events" rowspan="1"></td>
					<td class=" no-events" rowspan="1"></td>
					<td class=" no-events" rowspan="1"></td>
					<td class=" no-events" rowspan="1"></td>
					<td class=" no-events" rowspan="1"></td>
					<td class=" no-events" rowspan="1"></td>
					<td class=" no-events" rowspan="1"></td>
				</tr>
				<tr>
					<td>19:00</td>
					<td class=" no-events" rowspan="1"></td>
					<td class=" no-events" rowspan="1"></td>
					<td class=" no-events" rowspan="1"></td>
					<td class=" no-events" rowspan="1"></td>
					<td class=" no-events" rowspan="1"></td>
					<td class=" no-events" rowspan="1"></td>
					<td class=" no-events" rowspan="1"></td>
				</tr>
				<tr>
					<td>19:30</td>
					<td class=" no-events" rowspan="1"></td>
					<td class=" no-events" rowspan="1"></td>
					<td class=" no-events" rowspan="1"></td>
					<td class=" no-events" rowspan="1"></td>
					<td class=" no-events" rowspan="1"></td>
					<td class=" no-events" rowspan="1"></td>
					<td class=" no-events" rowspan="1"></td>
				</tr>
			</tbody>
		</table>

		<br />
		<br />
		<br />
	</div>

	<!-- javascript
	================================================== -->
	<!-- al final para que la pagina cargue rapido -->
	<script type="text/javascript" src="libs/js/jquery-1.10.2.min.js"></script>
	<script type="text/javascript" src="libs/js/bootstrap/bootstrap-alert.js"></script>
	<script type="text/javascript" src="libs/js/bootstrap/bootstrap-dropdown.js"></script>

    
</body>
</html>








