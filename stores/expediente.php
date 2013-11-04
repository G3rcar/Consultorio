<?php
include("sesion.back.php");


//- Incluimos la clase de conexion e instanciamos del objeto principal
include_once("../libs/php/class.connection.php");
include_once("../libs/php/class.objetos.base.php");
$conexion = new Conexion();

function validarForm(){
			var errores=0;
			limpiarValidacion(false);

			var iv1 = $('#idPais').val();
			var iv2 = $('#idDepto').val();
			var iv3 = $('#nombreMuni').val();
			
			if(iv1==''){ $('#s2id_idPais').addClass('error_requerido_sel2'); errores++; }
			if(iv2==''){ $('#s2id_idDepto').addClass('error_requerido_sel2'); errores++; }
			if(iv3==''){ $('#nombreMuni').addClass('error_requerido'); errores++; }
			if(iv3.length>45){ $('#nombreMuni').addClass('error_requerido').attr('title','No debe sobrepasar los 45 caracteres'); errores++; }
			if(errores>0){
				humane.log('Complete los campos requeridos');
				return false;
			}else{
				return true;
			}