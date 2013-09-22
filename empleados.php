<html lang="es">
<head>
  <meta charset="utf-8" />
  <title>Empleados</title>
  <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
  <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
  <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
  <script>
  $(function() {
    $( "#datepicker" ).datepicker();
  });
  </script>
  

</head>
        <!-- Agregar vvdsfdsdtgerd -->
	<div id="AgregarEmpleado" class="modal hide fade modalPequena" tabindex="-1" role="dialog" aria-labelledby="AgregarEmpl" aria-hidden="true">
		
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 id="modalHead">Agregar empleado</h3>
		</div>
		<div class="modal-body">
			<form>
				<fieldset>
                                        <label id="codigoEmpl_label" class="requerido">Codigo</label>
					<input id="codigoEmpl" type="text" min-length="2" class="input-block-level" placeholder="Escribir..." >                        
					<label id="nombreEmpl_label" class="requerido">Nombre</label>
					<input id="nombreEmpl" type="text" min-length="2" class="input-block-level" placeholder="Escribir..." >
                                        <label id="apellidoEmpl_label" class="requerido">Apellidos</label>
					<input id="apellidoEmpl" type="text" min-length="2" class="input-block-level" placeholder="Escribir..." >
                                        <label id="fechaEmpl_label" class="requerido">Fecha de Nacimiento</label>
					<input id="datepicker" type="text" min-length="2" class="input-block-level" placeholder="Seleccionar..." >
				</fieldset>
			</form>
		<div class="modal-footer">
			<button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
			<button id="guardarEmpl" class="btn btn-primary">Guardar</button>
		</div>
	</div>    