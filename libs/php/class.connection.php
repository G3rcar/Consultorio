<?php

class Conexion{
	private $link;
	private $bd = "consultorio";
	private $server = "localhost";
	//private $server = "mysql17.000webhost.com";
	//private $server = "192.168.56.15";
	private $user = "root";
	//private $user = "a7386860_admin";
	//private $user = "dbadmin";
	private $pass = "";
	//private $pass = "pr0gr4adm0n";
	//private $pass = "8%(/H#U&Ce5zbvy";

	//--
	public function __construct(){
		$this->link = mysql_connect($this->server,$this->user,$this->pass);
		mysql_select_db($this->bd,$this->link);
	}
	public function destroyConnection(){
		mysql_close();
	}


	public function execSelect($q){
		$r = mysql_query($q,$this->link);
		$n = $this->numRows($r);
		if(mysql_errno($this->link)!=0){ echo "<br/>ERROR (".mysql_errno($this->link)."): ".$q; exit(); }
		return array("result"=>$r,"num"=>(int)$n);
	}
	public function execManto($q){
		$r = mysql_query($q,$this->link);
		if(mysql_errno($this->link)!=0){ echo "<br/>ERROR (".mysql_errno($this->link)."): ".$q; exit(); }
		return (int)mysql_affected_rows($this->link);
	}

	public function escape($t){
		return strip_tags(mysql_real_escape_string($t));
	}
	public function numRows($r){
		return mysql_num_rows($r);
	}
	public function fetchArray($r){
		return mysql_fetch_array($r);
	}
	public function lastId(){
		return mysql_insert_id($this->link);
	}
	
	//-- TRANSACTIONS
	public function startTransaction(){
		mysql_query("START TRANSACTION",$this->link);
	}
	public function rollback(){
		mysql_query("ROLLBACK",$this->link);
	}
	public function commit(){
		mysql_query("COMMIT",$this->link);
	}
	//--
}

?>