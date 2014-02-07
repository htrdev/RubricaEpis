<?php

header('Content-type: application/json');

require_once('Conexion.php');

class Semestre{

	private $conexion;

	public function __construct(){
		$this->conexion = ConexionFactory::obtenerConexion('sqlserver','192.168.1.38','sa','123cuatro');
	}

	public function listarSemestre(){
		$usuario = $this->conexion->realizarConsulta("SELECT * FROM SEMESTRE");
		$resultado = $this->conexion->convertirJson($usuario);
		return $resultado;
	}

	public function listarSemestreActivo(){
		$usuario = $this->conexion->realizarConsulta("SELECT * FROM SEMESTRE WHERE Activo = '1'");
		$resultado = $this->conexion->convertirJson($usuario);
		return $resultado;
	}
}

?>