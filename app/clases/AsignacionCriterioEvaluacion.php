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

	//METODOS

	public function agregarAsignacionCriterioEvaluacion($idModeloRubrica,$criteriosEvaluacion){
		$queryMultiple = "";
		foreach($criteriosEvaluacion as $idCriterioEvaluacion){
			$queryMultiple .= $this->queryAgregarAsignacionCriterioEvaluacion($idModeloRubrica,$idCriterioEvaluacion);
		}
		$this->conexionSqlServer->realizarConsulta($queryMultiple,false);
	}

	public function listarAsignacionCriterioEvaluacionPorModeloRubrica($idModeloRubrica){
		$query = 
		"SELECT A.idCriterioEvaluacion AS idCriterioEvaluacion
				,A.idAsignacionCriterioEvaluacion
			FROM asignacioncriterioevaluacion AS A 
				WHERE A.idModeloRubrica = '".$idModeloRubrica."'";
		return $this->conexionSqlServer->realizarConsulta($query,true);
	}
}
