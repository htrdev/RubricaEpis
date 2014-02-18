<?php

header('Content-type: application/json');

require_once('Conexion.php');

class CriterioEvaluacion{


	private $conexion;

	public function __construct(){
		$this->conexion = ConexionFactory::obtenerConexion('mysql','localhost','htrdev','12345');
	}



	public function agregarCriterioEvaluacion($CriterioEvaluacion){
		$query = "INSERT into criterioevaluacion (descripcionCriterioEvaluacion, ResultadoAprendizaje_idResultadoAprendizaje) 
		values ('".$CriterioEvaluacion["descripcionCriterio"]."', '".$CriterioEvaluacion["ResultadoAprendizaje_idResultadoAprendizaje"]."')";
		$resultado = $this->conexion->realizarConsulta($query,false);
		return $resultado;
	}

	public function modificarCriterioEvaluacion($CriterioEvaluacion){
	

		$query = "update criterioevaluacion set descripcionCriterioEvaluacion='".$CriterioEvaluacion["descripcionCriterioEvaluacion"]."',ResultadoAprendizaje_idResultadoAprendizaje='".$CriterioEvaluacion["ResultadoAprendizaje_idResultadoAprendizaje"]."'
		 where idCriterioEvaluacion='".$CriterioEvaluacion["idCriterioEvaluacion"]."'";
		$resultado = $this->conexion->realizarConsulta($query,false);
		$resultadoJson = $this->conexion->convertirJson($resultado);
		return $resultadoJson;
	}


	public function listarCriterioEvaluacionPorResultadoAprendizaje(){

	}


	public function listarCriterioEvaluacionPorModeloRubrica(){
		
	}

}
