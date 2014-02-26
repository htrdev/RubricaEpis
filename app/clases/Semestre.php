<?php

header('Content-type: application/json');

require_once('Conexion.php');

class Semestre extends Singleton{

	private $conexion;

	public function __construct(){
		$this->conexion = ConexionFactory::obtenerConexion('sqlserver');
	}

	public function listarSemestre(){
		$usuario = $this->conexion->realizarConsulta("SELECT * FROM SEMESTRE",true);
		$resultado = $this->conexion->convertirJson($usuario);
		return $resultado;
	}

	public function listarSemestreActivo(){
		$resultado = $this->conexion->realizarConsulta("SELECT * FROM SEMESTRE WHERE Activo = '1'",true);
		return $resultado;
	}
}

?>