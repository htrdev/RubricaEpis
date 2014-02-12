<?php

header('Content-type: application/json');

require_once('Conexion.php');

class ResultadoAprendizaje{

	private $conexion;

	public function __construct(){
		$this->conexion = ConexionFactory::obtenerConexion('mysql','192.168.1.35','htrdev','12345');
	}

	public function listarCriterioAprendizaje($idResultadoAprendizaje){
		$query = "SELECT  c.idCriterioEvaluacion,c.descripcionCriterioEvaluacion,c.ResultadoAprendizaje_idResultadoAprendizaje 
					FROM criterioevaluacion as c WHERE c.ResultadoAprendizaje_idResultadoAprendizaje = '".$idResultadoAprendizaje."'";
		return $this->conexion->realizarConsulta($query);
	}

	public function listarResultadoAprendizaje(){

		$query = "SELECT  r.idResultadoAprendizaje, r.codigoResultadoAprendizaje , r.tituloResultadoAprendizaje  FROM resultadoaprendizaje as r";
		$resultadosAprendizaje = $this->conexion->realizarConsulta($query);
		$resultado = array();
		$contadorResultado = 0;
		foreach($resultadosAprendizaje as $resultadoAprendizaje){
			$idResultadoAprendizaje = $resultadoAprendizaje["idResultadoAprendizaje"];
			$criteriosAprendizaje = $this->listarCriterioAprendizaje($idResultadoAprendizaje);
			$resultado[$contadorResultado] = 
				array("tituloResultadoAprendizaje"=>$resultadoAprendizaje["tituloResultadoAprendizaje"],
					"codigoResultadoAprendizaje"=>$resultadoAprendizaje["codigoResultadoAprendizaje"],
					"criteriosEvaluacion"=>$criteriosAprendizaje); 
			$contadorResultado++;
		}
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
		$this->conexion = ConexionFactory::obtenerConexion('mysql','localhost','htrdev','12345');
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
