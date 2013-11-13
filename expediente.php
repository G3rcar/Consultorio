<?php
include("sesion.php");
//- Incluimos la clase de conexion e instanciamos del objeto principal
include_once("libs/php/class.connection.php");



$botones_menu["limpio"]=true;
$botones_herramientas["pacientes"]=true;
$consulta="SELECT pac_id,pac_nom FROM paciente ORDER BY pac_id ASC ";
$result=mysql_query($consulta);

//- Hacerlo hasta el final de cada codigo embebido; incluye el head, css y el menu
include("res/partes/encabezado.php");

?>
<!-- Estilo extra -->
<style>
.sidebar-nav { padding: 9px 0; }
.headGrid{
	background-color: #33b5e5;
}
.headGrid th{
	color: #FFFFFF;
}

</style>
<link href="res/css/select2/select2.css" rel="stylesheet"/>
<!-- /Estilo extra -->

<!-- Scripts extra -->
<script type="text/javascript" src="libs/js/select2/select2.js"></script>
<script type="text/javascript" src="libs/js/select2/select2_locale_es.js"></script>
<script type="text/javascript" src="libs/js/custom/objetos-comunes.js"></script>

<h3> Expediente </h3>
<div class="container-fluid">
		<div class="row-fluid">
			
			<!-- Columna fluida con peso 3/12 -->
			<div class="span3">
				<?php include_once('res/partes/herramientas.formularios.php'); ?>
			</div>
			<!-- /Columna fluida con peso 3/12 -->

			
			<div class="span9">
			
				<form id="frmPaciente">
					<label>Nombres</label> 
					<input id="txtNompaciente" type="text" placeholder="Escriba el nombre" style="width:70%;">

					<!--<input type="text" name="pac_nom" class="span8"><br>-->
                    <label>Apellidos</label>
					<input id="txtApellidoPac" type="text" placeholder="Escriba el Apellido" style="width:70%;" >
	                <label>Fecha de Nacimiento</label>
					<input type="date" id="pac_fecha_nac" >

					 <fieldset>
					 <div class="span5">
					<label>Peso</label>
					<input id="txtPesopac" type="text" placeholder="Escriba el peso" ><br>
					</div>
					<div class="span5">
					<label>Altura</label>
					<input id="txtAltpac" type="text" placeholder="Escriba la altura"  >
				    </div>
					</fieldset>
				
					
					<label>Alergias</label>
  					<textarea rows="3"  name="alergiaspac" cols= 50 class="span9" placeholder="Escriba Alergias" ></textarea>

  				   
                    <label>Genero</label>
                    <input type="radio" id="pac_gen" value="masculino" > Masculino 
					<input type="radio" id="pac_gen" value="femenino" >  Femenino <br>
  					<br>
  					
  				  <!--<label>Pais</label>-->
  				  	<fieldset>
	  				  <div class="span5">
	  				  <label>Pais</label>
					  <select >
					  <option>El Salvador </option>
					  <option>Hondura</option>
					  <option>Costa Rica</option>
					  <option>Panama</option>
					  <option>Estados Unidos</option>
					</select>
					</div>

					<div calss="span5">
					<label>Municipio</label>
					<select>
					<option>Mejicanos</option>
					<option>Ayutuxtepeque</option>
			    	</select>
					</div>
					</fieldset>

					<label>Dirección</label>
				    <textarea rows="3" id="dirpac" cols= 50 class="span9" placeholder="Escriba la direccion" value="<?php echo $conf["direccionPaciente"]; ?>"></textarea><br>
				  
				    <fieldset>
                    <div class="span5">
                    <label>DuI</lavel>
                    <input id="txtDui" type="text" placeholder="Escriba el DUI" ><br>
                    </div>
                    <div class="span5">
                    <label>NIT</label>
                    <input id="txtNit" type="text" placeholder="Escriba el NIT" ><br>
                	</div>
				    </fieldset>



					<label>Correo Electronico</label> 	
					<input id="txtcorreo" type="text" placeholder="e-mail@ejemplo.com" value="<?php echo $conf["correoPaciente"]; ?>">
  					<fieldset>
  					<div class="span5">
  				 	 <label>Telefono Casa</label>
  				 	<input id="txtTelpac" type="text" placeholder="Escriba el telefono" value="<?php echo $conf["telefonoCasa"]; ?>" >
					</div>
					<div class="span5">
                 	 <label>Telefono Celular</label>
			     	<input id="txtCelc" type="text" placeholder="Escriba el telefono" value="<?php echo $conf["telefonocel"]; ?>">
		          	 </select>
  				  	</div>
  				  	</fieldset>
					
				<div calss="span5">
  				  	<label>Fecha de Creación Expediente</label>
					<input type="date" id="pac_fecha_cre" value="<?php echo $conf["fecha_cre"]; ?>">
					</div>

				
					</div>



	<script>
		$(document).ready(function(){
			$('#lnkGuardar').click(function(){ manto.guardar(); });
			$('#lnkCancelar').attr('href','pacientes.php');
			$('#lnkLimpiar').click(function(){
				document.getElementById('frmPaciente').reset();
			});
		});

		var mantoPaciente = {

			estado:'agregar',
			
			validarForm:function(){
				var errores=0;
				var iv1 = $('#txtNompaciente').val();
				var iv2 = $('txtApellidoPac').val();
				var iv3 = $('#date').val();
				var iv4 = $('#txtPesopac').val();
				var iv5 = $('#txtAltpac').val();
				var iv6 = $('#alergiaspac').val();
				var iv7 = $('#dirpac').val();
				var iv8 = $('#txtTelpac').val();
				

				if(iv1==''){ $('#txtNompaciente').addClass('error_requerido'); errores++; }
				if(iv2==''){ $('txtApellidoPac').addClass('error_requerido'); errores++; }
				if(iv3==''){ $('#date').addClass('error_requerido'); errores++; }
				if(iv4==''){ $('#txtPesopac').addClass('error_requerido'); errores++; }
				if(iv5==''){ $('#txtAltpac').addClass('error_requerido'); errores++; }
				if(iv6==''){ $('#alergiaspac').addClass('error_requerido'); errores++; }
				if(iv7==''){ $('#dirpac').addClass('error_requerido'); errores++; }
				if(iv8==''){ $('#txtTelpac').addClass('error_requerido'); errores++; }

			

				if(iv1.length>50){ $('#txtNompaciente').addClass('error_requerido').attr('title','No debe sobrepasar de 50 caracteres'); errores++; }
				if(iv2.length>50){ $('txtApellidoPac').addClass('error_requerido').attr('title','No debe sobrepasar de 50 caracteres'); errores++; }
				if(iv7.length>60){ $('#dirpac').addClass('error_requerido').attr('title','No debe sobrepasar de 60 caracteres'); errores++; }
				if(errores>0){
					humane.log('Complete los campos requeridos');
					return false;
				}else{
					return true;
				}
			},


			guardar:function(){
				var _t = this;
				if(!_t.validarForm()){ return; }
				
				var nombre = $('#txtNompaciente').val();
				var apellido = $('txtApellidoPac').val();
				var fecha_nac = $('#date').val();
				var peso = $('#txtPesopac').val();
				var altura = $('#txtAltpac').val();
				var alergias = $('#alergiaspac').val();
				var direccion = $('#dirpac').val();
				var telcasa = $('#txtTelpac').val();
				var telcel = $('#txtCelc').val();
				var frecha_cre = $('#pac_fecha_cre').val();

				var datos = 'action=sv_conf&nombre='+nombre+'&apellido='+apellido+'&fecha_nac='+fecha_nac+'&peso='+peso+'&altura='+altura+'&alergias='+altura+
				'&alergias='+alergias+'&direccion='+direccion+'&telcasa='+telcasa+'&telcel='+telcel+'&frecha_cre'+frecha_cre;

				$.ajax({
					url:'stores/expediente.php',
					data:datos, dataType:'json', type:'POST',
					complete:function(datos){
						var T = jQuery.parseJSON(datos.responseText);

						humane.log(T.msg);
					}
				});
			},

			toggle:function(v){
				if(v){ $('#guardarBtn').removeClass('disabled').html('Guardar'); }
				else{ $('#guardarBtn').addClass('disabled').html('Guardando...'); }
			}
		}


	</script>
<?php include('res/partes/pie.pagina.php'); ?>




			
			
				