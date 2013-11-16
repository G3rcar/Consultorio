<?php
include("sesion.php");
//- Incluimos la clase de conexion e instanciamos del objeto principal
include_once("libs/php/class.connection.php");

$botones_menu["limpio"]=true;
$botones_herramientas["proveedores"]=true;


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

<!-- /Scripts extra -->


	<h3>Mantenimientos: Proveedores</h3>

	<div class="container-fluid">
		<div class="row-fluid">
			
			<!-- Columna fluida con peso 3/12 -->
			<div class="span3">
			    <!--****Con este include se pone el menu de las configuraciones aqui podes agregar o quitar algun link.****-->
				<?php include('res/partes/herramientas.configuracion.php'); ?>  
			</div>
			<!-- /Columna fluida con peso 3/12 -->


			<!-- Columna fluida con peso 9/12 -->
			<div id="contenedorTabla" class="span9">
				<!-- Aqui se cargaran los datos del catalogo -->
			</div>
			<!-- /Columna fluida con peso 9/12 -->
			

		</div>
	</div>

	<!-- Scripts -->

	<script>
		var preloadedDeptos = [];

		$(document).ready(function(){
			cargarTabla();


			$('#lnkAgregar').click(function(){ manto.agregar(); });
			$('#lnkBorrar').click(function(){ manto.borrar(); });
			$('#guardarPrv').click(function(){ manto.guardar(); });
			cargarLista();

		});

		function cargarLista(){ //Aqui hago el llamado a stores/proveedores.php para cargar lista de depto
			$.ajax("stores/proveedores.php", {
				data:'action=ls_depto', dataType:'json', type:'POST'
			}).success(function(data) { preloadedDeptos = data.results; console.log(preloadedDeptos); });
		}

		function validarForm(){
			var errores=0;
			limpiarValidacion(false);

			var iv1 = $('#idPais').val();
			var iv2 = $('#idDepto').val();
			var iv3 = $('#nombreProv').val();
			//var iv4 = $('#nombreProv').val(); 
			
			if(iv1==''){ $('#s2id_idPais').addClass('error_requerido_sel2'); errores++; }
			if(iv2==''){ $('#s2id_idDepto').addClass('error_requerido_sel2'); errores++; }
			if(iv3==''){ $('#nombreProv').addClass('error_requerido'); errores++; }
			if(iv3.length>45){ $('#nombreProv').addClass('error_requerido').attr('title','No debe sobrepasar los 45 caracteres'); errores++; }
			//if(iv4==''){ $('#nombreProv').addClass('error_requerido'); errores++; }
			if(errores>0){
				humane.log('Complete los campos requeridos');
				return false;
			}else{
				return true;
			}
		}

		function limpiarValidacion(conTexto){
			$('#s2id_idPais').removeClass('error_requerido_sel2');
			$('#s2id_idDepto').removeClass('error_requerido_sel2');
			$('#nombreProv').removeClass('error_requerido');
			if(conTexto){
				$('#idPais').val('');
				$('#idDepto').val('');
				$('#nombreProv').val('');
			}
			manto.toggle(true);
		}

		function cargarTabla(){
			$.ajax({
				url:'stores/proveedores.php',
				data:'action=gd_prov', dataType:'json', type:'POST',
				complete:function(datos){
					$("#contenedorTabla").html(datos.responseText);
				}
			});
		}



		var manto = {
			estado: 'agregar',
			id:'',

//Esta funcion agregar sirve para limpiar los datos del formulario de nuevo ingreso. limpia cada campo lo deja null;
			agregar:function(){
				this.estado = 'agregar';
				this.id = '';
				limpiarValidacion(true);


				$('#correoProv').val('');
				//$('#telefonoProv').removeClass('error_requerido');
				$('#telefonoProv').val('');
				$('#faxProv').val('');
				$('#condominioProv').val('');
				//$('#calleProv').removeClass('error_requerido');
				$('#calleProv').val('');
				$('#casaProv').val('');
				//$('#coloniaProv').removeClass('error_requerido');
				$('#coloniaProv').val('');
				$('#referenciaProv').val('');
				$('#AgregarProv').modal('show');
				//$('#nombreProv').removeClass('error_requerido');
				$('#nombreProv').val('');
				$("#idPais").select2({
					placeholder: "Seleccionar",
					ajax: {
						url: "stores/proveedores.php", dataType: 'json', type:'POST',
						data: function (term, page) {
							return { q: term, action:'ls_pais' };
						},
						results: function (data, page) {
							return {results: data.results};
						}
					}
				});
				$("#idPais").change(function(){
					var idPais = $("#idPais").val();
					$("#idDepto").select2({
						placeholder: "Seleccionar",
						ajax: {
							url: "stores/proveedores.php", dataType: 'json', type:'POST',
							data: function (term, page) {
								return { q: term, action:'ls_depto', pais:idPais };
							},
							results: function (data, page) {
								return {results: data.results};
							}
						}
					});
					$("#idDepto").select2("enable",true);
				});

				$("#idDepto").select2({
					placeholder: "Seleccionar", enable:false,
					ajax: {
						url: "stores/proveedores.php", dataType: 'json', type:'POST',
						data: function (term, page) {
							return { q: term, action:'ls_depto' };
						},
						results: function (data, page) {
							return {results: data.results};
						}
					}
				});
				$("#idDepto").select2("enable",false);

				//**
               $("#idDepto").change(function(){
					var idDepto = $("#idDepto").val();
					$("#idMuni").select2({
						placeholder: "Seleccionar",
						ajax: {
							url: "stores/proveedores.php", dataType: 'json', type:'POST',
							data: function (term, page) {
								return { q: term, action:'ls_muni', depto:idDepto };
							},
							results: function (data, page) {
								return {results: data.results};
							}
						}
					});
					$("#idMuni").select2("enable",true);
				});

						$("#idMuni").select2({
							placeholder: "Seleccionar", enable:false,
							ajax: {
								url: "stores/proveedores.php", dataType: 'json', type:'POST',
								data: function (term, page) {
									return { q: term, action:'ls_muni'  ,depto:T.idDepto };
								},
								results: function (data, page) {
									return {results: data.results};
								}
							}
						});
				//**


			},

//Esta funcion me sirve para editar los datos de cada fila
			editar:function(id){
				this.estado = 'editar';
				this.id = id;
				$.ajax({
					url:'stores/proveedores.php',
					//data:'action=rt_muni&id='+id, dataType:'json', type:'POST',
					data:'action=rt_prov&id='+id, dataType:'json', type:'POST',
					complete:function(datos){
						var T = jQuery.parseJSON(datos.responseText);
						
						limpiarValidacion(true);
						
						$('#nombreProv').val(T.nombre);
						$('#correoProv').val(T.correo);
						$('#telefonoProv').val(T.tel);
						$('#faxProv').val(T.fax);
						$('#condominioProv').val(T.condominio);
						$('#calleProv').val(T.calle);
						$('#casaProv').val(T.casa);
						$('#coloniaProv').val(T.colonia);
						$('#referenciaProv').val(T.referencia);
						$('#AgregarProv').modal('show');
						$("#idPais").select2({
							placeholder: "Seleccionar",
							ajax: {
								url: "stores/proveedores.php", dataType: 'json', type:'POST',
								data: function (term, page) {
									return { q: term, action:'ls_pais' };
								},
								results: function (data, page) {
									return {results: data.results};
								}
							}
						});
						$("#idPais").change(function(){
							var idPais = $("#idPais").val();
							$("#idDepto").select2({
								placeholder: "Seleccionar",
								ajax: {
									url: "stores/proveedores.php", dataType: 'json', type:'POST',
									data: function (term, page) {
										return { q: term, action:'ls_depto', pais:idPais };
									},
									results: function (data, page) {
										return {results: data.results};
									}
								}
							});
							$("#idDepto").select2("enable",true);
						});

						$("#idDepto").select2({
							placeholder: "Seleccionar",
							ajax: {
								url: "stores/proveedores.php", dataType: 'json', type:'POST',
								data: function (term, page) {
									return { q: term, action:'ls_depto',pais:T.idPais };
								},
								results: function (data, page) {
									return {results: data.results};
								}
							}
						});
					$("#idDepto").change(function(){
					var idDepto = $("#idDepto").val();
					$("#idMuni").select2({
						placeholder: "Seleccionar",
						ajax: {
							url: "stores/proveedores.php", dataType: 'json', type:'POST',
							data: function (term, page) {
								return { q: term, action:'ls_muni',depto:idDepto };
							},
							results: function (data, page) {
								return {results: data.results};
							}
						}
					});
					$("#idMuni").select2("enable",true);
				});

						$("#idMuni").select2({
							placeholder: "Seleccionar",
							ajax: {
								url: "stores/proveedores.php", dataType: 'json', type:'POST',
								data: function (term, page) {
									return { q: term, action:'ls_muni',depto:T.idDepto };
								},
								results: function (data, page) {
									return {results: data.results};
								}
							}
						});
							
						$("#idPais").select2("data",{id:T.idPais,text:T.pais});
						$("#idDepto").select2("data",{id:T.idDepto,text:T.depto});
						$("#idMuni").select2("data",{id:T.idMuni,text:T.muni});
					}
				});

			},
			borrar:function(id){
				var tipo = (id)?'uno':'varios';
				var seleccion = gridCheck.getSelectionJSON('gridProv');
				if(tipo=='varios' && seleccion==false){
					humane.log('No ha seleccionado ning&uacute;n registro');
					return;
				}

				var ids = (tipo=='uno')?id:seleccion;
				var action = (tipo=='uno')?'br_muni':'br_variosmuni' ;
				
				bootbox.confirm("¿Esta seguro de eliminar los registros?", function(confirm) {
					if(confirm){
						$.ajax({
							url:'stores/proveedores.php',
							data:'action='+action+'&id='+ids, dataType:'json', type:'POST',
							complete:function(datos){
								var T = jQuery.parseJSON(datos.responseText);
								
								humane.log(T.msg)
								if(T.success=='true') cargarTabla();
							}
						});
					}
				}); 
			},


			guardar:function(){
				if(!validarForm()){ return; }
				manto.toggle(false);
				var nombre     = $('#nombreProv').val();
				var correo     = $('#correoProv').val();
				var condominio = $('#condominioProv').val();
				var calle      = $('#calleProv').val();
				var casa       = $('#casaProv').val();
				var colonia    = $('#coloniaProv').val();
				var referencia = $('#referenciaProv').val();
				var idDepto    = $('#idDepto').val();
                var idMuni     = $('#idMuni').val();
                var telefono   = $('#telefonoProv').val();
				var fax        = $('#faxProv').val();
				
				if(this.estado=='agregar'){ this.id=''; }
				//var datos = 'action=sv_muni&nombre='+nombre+'&idDepto='+idDepto+'&id='+this.id;
				var datos = 'action=sv_prov&nombre ='+nombre+'&id='+this.id;
				$.ajax({
					url:'stores/proveedores.php',
					data:datos, dataType:'json', type:'POST',
					complete:function(datos){
						var T = jQuery.parseJSON(datos.responseText);

						humane.log(T.msg);
						if(T.success=="true"){
							$('#AgregarProv').modal('hide');
							manto.toggle(true);
							cargarTabla();
						}
						manto.toggle(true);
					}
				});
			},

			toggle:function(v){
				if(v){ $('#guardarProv').removeClass('disabled').html('Guardar'); }
				else{ $('#guardarProv').addClass('disabled').html('Guardando...'); }
			}
		}



	</script>


	<!-- Modales -->

	<!-- Agregar -->
	<div id="AgregarProv" class="modal hide fade" role="dialog" aria-labelledby="AgregarProv" aria-hidden="true">
		
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h3 id="modalHead">Proveedores</h3>
		</div>
		<div class="modal-body">
			<form>
				<fieldset>
               <table width="100%" cellspacing="0" cellpadding="0" style="margin-top:5px;">
                 <tr><td width="50%">
					<label id="nombreProv_label" class="requerido" style="margin-top:3px;">Nombre</label>
					<input id="nombreProv" type="text" min-length="2" class="input-block-level" placeholder="Escribir..." >
				 </td>
				 <td width="50%"> 	
					<label id="correoProv_label"  style="margin-top:3px;">Correo</label>
					<input id="correoProv" type="text" min-length="2" class="input-block-level" placeholder="Escribir..." >
				 </td></tr>
				 </table>
               <!-- -->
       <table width="100%" cellspacing="0" cellpadding="0" style="margin-top:5px;">
                 <tr><td width="50%">
					<label id="telefonoProv_label" class="requerido" style="margin-top:3px;">Telefono</label>
					<input id="telefonoProv" type="text" min-length="2" class="input-block-level" placeholder="Escribir..." >
				 </td>
				 <td width="50%"> 	
					<label id="faxProv_label"  style="margin-top:3px;">Fax</label>
					<input id="faxProv" type="text" min-length="2" class="input-block-level" placeholder="Escribir..." >
				 </td></tr>
				 </table>
				 <!---->
       <table width="100%" cellspacing="0" cellpadding="0" style="margin-top:3px;">
                 <tr><td width="40%">
					<label id="idPais_label" class="requerido">Pais</label>
					<input id="idPais" type="hidden" style="width:100%" >
				 </td>
				 <td width="30%"> 	
					<label id="idDepto_label" class="requerido">Departamento</label>
					<input id="idDepto" type="hidden" style="width:100%" >
				 </td>
				 <td width="30%"> 	
					<label id="idMuni_label" class="requerido">Municipio</label>
					<input id="idMuni" type="hidden" style="width:100%" >
				 </td></tr>
				 </table>
				 <!---->
		 <table width="100%" cellspacing="0" cellpadding="0" style="margin-top:5px;">
                  <tr><td width="50%">
						<label id="condominioProv_label"  style="margin-top:3px;">Condominio</label>
						<input id="condominioProv" type="text" min-length="2" class="input-block-level" placeholder="Escribir..." >
				  </td>
				  <td width="40%">
					<label id="calleProv_label" class="requerido" style="margin-top:3px;">Calle</label>
					<input id="calleProv" type="text" min-length="2" class="input-block-level" placeholder="Escribir..." >
				  <td width="10%">
				    <label id="casaProv_label"  style="margin-top:3px;">Casa</label>
					<input id="casaProv" type="text" min-length="2" class="input-block-level" placeholder="Escribir..." >
				  </td></tr>
					</table>
		 <table width="100%" cellspacing="0" cellpadding="0" style="margin-top:5px;">
		          <td width="60%">
				    <label id="coloniaProv_label" class="requerido" style="margin-top:3px;">Colonia</label>
					<input id="coloniaProv" type="text" min-length="2" class="input-block-level" placeholder="Escribir..." >
			    </td>
				  <td width="40%">
					<label id="referenciaProv_label" style="margin-top:3px;">Referencia</label>
					<input id="referenciaProv" type="text" min-length="2" class="input-block-level" placeholder="Escribir..." >
				</td></tr>
				</table>
				</fieldset>
			</form>
		</div>
		<div class="modal-footer">
			<button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
			<button id="guardarProv" class="btn btn-primary">Guardar</button>
		</div>

	</div>


<?php include('res/partes/pie.pagina.php'); ?>

