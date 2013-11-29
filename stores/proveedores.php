<?php
include("sesion.back.php");


//- Incluimos la clase de conexion e instanciamos del objeto principal
include_once("../libs/php/class.connection.php");
include_once("../libs/php/class.objetos.base.php");
$conexion = new Conexion();


//- Si la variable action no viene se detenemos la ejecucion
if(!isset($_POST["action"])){ exit(); }

$accion = $_POST["action"];

switch ($accion) {
	case 'gd_prov': //****Aqui se construye el select para el formulario de los proveedores****

		$selProvs = "select prv_id id,prv_nom nom ,prv_cor cor,
						    dir_cond cond,dir_calle calle,dir_casa casa,dir_col col,dir_ref ref,mun_nom mun,
                            dep_nom dep, pai_nom pai, '' tel, '' fax
						  from proveedor, direccion,municipio,pais,departamento
						 where prv_iddir = dir_id
						   and dir_idmun = mun_id
			               and dep_idpai = pai_id
			               and mun_iddep = dep_id";
		$res = $conexion->execSelect($selProvs);
		$headers = array( //****Array contruye el encabezado del formulario****
			"Nombre","Correo","Telefono","Fax",
             array("width"=>"200","text"=>"Direccion"),
			 //"Condominio","Calle","Casa","Colonia","Referencia","Municipio","Departamento","Pais",
			
		array("width"=>"15","text"=>"&nbsp;"),
	    array("width"=>"15","text"=>"&nbsp;")
			//	array("width"=>"15","text"=>"Edit"), //&nbsp;
		//	array("width"=>"15","aline"=>"center","text"=>"Del")
		);
		$tabla = new GridCheck($headers,"gridProv");
		if($res["num"]>0){
			$i=0;
			while($iProv = $conexion->fetchArray($res["result"])){
				//Iconos //****Botones de editar y borrar en el formulario****
				$editar = "<a href='#' onClick='manto.editar({$iProv["id"]});' title='Editar' ><i class='icon-edit'></i></a>";
				$borrar = "<a href='#' onClick='manto.borrar({$iProv["id"]});' title='Borrar' ><i class='icon-remove'></i></a>";
				

				//****Aqui construyo la fila con los nombres del select del case 'gd_prov' para crear las filas****
				$valoresFila = array(utf8_encode($iProv["nom"]),utf8_encode($iProv["cor"]),utf8_encode($iProv["tel"]),utf8_encode($iProv["fax"]), //	
					                 //utf8_encode($iProv["ref"]),
					                 utf8_encode($iProv["col"])." ".utf8_encode($iProv["cond"])." ".utf8_encode($iProv["calle"])." ".utf8_encode($iProv["casa"]).
					                 ",".utf8_encode($iProv["mun"]).",".utf8_encode($iProv["dep"]),//.",".utf8_encode($iProv["pai"]),
					                 $editar,$borrar);
				$fila = array("id"=>$iProv["id"],"valores"=>$valoresFila);
				$tabla->nuevaFila($fila);
			}
		}

		$html = $tabla->obtenerCodigo();
		echo $html; //****Imprimo la tabla del formulario****
		
	break; //****Con este comando se termina la ejecucion de la estructura actual for, foreach, while, do-while o switch****



  case 'rt_prov':  //****Aqui construyo el select para mostrar los datos en el formulario para actualizar o crear un proveedor nuevo****
		$result = array("success"=>"false","msg"=>"");

		if(!isset($_POST["id"])){ exit(); }
		$id = $conexion->escape($_POST["id"]);

		$selProvs = "select prv_id,prv_nom,prv_cor,
						    dir_cond ,dir_calle ,dir_casa ,dir_col ,dir_ref ,mun_id,mun_nom muni,
						    dep_id,dep_nom depto,pai_id,pai_nom pais,prv_fax fax, prv_telefono tel
					   from proveedor, direccion,municipio,departamento,pais
					  where prv_iddir = dir_id
						and dir_idmun = mun_id
			            and mun_iddep = dep_id
			            and dep_idpai = pai_id
				        and prv_id    = {$id} ";
		$res = $conexion->execSelect($selProvs);

		if($res["num"]>0){
			$iProv = $conexion->fetchArray($res["result"]); //****Aqui mando los nombres de los datos consultados  del archivo ..proveedores.php  
			                                               //     para mostralos en el formulario
			$result = array("id"=>$iProv["prv_id"],"nombre"=>utf8_encode($iProv["prv_nom"]),"correo"=>utf8_encode($iProv["prv_cor"]),
				            "condominio"=>utf8_encode($iProv["dir_cond"]),"calle"=>utf8_encode($iProv["dir_calle"]),"casa"=>utf8_encode($iProv["dir_casa"]),
				            "colonia"=>utf8_encode($iProv["dir_col"]),"referencia"=>utf8_encode($iProv["dir_ref"]),
				             "idDepto"=>$iProv["dep_id"],"depto"=>utf8_encode($iProv["depto"]),"idPais"=>$iProv["pai_id"],"pais"=>$iProv["pais"],
				             "idMuni"=>$iProv["mun_id"],"muni"=>utf8_encode($iProv["muni"]),"tel"=>utf8_encode($iProv["tel"]),"fax"=>utf8_encode($iProv["fax"])
				             );
				             
		}

		echo json_encode($result);

	break; //****Termino ejecucion****

	
	case 'ls_pais': //****Select para la lista de paises****
		$query = "";
		
		if(isset($_POST["q"]) && $_POST["q"]!=""){
			$q = $conexion->escape($_POST["q"]);
			$query = " WHERE pai_nom LIKE '%{$q}%' ";
		}
		$selProvs = "SELECT pai_id AS 'id', pai_nom AS 'nombre' FROM pais {$query} ORDER BY id";
		$res = $conexion->execSelect($selProvs);
		
		$registros=array();
		if($res["num"]>0){
			$i=0;
			while($iDepto = $conexion->fetchArray($res["result"])){
				$registros[]=array("id"=>$iDepto["id"],"text"=>utf8_encode($iDepto["nombre"]));
			}
		}

		$results = array("results"=>$registros,"more"=>false);
		echo json_encode($results);
	break; //****Termino ejecucion****

	case 'ls_depto': //****Lista de departamentos****
			$query = "";
			if(!isset($_POST["pais"])) exit();

			$idPais = $conexion->escape($_POST["pais"]);
			if(isset($_POST["q"]) && $_POST["q"]!=""){
				$q = $conexion->escape($_POST["q"]);
				$query = " AND dep_nom LIKE '%{$q}%' ";
			}
			$selProvs = "SELECT dep_id 'id', dep_nom 'nombre' FROM departamento WHERE dep_idpai = {$idPais} {$query} ORDER BY id";
			$res = $conexion->execSelect($selProvs);
			
			$registros=array();
			if($res["num"]>0){
				$i=0;
				while($iDepto = $conexion->fetchArray($res["result"])){
					$registros[]=array("id"=>$iDepto["id"],"text"=>utf8_encode($iDepto["nombre"]));
				}
			}

			$results = array("results"=>$registros,"more"=>false);
			echo json_encode($results);
		break; //****Termino ejecucion****

     case 'ls_muni': //****Lista de Municipios****
			$query = "";
			if(!isset($_POST["depto"])) exit();

			$idDepto = $conexion->escape($_POST["depto"]);
			if(isset($_POST["q"]) && $_POST["q"]!=""){
				$q = $conexion->escape($_POST["q"]);
				$query = " AND mun_nom LIKE '%{$q}%' ";
			}
			$selProvs = "SELECT mun_id 'id', mun_nom 'nombre' FROM municipio WHERE mun_iddep = {$idDepto} {$query} ORDER BY id";
			$res = $conexion->execSelect($selProvs);
			
			$registros=array();
			if($res["num"]>0){
				$i=0;
				while($iMuni = $conexion->fetchArray($res["result"])){
					$registros[]=array("id"=>$iMuni["id"],"text"=>utf8_encode($iMuni["nombre"]));
				}
			}

			$results = array("results"=>$registros,"more"=>false);
			echo json_encode($results);
		break; //****Termino ejecucion****

    
			      

    case 'sv_prov': //Guardar datos esta es para insertar nuevos proveedores y
		if(!isset($_POST["nombre"])) exit();

		$tipo = ($_POST["id"]=="")?'nuevo':'editar';

		$id         = (int)$conexion->escape($_POST["id"]);
		//$idDepto    = (int)$conexion->escape($_POST["idDepto"]);
		$nombre     = $conexion->escape(utf8_decode($_POST["nombre"]));
		$correo     = $conexion->escape(utf8_decode($_POST["correo"]));
		$tel        = $conexion->escape(utf8_decode($_POST["tel"]));
		$fax        = $conexion->escape(utf8_decode($_POST["fax"]));
		$condominio = $conexion->escape(utf8_decode($_POST["condominio"]));
		$calle 		= $conexion->escape(utf8_decode($_POST["calle"]));
		$casa 		= $conexion->escape(utf8_decode($_POST["casa"]));
		$colonia 	= $conexion->escape(utf8_decode($_POST["colonia"]));
        $referencia = $conexion->escape(utf8_decode($_POST["referencia"]));
        $idMuni 	= (int)$conexion->escape($_POST["idMuni"]);

		$mantoProv = "";
		$mantoDir  = "";
		if($tipo=='nuevo'){
			$mantoDir  =  "INSERT INTO direccion(dir_cond,dir_calle,dir_casa,dir_col,dir_ref,dir_fecha_cre,dir_idmun) 
			                              VALUES('{$condominio}','{$calle}','{$casa}','{$colonia}','{$referencia}',NOW(),'{$idMuni}')";
        $resdir = 0;
		$resdir = $conexion->execManto($mantoDir);   
        $id_max = mysql_insert_id();

			// $mantoProv =  "INSERT INTO proveedor(prv_nom,prv_cor,prv_fecha_cre,prv_iddir,prv_fax,prv_telefono)
			//                             VALUES('{$nombre}','{$correo}',NOW(),$id_max,'{$fax}','{$tel}')" ;    //se pone dos para prueba
            $mantoProv =  "INSERT INTO proveedor(prv_nom,prv_cor,prv_fecha_cre,prv_iddir)
			                            VALUES('{$nombre}','{$correo}',NOW(),$id_max)" ;    //se pone dos para prueba
        		

			
		}else{
            
               
            $resultado =  mysql_query("Select prv_iddir
                                      from   proveedor
                                      where  prv_id = '{$id}'");

            $iddir = mysql_result($resultado,0);

			$mantoDir = "UPDATE Direccion 
			               SET  dir_cond   = '{$condominio}',
			                    dir_calle  = '{$calle}',
			                    dir_casa   = '{$casa}',
			                    dir_col    = '{$colonia}',
			                    dir_ref    = '{$referencia}',
			                    dir_idmun  = '{$idMuni}'
			             WHERE  dir_id     = '{$iddir}' ";

			// $mantoProv    = "UPDATE proveedor
			//                      SET prv_nom = '{$nombre}',
			//                          prv_cor = '{$correo}',
			//                          prv_fax = '{$fax}',
			//                          prv_telefono = '{$tel}'
			//                    where prv_id  = '{$id}' ";    
			$mantoProv    = "UPDATE proveedor
			                     SET prv_nom = '{$nombre}',
			                         prv_cor = '{$correo}'
			                   where prv_id  = '{$id}' ";               

		}
		
		//$resdir = 0;
		//$resdir = $conexion->execManto($mantoDir);

		$resprov = 0;
        $resprov = $conexion->execManto($mantoProv);      

                      

		if($resprov>0 or $resdir>0){
			$success = array("success"=>"true","msg"=>"El Proveedor se ha guardado Exitosamente");
		}else{
			$success = array("success"=>"false","msg"=>"Ha ocurrido un error");
		}
		echo json_encode($success);

	break;


    //Proceso de borrar proveedores
   case 'br_prov':
		$result = array("success"=>"false","msg"=>"");

		if(!isset($_POST["id"])){ exit(); }
		$id = json_decode($_POST["id"],true);


  

          //Extraigo el id de direccion
           $resultado =  mysql_query("Select prv_iddir
                                      from   proveedor
                                      where  prv_id = '{$id}'");

           $iddir = mysql_result($resultado,0);

        $borrarProv = "DELETE FROM proveedor WHERE prv_id = '{$id}' ";	

        $borrarDir = "DELETE FROM direccion WHERE dir_id = {$iddir} ";

		$res = $conexion->execManto($borrarProv);

		if($res>0){
			$result = array("success"=>"true","msg"=>"El Proveedor se ha borrado");
		}else{
			$result = array("success"=>"false","msg"=>"El Proveedor tiene datos relacionados");
		}
		echo json_encode($result);
		
	break;

case 'br_variosprov':
		$result = array("success"=>"false","msg"=>"");

		if(!isset($_POST["id"])){ exit(); }
		$ids = json_decode($_POST["id"],true);
		$tot = count($ids);

		$errores=0;
		$res = 0;

		for($i=0;$i<$tot;$i++){
			$id = $ids[$i];

			$borrarSuc = "DELETE FROM proveedor WHERE prv_id = {$id} ";
			$res = $conexion->execManto($borrarSuc);
			if(!($res>0)) $errores++;
		}
		if($errores>0 && $errores<$tot){
			$result = array("success"=>"true","msg"=>"Algunos proveedores no se pudieron eliminar");
		}elseif($errores==$tot){
			$result = array("success"=>"false","msg"=>"No se pudo eliminar ningun proveedor");
		}else{
			$result = array("success"=>"true","msg"=>"Los proveedores se han borrado");
			
		}
		echo json_encode($result);
		
	break;




}



?>