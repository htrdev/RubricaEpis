<?php


class ConexionFactory{

	public function obtenerConexion($tipoConexion,$host,$usuario,$password){
		$conexion = "h1";
		switch($tipoConexion)
		{
			case 'sqlserver' : $conexion = ConexionSQLServer::obtenerObjeto($host,$usuario,$password);break;
			case 'mysql' : $conexion = ConexionMySQL::obtenerObjeto($host,$usuario,$password);break;
		}
		return $conexion;
	}
}

abstract class Conexion{

	protected $conexion;
	protected static $objetoConexion;

	protected $servidor;
	protected $usuario;
	protected $password;
	protected $baseDeDatos;

	public abstract static function obtenerObjeto($host,$usuario,$password);
	public abstract function obtenerConexion();
	public function obtenerVariableSesion($variable){
		session_start();
		return $_SESSION[$variable];
	} 
}

class ConexionSQLServer extends Conexion{

	private function __construct($host,$usuario,$password){
		$this->servidor = $host;
		$this->usuario	= $usuario;
		$this->password = $password;
		$this->baseDeDatos = "matrixupt";
	}

	public static function obtenerObjeto($host,$usuario,$password){
		if(!self::$objetoConexion instanceof self)
		{
			self::$objetoConexion = new self($host,$usuario,$password);
		}
		return self::$objetoConexion;
	}

	public function obtenerConexion(){
		 $this->conexion = mssql_connect($this->servidor,$this->usuario,$this->password) or die(mssql_get_last_message());
        //}
        mssql_select_db($this->baseDeDatos,$this->conexion);
	}

	public function realizarConsulta($sql,$convertirArray){
		$this->obtenerConexion();
		$resultado =  mssql_query($sql,$this->conexion);
		if($convertirArray){
			return $this->convertirArray($resultado);
		}
		else
		{
			return $resultado;
		}
	}

	private function convertirArray($resultado){
		$objetos = array();
		while($r = mssql_fetch_assoc($resultado)) {
		    $objetos[] = array_map('utf8_encode', $r);
		}
		return $objetos;
	}

	public function convertirJson($array){
		return json_encode($array);
	}
}

class ConexionMySQL extends Conexion{

	private function __construct($host,$usuario,$password){
		$this->servidor = $host;
		$this->usuario	= $usuario;
		$this->password = $password;
		$this->baseDeDatos = "rubricaepis";
	}

	public static function obtenerObjeto($host,$usuario,$password){
		if(!self::$objetoConexion instanceof self)
		{
			self::$objetoConexion = new self($host,$usuario,$password);
		}
		return self::$objetoConexion;
	}

	public function obtenerConexion(){
	//	if(!is_null($this->conexion)){
        $this->conexion = mysql_connect($this->servidor,$this->usuario,$this->password) or die(mysql_error());
        //}
        mysql_select_db($this->baseDeDatos,$this->conexion);
       // return $this->conexion;
	}

	public function realizarConsulta($sql,$convertirArray){
		$this->obtenerConexion();
		$resultado =  mysql_query($sql,$this->conexion);
		if($convertirArray){
			return $this->convertirArray($resultado);
		}
		else
		{
			return $resultado;
		}
	}

	private function convertirArray($resultado){
		$objetos = array();
		while($r = mysql_fetch_assoc($resultado)) {
		    $objetos[] = array_map('utf8_encode', $r);
		}
		return $objetos;
	}

	public function convertirJson($array){
		return json_encode($array);
	}

	public function iniciarTransaccion(){
		mysql_query("SET AUTOCOMMIT=0"$this->conexion);
		mysql_query("START TRANSACTION"$this->conexion);
	}

	public function finalizarTransaccion($confirmaciones){
		$esCorrecto = true;
		foreach($confirmaciones as $confirmacion){
			if(!$confirmacion){
				$esCorrecto = false;
				break;
			}
		}

		if($esCorrecto){
			mysql_query("COMMIT");
		}
		else{
			mysql_query("ROLLBACK");
		}
		return $esCorrecto;
	}
}



?>