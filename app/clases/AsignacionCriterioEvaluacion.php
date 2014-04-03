<?php

class AsignacionCriterioEvaluacion extends Master{

	//QUERY 
	public function queryAgregarAsignacionCriterioEvaluacion($idModeloRubrica,$idCriterioEvaluacion){
		$query = 
			"INSERT INTO asignacionCriterioEvaluacion(
				idModeloRubrica
				,idCriterioEvaluacion)
			VALUES(
				'".$idModeloRubrica."'
				,'".$idCriterioEvaluacion."');";
		return $query;
	}

	public function queryListarAsignacionCriterioEvaluacionPorModeloRubrica($idModeloRubrica){
		$query = 
		"SELECT C.descripcionCriterioEvaluacion
				,R.codigoResultadoAprendizaje+' '+R.tituloResultadoAprendizaje AS resultadoAprendizaje
				,A.idAsignacionCriterioEvaluacion
			FROM asignacioncriterioevaluacion AS A 
			INNER JOIN CriterioEvaluacion AS C
				ON C.idCriterioEvaluacion = A.idCriterioEvaluacion
			INNER JOIN ResultadoAprendizaje as R
				ON R.idResultadoAprendizaje = C.idResultadoAprendizaje
				WHERE A.idModeloRubrica = '".$idModeloRubrica."'";
		return $query;
	}

	//METODOS

	public function agregarAsignacionCriterioEvaluacion($idModeloRubrica,$criteriosEvaluacion){
		$queryMultiple = "";
		foreach($criteriosEvaluacion as $idCriterioEvaluacion){
			$queryMultiple .= $this->queryAgregarAsignacionCriterioEvaluacion($idModeloRubrica,$idCriterioEvaluacion);
		}
		$this->conexionSqlServer->realizarConsulta($queryMultiple,false);
	}

	public function listarAsignacionCriterioEvaluacionPorModeloRubrica($idModeloRubrica){
		
		return $this->conexionSqlServer->realizarConsulta($this->queryListarAsignacionCriterioEvaluacionPorModeloRubrica($idModeloRubrica),true);
	}
}
