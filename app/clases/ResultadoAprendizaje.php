<?php

header('Content-type: application/json');

require_once('Conexion.php');

class ResultadoAprendizaje{

	private $conexion;

	public function __construct(){
		$this->conexion = ConexionFactory::obtenerConexion('mysql');
	}

	public function listarResultadoAprendizaje(){
		$query = "SELECT * FROM ResultadoAprendizaje";
		$resultado = $this->conexion->realizarConsulta($query);
		$resultadoJson = $this->conexion->convertirJson($resultado);
		return $resultadoJson;
	}

	public function agregarResultadoAprendizaje(){
		$definicion = $_POST['txtDefinicion'];
		$titulo = $_POST['txtTitulo'];
		$query = "INSERT INTO ResultadoAprendizaje(definicionResultadoAprendizaje,tituloResultadoAprendizaje) VALUES('".$definicion."','".$titulo."')";
		$resultado = $this->conexion->realizarConsulta($query);
		
	}

	public function modificarResultadoAprendizaje(){

	}

}

class ResultadoAprendizajeDocente extends ResultadoAprendizaje{
	public function agregarResultadoAprendizajeDocente(){

	}

	public function modificarResultadoAprendizajeDocente(){
		
	}
}


$objetoRA = new ResultadoAprendizaje();
echo $objetoRA->agregarResultadoAprendizaje();
