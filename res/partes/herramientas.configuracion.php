<div class="well sidebar-nav">
	<img id="progressBar_main" src="res/img/loading.gif" class="loading_indicator_mannto" />
	<ul class="nav nav-list">
		<li class="nav-header">Opciones</li>
		<?php 
		if(!$botones_configuracion["configuracion"]){ 
		//Si no esta en la pagina de configuracion se muestran los botones de agregar y borrar 
		?> <!--****Aqui estan los botones de agregar, borrar y guardar en el menu de configuraciones**** -->
		<li><a id="lnkAgregar" href="#"><i class="icon-plus"></i> Agregar</a></li>
		<li><a id="lnkBorrar" href="#"><i class="icon-remove"></i> Borrar</a></li>
		<?php 
		}else{
		//Si esta en configuracion, se cambiara el listado de opciones 
		?>
		<li><a id="lnkGuardar" href="#"><i class="icon-hdd"></i> Guardar</a></li>
		<?php } ?>
		
		<li class="nav-header">Cat&aacute;logos</li>  <!--***Link del catalogo de las configuraciones****-->
		<li <?php echo ($botones_configuracion["configuracion"]?'class="active" ':''); ?> ><a href="configuracion.php">Configuracion General</a></li>
		<li <?php echo ($botones_configuracion["cargos"]?'class="active" ':''); ?> ><a href="cargos.php">Cargos</a></li>
		<li <?php echo ($botones_configuracion["roles"]?'class="active" ':''); ?> ><a href="roles.php">Roles</a></li>
		<li <?php echo ($botones_configuracion["empleados"]?'class="active" ':''); ?> ><a href="empleados.php">Empleados/Usuarios</a></li>
		<hr />
		<li <?php echo ($botones_configuracion["productos"]?'class="active" ':''); ?> ><a href="productos.php">Producto/Servicios</a></li>
		<li <?php echo ($botones_configuracion["proveedores"]?'class="active" ':''); ?> ><a href="proveedores.php">Proveedores</a></li>
	</ul>
</div>