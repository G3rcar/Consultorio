<div class="navbar navbar-inverse navbar-fixed-top">
	<div class="navbar-inner">
		<div class="container">
			<a class="brand" href="./"><?php echo $conf["nombreSistema"]; ?></a>
			<ul class="nav pull-right">
				<li> <a href="#"> <i class="icon-question-sign icon-white"> </i> </a> </li>
				
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<i class="icon-user icon-white"></i> <b class="caret"></b>
					</a>
					<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu">
						<li class="disabled"><a tabindex="-1" class="username"> <?php echo utf8_encode($_SESSION["nombre"]); ?> </a></li>
						<li class="divider"></li>
						<li><a tabindex="-1" href="cuenta.php"><i class="icon-wrench"></i> Cuenta</a></li>
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
						<li><a tabindex="-1" href="paises.php">Paises</a></li>
						<li><a tabindex="-1" href="departamentos.php">Departamentos</a></li>
						<li><a tabindex="-1" href="municipios.php">Municipios</a></li>
						<li><a tabindex="-1" href="sucursales.php">Sucursales</a></li>
						<li class="divider"></li>
						<li><a tabindex="-1" href="documentos.php">Tipos de documentos</a></li>
						<!--<li><a tabindex="-1" href="movimientos.php">Tipos de movimientos</a></li>-->
						<li><a tabindex="-1" href="tipos.sangre.php">Tipos de sangre</a></li>
					</ul>
				</li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						Configuraci&oacute;n
						<b class="caret"></b>
					</a>
					<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu">
						<li><a tabindex="-1" href="configuracion.php">Configuraciones globales</a></li>
						<li><a tabindex="-1" href="cargos.php">Cargos</a></li>
						<!-- <li><a tabindex="-1" href="roles.php">Roles</a></li> -->
						<li><a tabindex="-1" href="empleados.php">Empleados/Usuarios</a></li>
						<li class="divider"></li>
						<li><a tabindex="-1" href="productos.php">Productos/Servicios</a></li>
						<li><a tabindex="-1" href="proveedores.php">Proveedores</a></li>
					</ul>
				</li>
				<li <?php echo ($botones_menu["citas"]?'class="active" ':''); ?> > <a href="agenda.php">Agenda</a> </li>
				<li <?php echo ($botones_menu["consultas"]?'class="active" ':''); ?> > <a href="consultas.php">Consultas</a> </li>
				<li <?php echo ($botones_menu["pacientes"]?'class="active" ':''); ?> > <a href="pacientes.php">Pacientes</a> </li>
				<li <?php echo ($botones_menu["facturas"]?'class="active" ':''); ?> > <a href="facturas.php">Facturas</a> </li>
				<li <?php echo ($botones_menu["reportes"]?'class="active" ':''); ?> > <a href="reportes.php">Reportes</a> </li>
			</ul>
		</div>
	</div>
</div>