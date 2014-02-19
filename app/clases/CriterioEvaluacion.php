<?php

header('Content-type: application/json');

require_once('Conexion.php');

class CriterioEvaluacion{


	private $conexion;

	public function __construct(){
		$this->conexion = ConexionFactory::obtenerConexion('mysql','localhost','htrdev','12345');
	}

	public function agregarCriterioEvaluacion($criterioEvaluacion,$idResultadoAprendizaje){
		$query = "INSERT into criterioevaluacion (descripcionCriterioEvaluacion, ResultadoAprendizaje_idResultadoAprendizaje) 
		values";
		$numeroElementos = count($criterioEvaluacion);
		$i = 0;
		foreach($criterioEvaluacion as $criterio){
			$query.= "('".$criterio["descripcionCriterioEvaluacion"]."','".$idResultadoAprendizaje."')";
			if(++$i == $numeroElementos){
				$query.=";";
			}
			else{
				$query.=",";
			}
		}
		$funciono = $this->conexion->realizarConsulta($query,false);
		return $funciono;		
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
