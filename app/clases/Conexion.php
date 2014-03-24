<?php

require_once('Singleton.php');

class ConexionFactory{

	public static function obtenerConexion($tipoConexion){
		$conexion = "h1";
		switch($tipoConexion)
		{
			case 'sqlserver' : $conexion = ConexionSQLServer::obtenerObjeto();break;
			case 'mysql' : $conexion = ConexionMySQL::obtenerObjeto();break;
		}
		return $conexion;
	}
}

abstract class Conexion extends Singleton{

	protected $conexion;

	protected $servidor;
	protected $usuario;
	protected $password;
	protected $baseDeDatos;
	protected $returnId;

	public abstract function obtenerConexion();
	protected abstract function convertirArray($resultado);
	public abstract function convertirJson($array);

	public function obtenerVariableSesion($variable){
		session_start();
		return $_SESSION[$variable];
	} 

	public function returnId(){
		$this->returnId = true;
		return $this;
	}
}


class ConexionSQLServer extends Conexion{

	protected function __construct(){
		$this->servidor = 'localhost';
		$this->usuario	= 'sa';
		$this->password = 'redman10';
		$this->baseDeDatos = "matrixupt";
		$this->obtenerConexion();
	}

	public function obtenerConexion(){
		 $this->conexion = mssql_connect($this->servidor,$this->usuario,$this->password) or die(mssql_get_last_message());
       	 mssql_select_db($this->baseDeDatos,$this->conexion);
	}

	public function realizarConsulta($sql,$convertirArray){
		$resultado =  mssql_query($sql,$this->conexion);
		if($convertirArray){
			return $this->convertirArray($resultado);
		}
		else
		{
			return $resultado;
		}
	}

	protected function convertirArray($resultado){
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

	protected function __construct(){
		$this->servidor = 'epis.upt.edu.pe';
		$this->usuario	= 'urubrica';
		$this->password = 'rubrica%789.';
		$this->baseDeDatos = "rubricaepis";
		$this->obtenerConexion();
	}

	public function obtenerConexion(){

        $this->conexion = mysql_connect($this->servidor,$this->usuario,$this->password) or die(mysql_error());

        mysql_select_db($this->baseDeDatos,$this->conexion);
   
	}

	public function realizarConsulta($sql,$convertirArray){
		$resultado =  mysql_query($sql,$this->conexion);
		if(!$resultado){
			header("HTTP/1.1 500 Internal Server Error");
			return $resultado;
		}
		else{
			if($convertirArray){
				$resultadoArray = $this->convertirArray($resultado);
				return $resultadoArray;
			}
			else{
				if($this->returnId){
					$this->returnId = false;
					return mysql_insert_id();
				}
				return $resultado;
			}
		}
	}

	protected function convertirArray($resultado){
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
		mysql_query("SET AUTOCOMMIT=0",$this->conexion);
		mysql_query("START TRANSACTION",$this->conexion);
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
			mysql_query("COMMIT",$this->conexion);
			return true;
		}
		else{
			mysql_query("ROLLBACK",$this->conexion);
			header("HTTP/1.1 500 Internal Server Error");
			return false;
		}
	}
}

?>