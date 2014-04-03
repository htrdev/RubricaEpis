<?php

class ResultadoAprendizaje extends Master{

	//QUERYS

	protected function queryAgregarResultadoAprendizaje($resultadoAprendizaje){
		$query = 
		"INSERT INTO ResultadoAprendizaje(
			definicionResultadoAprendizaje
			,tituloResultadoAprendizaje
			,tipoResultadoAprendizaje)
		VALUES(
			'".$resultadoAprendizaje["definicionResultadoAprendizaje"]."'
			,'".$resultadoAprendizaje["tituloResultadoAprendizaje"]."'
			,'Docente')";
		return $query;
	}

	protected function queryListarResultadoAprendizaje(){
		$query = 
			"SELECT idResultadoAprendizaje
					,codigoResultadoAprendizaje 
					,tituloResultadoAprendizaje 
					,definicionResultadoAprendizaje   
			FROM resultadoaprendizaje 
			WHERE tipoResultadoAprendizaje = 'Escuela'";
		return $query;
	}


	//METODOS

	public function listarResultadoAprendizajeConCriteriosEvaluacion(){
		$resultadosAprendizaje = $this->conexionSqlServer->realizarConsulta($this->queryListarResultadoAprendizaje(),true);
		foreach($resultadosAprendizaje as &$resultadoAprendizaje){
			$resultadoAprendizaje["criteriosEvaluacion"] = CriterioEvaluacion::obtenerObjeto()->listarCriteriosEvaluacionPorResultadoAprendizaje($resultadoAprendizaje["idResultadoAprendizaje"]);
		}
		return $resultadosAprendizaje;
	}

	public function obtenerResultadosAprendizaje(){
		//1ER NIVEL
		$resultado = array(
			 "resultadosAprendizaje"=>$this->listarResultadoAprendizajeConCriteriosEvaluacion(),
			 "resultadosAprendizajeDocente"=>ResultadoAprendizajeDocente::obtenerObjeto()->listarResultadoAprendizajeDocenteConCriteriosEvaluacion());
		return $resultado;
	}
}

class ResultadoAprendizajeDocente extends ResultadoAprendizaje{

	//QUERYS

	public function queryAgregarResultadoAprendizajeDocente($idResultadoAprendizaje){
		$idDocente = $this->conexionSqlServer->obtenerVariableSesion("CodPer");
		$query = 
		"INSERT INTO ResultadoAprendizajeDocente(
			idResultadoAprendizaje
			,idDocente) 
			VALUES(
			'".$idResultadoAprendizaje."'
			,'".$idDocente."')";
		return $query;
	}

	public function queryListarResultadoAprendizajeDocente(){
		$idDocente = $this->conexionSqlServer->obtenerVariableSesion("CodPer");
		$query =
		"SELECT 
			idResultadoAprendizaje 
			,codigoResultadoAprendizaje 
			,tituloResultadoAprendizaje 
			,definicionResultadoAprendizaje  
		FROM resultadoaprendizaje
		WHERE idResultadoAprendizaje
			IN (SELECT 
					idResultadoAprendizaje 
						FROM resultadoaprendizajedocente
						WHERE idDocente = '".$idDocente."'
				)";
		return $query;
	}

	//METODOS

	public function listarResultadoAprendizajeDocente(){
		//2DO NIVEL
		$resultado = $this->conexionSqlServer->realizarConsulta($this->queryListarResultadoAprendizajeDocente(),true);	
		return $resultado;
	}

	public function agregarResultadoAprendizajeDocente($resultadoAprendizaje){
		//1ER NIVEL
		$this->conexionSqlServer->iniciarTransaccion();
		try{
			$idResultadoAprendizaje = $this->conexionSqlServer->returnId()->realizarConsulta($this->queryAgregarResultadoAprendizaje($resultadoAprendizaje));
			$this->conexionSqlServer->realizarConsulta($this->queryAgregarResultadoAprendizajeDocente($idResultadoAprendizaje));
			CriterioEvaluacion::obtenerObjeto()->agregarCriteriosEvaluacion($resultadoAprendizaje["criteriosEvaluacion"],$idResultadoAprendizaje);
			$this->conexionSqlServer->commit();
		}catch(PDOException $ex){
			$this->conexionSqlServer->rollback();
			throw new PDOException($ex->getMessage());
		}
		
	}

	public function listarResultadoAprendizajeDocenteConCriteriosEvaluacion(){
		//2DO NIVEL
		$resultadosAprendizajeDocente = $this->listarResultadoAprendizajeDocente();
		foreach($resultadosAprendizajeDocente as &$resultadoAprendizajeDocente){
			$resultadoAprendizajeDocente["criteriosEvaluacion"] = CriterioEvaluacion::obtenerObjeto()->listarCriteriosEvaluacionPorResultadoAprendizaje($resultadoAprendizajeDocente["idResultadoAprendizaje"]);
		}
		return $resultadosAprendizajeDocente;
	}
}
