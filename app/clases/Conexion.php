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
}

class ConexionSQLServer extends Conexion{

	private function __construct($host,$usuario,$password){
		$this->servidor = $host;
		$this->usuario	= $usuario;
		$this->password = $password;
		$this->baseDeDatos = "test123";
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

	public function realizarConsulta($sql){
		$this->obtenerConexion();
		$resultado =  mssql_query($sql,$this->conexion);
		return $this->convertirArray($resultado);
	}

	private function convertirArray($resultado){
		$objetos = array();
		while($r = mssql_fetch_assoc($resultado)) {
		    $objetos[] = $r;
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

	public function realizarConsulta($sql){
		$this->obtenerConexion();
		$resultado =  mysql_query($sql,$this->conexion);
		return $this->convertirArray($resultado);
	}



	private function convertirArray($resultado){
		$objetos = array();
		while($r = mysql_fetch_assoc($resultado)) {
		    $objetos[] = $r;
		}
		return $objetos;
	}

	public function convertirJson($array){
		return json_encode($array);
	}
}



?>