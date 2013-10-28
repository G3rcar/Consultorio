<?php

class GridCheck{
	private $alias;			//string
	private $cuerpo;		//string
	private $encabezados;	//array
	private $numColumnas;	//int
	private $numFilas;		//int
	//--
	public function __construct($columnas,$alias=""){
		if($alias=="") $alias = "idTable".strtotime(date());
		$this->alias = $alias;
		$this->numColumnas = count($columnas);
		$this->cuerpo = $this->obtenerEncabezado($alias);
		//$this->cuerpo = '<table id="'.$alias.'" class="table table-bordered table-striped table-hover"><thead><tr><th width="15"><input type="checkbox" /></th><th width="15">#</th>';
		
		for($i = 0 ; $i < $this->numColumnas ; $i++){
			if(gettype($columnas[$i])!="array"){ $columnas[$i]=array("width"=>"*","text"=>$columnas[$i]); }
			
			$tamano = (array_key_exists("width",$columnas[$i]) && $columnas[$i]["width"]!="")?' width="'.$columnas[$i]["width"].'"' : "";
			if(array_key_exists("text",$columnas[$i])){
				$this->cuerpo .= '<th '.$tamano.'>'.$columnas[$i]["text"].'</th>';
			}
		}
		$this->cuerpo .= '</tr></thead><tbody>';
		$this->numFilas = 0;
	}

	private function obtenerEncabezado($alias){
		$head = '<table id="'.$alias.'" class="table table-bordered table-striped table-hover"><thead>';
		$head .= '<tr class="headGrid"><th width="15"><input type="checkbox" id="'.$alias.'_masterCheck" g:total="{numRows}" onClick="gridCheck.masterCheckToggle(\''.$alias.'\')" /></th><th width="15">#</th>';
		return $head;
	}


	public function nuevaFila($fila){
		if(!array_key_exists("id",$fila) || !array_key_exists("valores",$fila)) return false;

		$idFila = $fila["id"];
		$valores = $fila["valores"];

		$this->numFilas++;
		$this->cuerpo .= '<tr>';
		$this->cuerpo .= '<td><input type="checkbox" id="'.$this->alias.'_row_'.$this->numFilas.'" g:id="'.$idFila.'" /></td>';
		$this->cuerpo .= '<td>'.$this->numFilas.'</td>';
		for($i = 0 ; $i < $this->numColumnas ; $i++){
			if(array_key_exists($i,$valores)){
				$this->cuerpo .= '<td>'.$valores[$i].'</td>';
			}
		}
		$this->cuerpo .= '</tr>';
	}

	public function obtenerCodigo(){
		
		$this->cuerpo .= '</tbody></table>';

		$this->cuerpo = str_replace("{numRows}",$this->numFilas,$this->cuerpo);

		return $this->cuerpo;
	}

	


}










class Configuracion{
	private $duracionDefecto = 40;
	private $inicioDefecto = 1379854800;
	private $finDefecto = 1379887200;
	private $empresaDefecto = "Sistema de Control de Citas";
	private $nombreDefecto = "Consultorio";
	private $urlArchivo = "libs/config/main.conf";
	private $configuracion;
	//--
	public function __construct(){
		if(strpos($_SERVER["PHP_SELF"],"stores") !== false){ $this->urlArchivo = "../".$this->urlArchivo; }
		if(!file_exists($this->urlArchivo)){
			$this->inicializarArchivo();
		}

		$this->configuracion = $this->retornarArchivo();
	}

	public function obtenerConfiguracion(){ return $this->configuracion; }
	public function guardarConfiguracion($conf){
		if(!$this->guardar($conf)){
			echo "Error guardando";
		}
	}
	


	private function inicializarArchivo(){
		if(file_exists($this->urlArchivo)) return false;

		$conf = array(
			"nombreEmpresa"=>$this->empresaDefecto,
			"nombreSistema"=>$this->nombreDefecto,
			"horaInicio"=>$this->inicioDefecto,
			"horaFin"=>$this->finDefecto,
			"duracion"=>$this->duracionDefecto
		);

		$this->guardar($conf);
		
	}


	private function guardar($conf){
		if(gettype($conf)!="array") return false;
		$contenido = json_encode($conf);
		if(!file_exists($this->urlArchivo)){
			$archivo = fopen($this->urlArchivo, 'w');
			fwrite($archivo, $contenido);
			fclose($archivo);
		}else{
			file_put_contents($this->urlArchivo,$contenido);
		}
		return true;
	}

	private function retornarArchivo(){
		if(file_exists($this->urlArchivo)) $this->inicializarArchivo(); 
		$contenido = file_get_contents($this->urlArchivo);
		return json_decode($contenido,true);
	}

	
}


?>