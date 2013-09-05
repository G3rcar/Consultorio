<?
include("sesion.php");
//- Incluimos la clase de conexion e instanciamos del objeto principal
include_once("libs/php/class.connection.php");


//- Hacerlo hasta el final de cada codigo embebido; incluye el head, css y el menu
include("encabezado.php");

?>


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




<? include('piepagina.php'); ?>

