<?php
include("sesion.php");
//- Incluimos la clase de conexion e instanciamos del objeto principal
include_once("libs/php/class.connection.php");

$botones_menu["limpio"]=true;
$botones_herramientas["productos"]=true;


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
	<link href="res/css/bootstrap/css/bootstrap-timepicker.css" rel="stylesheet"/>
	<link href="res/css/datepicker.css" rel="stylesheet"/>
	<link href="res/css/table-fixed-header.css" rel="stylesheet"/>

    <script type="text/javascript" src="libs/js/select2/select2.js"></script>
    <script type="text/javascript" src="libs/js/select2/select2_locale_es.js"></script>
    <script type="text/javascript" src="libs/js/bootstrap-timepicker.js"></script>
    <script type="text/javascript" src="libs/js/bootstrap-datepicker.js"></script>
    <script type="text/javascript" src="libs/js/bootstrap-datepicker.es.js"></script>
    <script type="text/javascript" src="libs/js/table-fixed-header.js"></script>
	<script type="text/javascript" src="libs/js/custom/agenda.js"></script>
	

<!-- /Scripts extra -->


	<h3>Mantenimientos: Productos/Servicios</h3>

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
			$('#guardarProd').click(function(){ manto.guardar(); });
			cargarLista();

		});

		function cargarLista(){ //Aqui hago el llamado a stores/productos.php para cargar lista de depto
			$.ajax("stores/productos.php", {
				data:'action=ls_depto', dataType:'json', type:'POST'
			}).success(function(data) { preloadedDeptos = data.results; console.log(preloadedDeptos); });
		}


	 function validarForm(){
			var errores=0;
			limpiarValidacion(false);

			var iv1 = $('#nombreProd').val();
			var iv2 = $('#salantProd').val();
			var iv3 = $('#salant2Prod').val();
			var iv4 = $('#costuniProd').val();
            var iv5 = $('#ultcostoProd').val();
			var iv6 = $('#cantminProd').val();
			var iv7 = $('#ExistenciaProd').val();
			var iv8 = $("#fecvenProd").val();
			var iv9 = $("#ultvenProd").val();
			var iv10 = $("#catid").val();
			var iv11 = $("#idmar").val();
			var iv12 = $("#idsuc").val();
			var iv13 = $("#idtip").val();
			
			
			if(iv1==''){ $('#nombreProd').addClass('error_requerido'); errores++; }
            if(iv2==''){ $('#salantProd').addClass('error_requerido'); errores++; }
            if(iv3==''){ $('#salant2Prod').addClass('error_requerido'); errores++; }
            if(iv4==''){ $('#costuniProd').addClass('error_requerido'); errores++; }
            if(iv5==''){ $('#ultcostoProd').addClass('error_requerido'); errores++; }
            if(iv6==''){ $('#cantminProd').addClass('error_requerido'); errores++; }
            if(iv7==''){ $('#ExistenciaProd').addClass('error_requerido'); errores++; }
            if(iv8==''){ $('#fecvenProd').addClass('error_requerido'); errores++; }
            if(iv9==''){ $('#ultvenProd').addClass('error_requerido'); errores++; }
			if(iv10==''){ $('#s2id_catid').addClass('error_requerido_sel2'); errores++; }
			if(iv11==''){ $('#s2id_idmar').addClass('error_requerido_sel2'); errores++; }
			if(iv12==''){ $('#s2id_idsuc').addClass('error_requerido_sel2'); errores++; }
			if(iv12==''){ $('#s2id_idtip').addClass('error_requerido_sel2'); errores++; }
			if(errores>0){
				humane.log('Complete los campos requeridos');
				return false;
			}else{
				return true;
			}
		}	

		
		function limpiarValidacion(conTexto){
			
                $('#nombreProd').removeClass('error_requerido');
				$('#salantProd').removeClass('error_requerido');
				$('#salant2Prod').removeClass('error_requerido');
				$('#costuniProd').removeClass('error_requerido');
	            $('#ultcostoProd').removeClass('error_requerido');
				$('#cantminProd').removeClass('error_requerido');
				$('#ExistenciaProd').removeClass('error_requerido');
				$("#fecvenProd").removeClass('error_requerido');
				$("#ultvenProd").removeClass('error_requerido');
				$('#ubiProd').removeClass('error_requerido');
				$("#s2id_catid").removeClass('error_requerido_sel2');
			    $("#s2id_idmar").removeClass('error_requerido_sel2');
			    $("#s2id_idsuc").removeClass('error_requerido_sel2');
			    $("#s2id_idtip").removeClass('error_requerido_sel2');
                if(conTexto){

				$('#nombreProd').val('');
				$('#salantProd').val('');
				$('#salant2Prod').val('');
				$('#costuniProd').val('');
	            $('#ultcostoProd').val('');
				$('#cantminProd').val('');
				$('#ExistenciaProd').val('');
				$("#fecvenProd").val('');
				$("#ultvenProd").val('');
				$('#ubiProd').val('');
				$("#catid").val('');
			    $("#idmar").val('');
			    $("#idsuc").val('');
			    $("#idtip").val('');
			}
			manto.toggle(true);
		}

		function cargarTabla(){
			$.ajax({
				url:'stores/productos.php',
				data:'action=gd_prod', dataType:'json', type:'POST',
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



           $('#nombreProd').val();
			$('#salantProd').val();
			$('#salant2Prod').val();
			$('#costuniProd').val();
            $('#ultcostoProd').val();
			$('#cantminProd').val();
			$('#ExistenciaProd').val();
			$("#fecvenProd").val();
			$("#ultvenProd").val();
			$('#AgregarProd').modal('show');
				
         $("#catid").select2({
							placeholder: "Seleccionar",
							ajax: {
								url: "stores/productos.php", dataType: 'json', type:'POST',
								data: function (term, page) {
									return { q: term, action:'ls_cat' };
								},
								results: function (data, page) {
									return {results: data.results};
								}
							}
						});
	      


	               $("#idmar").select2({
							placeholder: "Seleccionar",
							ajax: {
								url: "stores/productos.php", dataType: 'json', type:'POST',
								data: function (term, page) {
									return { q: term, action:'ls_mar' };
								},
								results: function (data, page) {
									return {results: data.results};
								}
							}
						});

                  
				
						
						$("#idsuc").select2({
							placeholder: "Seleccionar",
							ajax: {
								url: "stores/productos.php", dataType: 'json', type:'POST',
								data: function (term, page) {
									return { q: term, action:'ls_suc' };
								},
								results: function (data, page) {
									return {results: data.results};
								}
							}
						});

						$("#idtip").select2({
							placeholder: "Seleccionar",
							ajax: {
								url: "stores/productos.php", dataType: 'json', type:'POST',
								data: function (term, page) {
									return { q: term, action:'ls_tip' };
								},
								results: function (data, page) {
									return {results: data.results};
								}
							}
						});	
				


			},

//Esta funcion me sirve para editar los datos de cada fila
			editar:function(id){
				this.estado = 'editar';
				this.id = id;
				$.ajax({
					url:'stores/productos.php',
					//data:'action=rt_muni&id='+id, dataType:'json', type:'POST',
					data:'action=rt_prod&id='+id, dataType:'json', type:'POST',
					complete:function(datos){
						var T = jQuery.parseJSON(datos.responseText);
						
						limpiarValidacion(true);
						
						$('#nombreProd').val(T.nombre);
						$('#salantProd').val(T.salant);
						$('#salant2Prod').val(T.salant2);
						$('#costuniProd').val(T.costuni);
						$('#ultcostoProd').val(T.ultcosto);
						$('#cantminProd').val(T.cantmin);
						$('#ExistenciaProd').val(T.Existencia);

						/*$("#fecvenProd").datepicker({
								format:'dd/mm/yyyy', startDate:nowText, autoclose:true, language:'es',
							}).on('changeDate',function(ev){
								var timestamp = ev.timeStamp/1000; //Sacando el timestamp en segundos UNIX
								_t.fecha_seleccionada = timestamp;
							});*/

						$("#fecvenProd").datepicker('update',T.fecven);
						//$('#fecvenProd').val(T.fecven);
						$("#ultvenProd").datepicker('update',T.ultven);
						//$('#ultvenProd').val(T.ultven);

						$('#ubiProd').val(T.ubi);
						$('#AgregarProd').modal('show');
						$("#catid").select2({
							placeholder: "Seleccionar",
							ajax: {
								url: "stores/productos.php", dataType: 'json', type:'POST',
								data: function (term, page) {
									return { q: term, action:'ls_cat' };
								},
								results: function (data, page) {
									return {results: data.results};
								}
							}
						});
						

						$("#idmar").select2({
							placeholder: "Seleccionar",
							ajax: {
								url: "stores/productos.php", dataType: 'json', type:'POST',
								data: function (term, page) {
									return { q: term, action:'ls_mar' };
								},
								results: function (data, page) {
									return {results: data.results};
								}
							}
						});
						
						
						$("#idsuc").select2({
							placeholder: "Seleccionar",
							ajax: {
								url: "stores/productos.php", dataType: 'json', type:'POST',
								data: function (term, page) {
									return { q: term, action:'ls_suc' };
								},
								results: function (data, page) {
									return {results: data.results};
								}
							}
						});

						$("#idtip").select2({
							placeholder: "Seleccionar",
							ajax: {
								url: "stores/productos.php", dataType: 'json', type:'POST',
								data: function (term, page) {
									return { q: term, action:'ls_tip' };
								},
								results: function (data, page) {
									return {results: data.results};
								}
							}
						});

						$("#catid").select2("data",{id:T.catid,text:T.catnom});
						$("#idmar").select2("data",{id:T.idmar,text:T.marnom});
						$("#idsuc").select2("data",{id:T.idsuc,text:T.sucnom});
						$("#idtip").select2("data",{id:T.idtip,text:T.nomtip});
						
					}
				});

			},
			borrar:function(id){
				var tipo = (id)?'uno':'varios';
				var seleccion = gridCheck.getSelectionJSON('gridProd');
				if(tipo=='varios' && seleccion==false){
					humane.log('No ha seleccionado ning&uacute;n registro');
					return;
				}

				var ids = (tipo=='uno')?id:seleccion;
				var action = (tipo=='uno')?'br_prov':'br_variosprov' ;
				
				bootbox.confirm("¿Esta seguro de eliminar los registros?", function(confirm) {
					if(confirm){
						$.ajax({
							url:'stores/productos.php',
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



            var nombre = $('#nombreProd').val();
			var salant = $('#salantProd').val();
			var salant2 = $('#salant2Prod').val();
			var costuni = $('#costuniProd').val();
            var ultcosto = $('#ultcostoProd').val();
			var cantmin = $('#cantminProd').val();
			var Ubicacion = $('#ubiProd').val();
			var Existencia = $('#ExistenciaProd').val();
			//var fecven = $("#fecvenProd").val();
			//var ultven = $("#ultvenProd").val();
			var catid = $("#catid").val();
			var idmar = $("#idmar").val();
			var idsuc = $("#idsuc").val();
			var idtip = $("#idtip").val();

				
				if(this.estado=='agregar'){ this.id=''; }
				//var datos = 'action=sv_muni&nombre='+nombre+'&idDepto='+idDepto+'&id='+this.id;
				//var datos = 'action=sv_prov&nombre ='+nombre+'&id='+this.id;

				var datos = 'action=sv_prod&nombre='+nombre+'&salant='+salant+ '&salant2='+salant2+ '&costuni='+costuni+'&ultcosto='+ultcosto+
				                    '&cantmin='+cantmin+'&Ubicacion='+Ubicacion+'&Existencia='+Existencia+'&catid='+catid+'&idmar='
				                    +idmar+ '&idsuc='+idsuc+ '&idtip='+idtip+'&id='+this.id;

				$.ajax({
					url:'stores/productos.php',
					data:datos, dataType:'json', type:'POST',
					complete:function(datos){
						var T = jQuery.parseJSON(datos.responseText);

						humane.log(T.msg);
						if(T.success=="true"){
							$('#AgregarProd').modal('hide');
							manto.toggle(true);
							cargarTabla();
						}
						manto.toggle(true);
					}
				});
			},

			toggle:function(v){
				if(v){ $('#guardarProd').removeClass('disabled').html('Guardar'); }
				else{ $('#guardarProd').addClass('disabled').html('Guardando...'); }
			}
		}



	</script>

	<!-- Modales -->

	<!-- Agregar -->
	<div id="AgregarProd" class="modal hide fade" role="dialog" aria-labelledby="AgregarProd" aria-hidden="true">
		
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h3 id="modalHead">Productos</h3>
		</div>
		<div class="modal-body">
			<form>
				<fieldset>
               <table width="100%" cellspacing="0" cellpadding="0" style="margin-top:5px;">
                 <tr><td width="40%">
					<label id="nombreProd_label" class="requerido" style="margin-top:3px;">Nombre</label>
					<input id="nombreProd" type="text" min-length="2" class="input-block-level" placeholder="Escribir..." >
				 </td>
				 <td width="10%"> 	
					<label id="idtip_label" class="requerido" style="margin-top:-5px;">Tipo</label>
					<input id="idtip" type="hidden" style="width:100%" >
				 </td>
				 <td width="25%"> 	
					<label id="ExistenciaProd_label" class="requerido" style="margin-top:3px;">Existencia</label>
					<input id="ExistenciaProd" type="text" min-length="2" class="input-block-level" placeholder="Escribir..." >
				 </td>
				 <td width="25%"> 	
					<label id="cantminProd_label" class="requerido" style="margin-top:3px;">Cantidad Minima</label>
					<input id="cantminProd" type="text" min-length="2" class="input-block-level" placeholder="Escribir..." >
				 </td></tr>
				 </table>
       				 <!---->				

       <table width="100%" cellspacing="0" cellpadding="0" style="margin-top:3px;">
                 <tr><td width="20%">
					<label id="idsuc_label" class="requerido">Sucursal</label>
					<input id="idsuc" type="hidden" style="width:100%" >
				 </td>
				 <td width="40%"> 	
					<label id="idmar_label" class="requerido">Marcas</label>
					<input id="idmar" type="hidden" style="width:100%" >
				 </td>
				 <td width="40%"> 	
					<label id="catid_label" class="requerido">Categoria</label>
					<input id="catid" type="hidden" style="width:100%" >
				 </td></tr>
				 </table>
				 <!---->

               <!-- -->
       <table width="100%" cellspacing="0" cellpadding="0" style="margin-top:5px;">
                 <tr><td width="25%">
					<label id="salant2Prod_label" class="requerido" style="margin-top:3px;">Saldo ant Valor</label>
					<input id="salant2Prod" type="text" min-length="2" class="input-block-level" placeholder="Escribir..." >
				 </td>
                 <td width="25%">
                 <label id="salantProd_label" class="requerido" style="margin-top:3px;">Saldo ant Unit</label> 	
			     <input id="salantProd" type="text" min-length="2" class="input-block-level" placeholder="Escribir..." >
				 </td>
				 <td width="25%"> 	
                    <label id="ultcostoProd_label" class="requerido" style="margin-top:3px;">Ultimo Costo</label>
					<input id="ultcostoProd" type="text" min-length="2" class="input-block-level" placeholder="Escribir..." >
				 </td>
				 <td width="25%"> 	
				    <label id="costuniProd_label" class="requerido" style="margin-top:3px;">Costo x Uni</label>
					<input id="costuniProd" type="text" min-length="2" class="input-block-level" placeholder="Escribir..." >
				 </td></tr>
				 </table>
		 <table width="100%" cellspacing="0" cellpadding="0" style="margin-top:5px;">
                  <tr><td width="25%" valign="top">
                      <label id="fecvenProd_label" class="requerido">Fecha Ven</label>
					  <input type="text" style="width:95px" placeholder="dd/mm/yyyy" id="fecvenProd" >
				  </td>
				  <td width="25%" valign="top">
					<label id="#ultvenProd_label" class="requerido">Ultima Venta</label>
					<input type="text" style="width:95px" placeholder="dd/mm/yyyy" id="ultvenProd" >
				 </td>
				  <td width="75%">
					<label id="ubiProd_label"  style="margin-top:-2px;">Ubicacion</label>
					<input id="ubiProd" type="text" min-length="2" class="input-block-level" placeholder="Escribir..." >
				  	</table>
				</fieldset>
			</form>
		</div>
		<div class="modal-footer">
			<button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
			<button id="guardarProd" class="btn btn-primary">Guardar</button>
		</div>

	</div>


<?php include('res/partes/pie.pagina.php'); ?>

