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
	case 'gd_prod': //****Aqui se construye el select para el formulario de los productos****  DATE_FORMAT(pro_fecha_venc,'%d/%m/%Y')

		$selProds = "  SELECT pro_id id,pro_idsuc , pro_nom nom, pro_salant_uni saluni,pro_salant_mon salmon,pro_costo_uni cotuni,
				       pro_ult_cost,pro_existencia exi,pro_cant_min,pro_ult_ven,pro_idmar,DATE_FORMAT(pro_fecha_venc,'%d/%m/%Y') fecven,
				       producto_categoria_cat_id catid,
				       pro_ubicacion ubi,pro_fila,pro_fecha_cre,cat_nombre catnom,cat_descripcion catdes, mar_nom marnom 
				 from  producto,marca,producto_categoria
				where  pro_idmar = mar_id
				  and  cat_id    = producto_categoria_cat_id;";
		$res = $conexion->execSelect($selProds);
		$headers = array( //****Array contruye el encabezado del formulario****
			"Nombre Producto","Nombre Categoria","Nombre Marca","Sal. ant unidades","Sal. ant Monto","Costo unidad",
			"Existencia","Fecha vencimiento","Ubicacion",
             //array("width"=>"200","text"=>"Direccion"),
			 //"Condominio","Calle","Casa","Colonia","Referencia","Municipio","Departamento","Pais",
			
		array("width"=>"15","text"=>"&nbsp;"),
	    array("width"=>"15","text"=>"&nbsp;")
			//	array("width"=>"15","text"=>"Edit"), //&nbsp;
		//	array("width"=>"15","aline"=>"center","text"=>"Del")
		);
		$tabla = new GridCheck($headers,"gridProd");
		if($res["num"]>0){
			$i=0;
			while($iProd = $conexion->fetchArray($res["result"])){
				//Iconos //****Botones de editar y borrar en el formulario****
				$editar = "<a href='#' onClick='manto.editar({$iProd["id"]});' title='Editar' ><i class='icon-edit'></i></a>";
				$borrar = "<a href='#' onClick='manto.borrar({$iProd["id"]});' title='Borrar' ><i class='icon-remove'></i></a>";
				

				//****Aqui construyo la fila con los nombres del select del case 'gd_prod' para crear las filas****
				$valoresFila = array(utf8_encode($iProd["nom"]),utf8_encode($iProd["catnom"]),utf8_encode($iProd["marnom"]),utf8_encode($iProd["saluni"]),
					                 utf8_encode($iProd["salmon"]),utf8_encode($iProd["cotuni"]),utf8_encode($iProd["exi"]),utf8_encode($iProd["fecven"]),
					                 utf8_encode($iProd["ubi"]),					                 
					                 $editar,$borrar);
				$fila = array("id"=>$iProd["id"],"valores"=>$valoresFila);
				$tabla->nuevaFila($fila);
			}
		}

		$html = $tabla->obtenerCodigo();
		echo $html; //****Imprimo la tabla del formulario****
		
	break; //****Con este comando se termina la ejecucion de la estructura actual for, foreach, while, do-while o switch****



  case 'rt_prod':  //****Aqui construyo el select para mostrar los datos en el formulario para actualizar o crear un proveedor nuevo****
		$result = array("success"=>"false","msg"=>"");

		if(!isset($_POST["id"])){ exit(); }
		$id = $conexion->escape($_POST["id"]);

		$selProds = "  SELECT pro_id,pro_idsuc, pro_nom, pro_salant_uni,pro_salant_mon,pro_costo_uni,
				       pro_ult_cost,pro_existencia,pro_cant_min,DATE_FORMAT(pro_ult_ven,'%d/%m/%Y'),pro_idmar,DATE_FORMAT(pro_fecha_venc,'%d/%m/%Y') fecven,
				       producto_categoria_cat_id,pro_tipo,
				       pro_ubicacion,pro_fila,pro_fecha_cre,cat_nombre,cat_descripcion catdes, mar_nom,suc_nom,
				        case pro_tipo
						    when 'P' then 'Producto'
						    when 'S' then 'Servicio'
						    else pro_tipo
					    end as nom_tipo  
				 from  producto,marca,producto_categoria,sucursal
				where  pro_idmar = mar_id
				  and  cat_id    = producto_categoria_cat_id
				  and  pro_idsuc = suc_id
				  and  pro_id    = {$id}";
		$res = $conexion->execSelect($selProds);

		if($res["num"]>0){
			$iProd = $conexion->fetchArray($res["result"]); //****Aqui mando los nombres de los datos consultados  del archivo ..proveedores.php  
			                                               //     para mostralos en el formulario
			$result = array("id"=>$iProd["pro_id"],"nombre"=>utf8_encode($iProd["pro_nom"]),"salant"=>$iProd["pro_salant_uni"],"salant2"=>$iProd["pro_salant_mon"],
                             "costuni"=>$iProd["pro_costo_uni"],"ultcosto"=>$iProd["pro_ult_cost"],"Existencia"=>$iProd["pro_existencia"],"fecven"=>$iProd["fecven"],
                             "catid"=>$iProd["producto_categoria_cat_id"],"ubi"=>utf8_encode($iProd["pro_ubicacion"]),"catnom"=>utf8_encode($iProd["cat_nombre"]),
				             "idmar"=>$iProd["pro_idmar"],"idsuc"=>$iProd["pro_idsuc"],"sucnom"=>utf8_encode($iProd["suc_nom"]),
				             "marnom"=>utf8_encode($iProd["mar_nom"]),"cantmin"=>$iProd["pro_cant_min"],"ultven"=>$iProd["DATE_FORMAT(pro_ult_ven,'%d/%m/%Y')"],
				             "idtip"=>$iProd["pro_tipo"],"nomtip"=>utf8_encode($iProd["nom_tipo"])
				             );
				             
		}

		echo json_encode($result);

	break; //****Termino ejecucion****

	
	case 'ls_mar': //****Select para la lista de marcas****
		$query = "";
		
		if(isset($_POST["q"]) && $_POST["q"]!=""){
			$q = $conexion->escape($_POST["q"]);
			$query = " WHERE mar_nom LIKE '%{$q}%' ";
		}
		$selProds = "SELECT mar_id AS 'id', mar_nom AS 'nombre' FROM marca {$query} ORDER BY id";
		$res = $conexion->execSelect($selProds);
		
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


  case 'ls_cat': //****Select para la lista de categorias****
		$query = "";
		
		if(isset($_POST["q"]) && $_POST["q"]!=""){
			$q = $conexion->escape($_POST["q"]);
			$query = " WHERE cat_nombre LIKE '%{$q}%' ";
		}
		$selProds = "SELECT cat_id AS 'id', cat_nombre AS 'nombre' FROM producto_categoria {$query} ORDER BY id";
		$res = $conexion->execSelect($selProds);
		
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

     case 'ls_suc': //****Select para la lista de Sucursales****
		$query = "";
		
		if(isset($_POST["q"]) && $_POST["q"]!=""){
			$q = $conexion->escape($_POST["q"]);
			$query = " WHERE suc_nom LIKE '%{$q}%' ";
		}
		$selProds = "SELECT suc_id AS 'id', suc_nom AS 'nombre' FROM sucursal {$query} ORDER BY id";
		$res = $conexion->execSelect($selProds);
		
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

     
    
 case 'ls_tip': //****Select para la lista de los tipos****
		$query = "";
		
		if(isset($_POST["q"]) && $_POST["q"]!=""){
			$q = $conexion->escape($_POST["q"]);
			$query = "WHERE tipo.nombre LIKE '%{$q}%' ";
		}

		 $query = "";
		$selProds = "SELECT tipo.id,tipo.nombre
						 from (SELECT 'P' as id, 'Producto' as Nombre
							    from  dual
							  union  
							select 'S' as id, 'Servicio' as Nombre
							  from  dual) tipo            
						  {$query}";
		$res = $conexion->execSelect($selProds);
		
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
    


			      

    case 'sv_prod': //Guardar datos esta es para insertar nuevos proveedores y
		if(!isset($_POST["nombre"])) exit();

		$tipo = ($_POST["id"]=="")?'nuevo':'editar';


		

		$id         = (int)$conexion->escape($_POST["id"]);
		//$idDepto    = (int)$conexion->escape($_POST["idDepto"]);
		$nombre     = $conexion->escape(utf8_decode($_POST["nombre"]));
		$salant     = (int)$conexion->escape($_POST["salant"]);
		$salant2    = (int)$conexion->escape($_POST["salant2"]);//double
		$costuni    = (int)$conexion->escape($_POST["costuni"]);//double
		$ultcosto   = (int)$conexion->escape($_POST["ultcosto"]);//double
		$Ubicacion    = $conexion->escape(utf8_decode($_POST["Ubicacion"]));
		$cantmin    = (int)$conexion->escape($_POST["cantmin"]);
		$Existencia = (int)$conexion->escape($_POST["Existencia"]);
		//$fecven 	= (int)$conexion->escape($_POST["fecven"]);
		//$ultven 	= (int)$conexion->escape($_POST["ultven"]);
        $catid 	= (int)$conexion->escape($_POST["catid"]);
        $idmar 	= (int)$conexion->escape($_POST["idmar"]);
        $idsuc 	= (int)$conexion->escape($_POST["idsuc"]);
        //$idtip 	= (int)$conexion->escape($_POST["idtip"]);
        $idtip     = $conexion->escape(utf8_decode($_POST["idtip"]));

		//$mantoProv = "";
		$mantoProd  = "";
		if($tipo=='nuevo'){
			$mantoProd  =  "INSERT INTO  producto(pro_nom,pro_salant_uni,pro_salant_mon,pro_costo_uni,pro_ult_cost,pro_existencia,pro_cant_min
										pro_ult_ven,pro_idsuc,pro_idmar,pro_fecha_venc,,producto_categoria_cat_id,pro_ubicacion,pro_fila
										pro_fecha_cre,pro_tipo) 
			                             VALUES('{$nombre}','{$salant}','{$salant2}','{$costuni}','{$ultcosto}','{$Existencia}','{$cantmin}',
			                             	    null,'{$idsuc}','{$idmar}',null,'{$catid}','{$Ubicacion}',null,now(),'{$idtip}'
			                             	     )";
       /* $resdir = 0;
		$resdir = $conexion->execManto($mantoDir);   
        $id_max = mysql_insert_id();

			$mantoProv =  "INSERT INTO proveedor(prv_nom,prv_cor,prv_fecha_cre,prv_iddir,prv_fax,prv_telefono)
			                            VALUES('{$nombre}','{$correo}',NOW(),$id_max,'{$fax}','{$tel}')" ;    //se pone dos para prueba
        	*/	

			
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

			 $mantoProv    = "UPDATE proveedor
			                     SET prv_nom = '{$nombre}',
			                         prv_cor = '{$correo}',
			                         prv_fax = '{$fax}',
			                         prv_telefono = '{$tel}'
			                   where prv_id  = '{$id}' ";               

               
			   

		}
		
		//$resdir = 0;
		//$resdir = $conexion->execManto($mantoDir);

		$resprod = 0;
        $resprod = $conexion->execManto($mantoProd);      

                      

		if($resprod>0){
			$success = array("success"=>"true","msg"=>"El Producto se ha guardado Exitosamente");
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