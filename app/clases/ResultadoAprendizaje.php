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

	private $conexion;

	public function __construct(){
		$this->conexion = ConexionFactory::obtenerConexion('mysql');
	}

	public function agregarResultadoAprendizajeDocente(){

	}

	public function modificarResultadoAprendizajeDocente(){
		
	}

	public function ResultadoAprendizajePorDocente(){
		$docente = $_POST['txtDocente'];
		$query = "select d.ResultadoAprendizaje_idResultadoAprendizaje, c.definicionResultadoAprendizaje, c.tituloResultadoAprendizaje from   resultadoaprendizaje as c inner join resultadoaprendizajedocente as d on d.ResultadoAprendizaje_idResultadoAprendizaje = c.idResultadoAprendizaje where d.Docente_Persona_idPersona ='".$docente."'";
		$resultado = $this->conexion->realizarConsulta($query);
		$resultadoJson = $this->conexion->convertirJson($resultado);
		return $resultadoJson;	



	}


}


$objetoRA = new ResultadoAprendizajeDocente();
echo $objetoRA->ResultadoAprendizajePorDocente();

