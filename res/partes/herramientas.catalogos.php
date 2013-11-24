<div class="well sidebar-nav">
	<img id="progressBar_main" src="res/img/loading.gif" class="loading_indicator_mannto" />
	<ul class="nav nav-list">
		<li class="nav-header">Opciones</li>
		<li><a id="lnkAgregar" href="#"><i class="icon-plus"></i> Agregar</a></li>
		<li><a id="lnkBorrar" href="#"><i class="icon-remove"></i> Borrar</a></li>
		
		<li class="nav-header">Cat&aacute;logos</li>
		<li <?php echo ($botones_herramientas["paises"]?'class="active" ':''); ?> ><a href="paises.php">Paises</a></li>
		<li <?php echo ($botones_herramientas["departamentos"]?'class="active" ':''); ?> ><a href="departamentos.php">Departamentos</a></li>
		<li <?php echo ($botones_herramientas["municipios"]?'class="active" ':''); ?> ><a href="municipios.php">Municipios</a></li>
		<li <?php echo ($botones_herramientas["sucursales"]?'class="active" ':''); ?> ><a href="sucursales.php">Sucursales</a></li>
		<hr />
		<li <?php echo ($botones_herramientas["documentos"]?'class="active" ':''); ?> ><a href="documentos.php">Tipos de documento</a></li>
		<!--<li <?php echo ($botones_herramientas["movimientos"]?'class="active" ':''); ?> ><a href="movimientos.php">Tipos de movimiento</a></li>-->
		<li <?php echo ($botones_herramientas["tiposangre"]?'class="active" ':''); ?> ><a href="tipos.sangre.php">Tipos de sangre</a></li>
	</ul>
</div>