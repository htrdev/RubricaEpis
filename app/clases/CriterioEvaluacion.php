<?php

header('Content-type: application/json');

require_once('Conexion.php');

class CriterioEvaluacion{


	private $conexion;

	public function __construct(){
		$this->conexion = ConexionFactory::obtenerConexion('mysql','192.168.1.35','htrdev','12345');
	}



	public function agregarCriterioEvaluacion(){


		$descripcionCriterio = $_POST['txtDescripcion'];
		$ResultadoAprendizaje = $_POST['txtResultadoAprendisaje'];
		$query = "INSERT into criterioevaluacion (descripcionCriterioEvaluacion, ResultadoAprendizaje_idResultadoAprendizaje) values ('".$descripcionCriterio."', '".$ResultadoAprendizaje."')";
		$resultado = $this->conexion->realizarConsulta($query);
		$resultadoJson = $this->conexion->convertirJson($resultado);
		return $resultadoJson;


	}

	public function listarCriterioEvaluacion(){

	}

	public function listarCriterioEvaluacionPorResultadoAprendizaje(){

	}

	public function modificarCriterioEvaluacion(){

	}

	public function listarCriterioEvaluacionPorModeloRubrica(){
		
	}

}


$objetoModeloRubrica = new CriterioEvaluacion();
echo $objetoModeloRubrica->agregarCriterioEvaluacion();