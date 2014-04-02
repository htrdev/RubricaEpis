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

	// public function listarCriterioAprendizaje($idResultadoAprendizaje){
	// 	$query = "SELECT  c.idCriterioEvaluacion,c.descripcionCriterioEvaluacion,c.idResultadoAprendizaje 
	// 				FROM criterioevaluacion as c WHERE c.idResultadoAprendizaje = '".$idResultadoAprendizaje."'";
	// 	return $this->conexionSqlServer->realizarConsulta($query,true);
	// }

	// public function listarResultadoAprendizajePorID($resultadoAprendizaje){
		
	// 	$query="select r.idResultadoAprendizaje,r.codigoResultadoAprendizaje,
	// 	r.tituloResultadoAprendizaje,r.definicionResultadoAprendizaje from resultadoaprendizaje as r
	// 	where r.idResultadoAprendizaje='".$resultadoAprendizaje['idResultadoAprendizaje']."'";


	// 	$resultadoaprendizaporid = $this->conexionSqlServer->realizarConsulta($query,true);
		
		
	// 	$query2 = "select idCriterioEvaluacion, descripcionCriterioEvaluacion  from resultadoaprendizaje as r 
	// 	inner join criterioevaluacion as c on c.idResultadoAprendizaje=r.idResultadoAprendizaje
	// 	where r.idResultadoAprendizaje ='".$resultadoaprendizaporid[0]["idResultadoAprendizaje"]."'";
	// 	$criteriosEvaluacion = $this->conexionSqlServer->realizarConsulta($query2,true);

		
	// 	$resultado=
	// 	array('idResultadoAprendizaje ' => $resultadoaprendizaporid[0]["idResultadoAprendizaje"] ,
	// 		'codigoResultadoAprendizaje ' => $resultadoaprendizaporid[0]["codigoResultadoAprendizaje"] ,
	// 		'tituloResultadoAprendizaje ' => $resultadoaprendizaporid[0]["tituloResultadoAprendizaje"] ,
	// 		'definicionResultadoAprendizaje ' => $resultadoaprendizaporid[0]["definicionResultadoAprendizaje"] ,
	// 		'criteriosEvaluacion' =>$criteriosEvaluacion);	

	// 	$resultadoJson = $this->conexionSqlServer->convertirJson($resultado);
	// 	return $resultadoJson;	
	// }

	// public function agregarResultadoAprendizaje($resultadoAprendizaje){
	// }
	
	// public function modificarResultadoAprendizaje($ResultadoAprendizaje){
		
	// 	$this->conexionSqlServer->iniciarTransaccion();
	// 	$query = "update ResultadoAprendizaje set
	// 	definicionResultadoAprendizaje='".$ResultadoAprendizaje["definicionResultadoAprendizaje"]."',
	// 	tituloResultadoAprendizaje='".$ResultadoAprendizaje["tituloResultadoAprendizaje"]."', 
	// 	codigoResultadoAprendizaje='".$ResultadoAprendizaje["codigoResultadoAprendizaje"]."',
	// 	tipoResultadoAprendizaje='".$ResultadoAprendizaje["tipoResultadoAprendizaje"]."'
		
	// 	where idResultadoAprendizaje='".$ResultadoAprendizaje["idResultadoAprendizaje"]."'";

	// 	$resultadoModificarResultadoAprendizaje = $this->conexionSqlServer->realizarConsulta($query,false); 

	// 	$resultado=array();
	// 	$resultado[]=$resultadoModificarResultadoAprendizaje;

	// 	if(!empty($ResultadoAprendizaje["criteriosEvaluacionBorrados"])){
	// 	foreach ($ResultadoAprendizaje["criteriosEvaluacion"]   as $idCriterioEvaluacion) {

	// 		$queryCriterio = "update criterioevaluacion set
	// 	descripcionCriterioEvaluacion='".$idCriterioEvaluacion["descripcionCriterioEvaluacion"]."'
	// 	where idCriterioEvaluacion='".$idCriterioEvaluacion["idCriterioEvaluacion"]."'";

	// 	$funionoActualizarCriterioEvaluacion=$this->conexionSqlServer->realizarConsulta($queryCriterio,false);

	// 	$resultado[]=$funionoActualizarCriterioEvaluacion;

	// 	}
  
	// 	$this->conexionSqlServer->finalizarTransaccion($resultado);


	// 	}
	// 	if(!empty($ResultadoAprendizaje["criteriosEvaluacionBorrados"])){
	// 	foreach ($ResultadoAprendizaje["criteriosEvaluacionBorrados"]   as $idCriterioEvaluacion) {

	// 		$queryCriterio = "delete from criterioevaluacion
	// 		where idCriterioEvaluacion ='".$idCriterioEvaluacion["idCriterioEvaluacion"]."'";


	// 	$funcionoEliminarCriteriosEvaluacion=$this->conexionSqlServer->realizarConsulta($queryCriterio,false);
	// 	$resultado[]=$funcionoEliminarCriteriosEvaluacion;

	// 	}
	// }
	// 	$this->conexionSqlServer->finalizarTransaccion($resultado);

	// }

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
