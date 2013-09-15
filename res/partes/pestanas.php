<div class="navbar navbar-inverse navbar-fixed-top">
	<div class="navbar-inner">
		<div class="container">
			<a class="brand" href="#">Cerna y Alvarado</a>
			<ul class="nav pull-right">
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<?=$_SESSION["user"]?> <b class="caret"></b>
					</a>
					<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu">
						<li><a tabindex="-1" href="cuenta.php"><i class="icon-user"></i> Cuenta</a></li>
						<li class="divider"></li>
						<li><a tabindex="-1" href="logout.php"><i class="icon-off"></i> Salir</a></li>
					</ul>
				</li>

				<a href="#" class="navbar-link"></a>
			</ul>
		    <ul class="nav">
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						Cat&aacute;logos
						<b class="caret"></b>
					</a>
					<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu">
						<li><a tabindex="-1" href="departamentos.php">Departamentos</a></li>
						<li><a tabindex="-1" href="municipios.php">Municipios</a></li>
						<li><a tabindex="-1" href="productos.php">Productos</a></li>
						<li><a tabindex="-1" href="proveedores.php">Proveedores</a></li>
						<li><a tabindex="-1" href="usuarios.php">Empleados/Usuarios</a></li>
					</ul>
				</li>
				<li <?=($botones_menu["citas"]?'class="active" ':'')?> > <a href="agenda.php">Agenda de citas</a> </li>
				<li <?=($botones_menu["medicinas"]?'class="active" ':'')?> > <a href="medicinas.php">Medicinas</a> </li>
				<li <?=($botones_menu["pacientes"]?'class="active" ':'')?> > <a href="pacientes.php">Pacientes</a> </li>
			</ul>
		</div>
	</div>
</div>