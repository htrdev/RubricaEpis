<?php

class CalificacionCriterioEvaluacion extends Master{
	//QUERYS

	public function queryAgregarCalificacionCriterioEvaluacion($idResultadoRubrica,$criterioEvaluacion){
		$query .= 
				"INSERT INTO CalificacionCriterioEvaluacion(
					idResultadoRubrica
					,CalificacionCriterioEvaluacion
					,idAsignacionCriterioEvaluacion) 
				VALUES('".$idResultadoRubrica."','".$criterioEvaluacion["calificacion"]."','".$criterioEvaluacion["idAsignacionCriterioEvaluacion"]."');";
		return $query;
	}

	//METODOS 

	public function obtenerArrayCriteriosEvaluacionDeResultadoAprendizaje($resultadosAprendizaje){
		$criteriosEvaluacion = array();
		foreach ($resultadosAprendizaje as $resultadoAprendizaje) {
			foreach($resultadoAprendizaje as $criterioEvaluacion){
				$criteriosEvaluacion[] = $criterioEvaluacion;
			}
		}
		return $criteriosEvaluacion;
	}

	public function agregarCalificacionCriterioEvaluacion($idResultadoRubrica,$resultadosAprendizaje){
		$criteriosEvaluacion = $this->obtenerArrayCriteriosEvaluacionDeResultadoAprendizaje($resultadosAprendizaje);
		$queryMultiple = "";
		foreach($criteriosEvaluacion as $criterioEvaluacion){
			$queryMultiple .= $this->queryAgregarCalificacionCriterioEvaluacion($idResultadoRubrica,$criterioEvaluacion);
		}
		$this->conexionSqlServer->realizarConsulta($queryMultiple,false);
	}

}
