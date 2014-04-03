<?php

class CriterioEvaluacion extends Master{

	//QUERYS

	public function queryAgregarCriterioEvaluacion($idResultadoAprendizaje,$criterio){
		$query =
		"INSERT INTO CriterioEvaluacion(
			descripcionCriterioEvaluacion
			,idResultadoAprendizaje) 
		VALUES(
			'".$criterio["descripcionCriterioEvaluacion"]."'
			,'".$idResultadoAprendizaje."');";
		return $query;
	}

	public function queryCriteriosEvaluacionPorResultadoAprendizaje($idResultadoAprendizaje){
		$query = 
		"SELECT idCriterioEvaluacion
				,descripcionCriterioEvaluacion
		FROM CriterioEvaluacion
			WHERE idResultadoAprendizaje = '".$idResultadoAprendizaje."'";
		return $query;
	}

	//METODOS

	public function agregarCriteriosEvaluacion($criteriosEvaluacion,$idResultadoAprendizaje){
		foreach($criteriosEvaluacion as $criterioEvaluacion){
			$this->conexionSqlServer->realizarConsulta($this->queryAgregarCriterioEvaluacion($idResultadoAprendizaje,$criterioEvaluacion));
		}
	}

	public function listarCriteriosEvaluacionPorResultadoAprendizaje($idResultadoAprendizaje){
		return $this->conexionSqlServer->realizarConsulta($this->queryCriteriosEvaluacionPorResultadoAprendizaje($idResultadoAprendizaje),true);
	}

	public function listarCriterioEvaluacionPorId($idCriterioEvaluacion){
		$query =
		"SELECT c.descripcionCriterioEvaluacion,r.codigoResultadoAPrendizaje+' '+r.tituloResultadoAprendizaje AS tituloResultadoAprendizaje
		FROM criterioEvaluacion AS c
		INNER JOIN resultadoaprendizaje AS r
			ON c.idResultadoAprendizaje = r.idResultadoAprendizaje AND c.idCriterioEvaluacion ='".$idCriterioEvaluacion."'";
		$resultado = $this->conexionSqlServer->realizarConsulta($query,true);
		return $resultado[0];
	}

}


