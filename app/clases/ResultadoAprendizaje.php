<?php

header('Content-type: application/json');

require_once('Conexion.php');
require_once('CriterioEvaluacion.php');

class ResultadoAprendizaje extends Singleton{

	private $conexionSqlServer;

	protected function __construct(){
		$this->conexionSqlServer = ConexionFactory::obtenerConexion('sqlserver');
	}

	public function listarCriterioAprendizaje($idResultadoAprendizaje){
		$query = "SELECT  c.idCriterioEvaluacion,c.descripcionCriterioEvaluacion,c.idResultadoAprendizaje 
					FROM criterioevaluacion as c WHERE c.idResultadoAprendizaje = '".$idResultadoAprendizaje."'";
		return $this->conexionSqlServer->realizarConsulta($query,true);
	}

	public function listarResultadoAprendizajePorID($resultadoAprendizaje){

		
		$query="select r.idResultadoAprendizaje,r.codigoResultadoAprendizaje,
		r.tituloResultadoAprendizaje,r.definicionResultadoAprendizaje from resultadoaprendizaje as r
		where r.idResultadoAprendizaje='".$resultadoAprendizaje['idResultadoAprendizaje']."'";


		$resultadoaprendizaporid = $this->conexionSqlServer->realizarConsulta($query,true);
		
		
		$query2 = "select idCriterioEvaluacion, descripcionCriterioEvaluacion  from resultadoaprendizaje as r 
		inner join criterioevaluacion as c on c.idResultadoAprendizaje=r.idResultadoAprendizaje
		where r.idResultadoAprendizaje ='".$resultadoaprendizaporid[0]["idResultadoAprendizaje"]."'";
		$criteriosEvaluacion = $this->conexionSqlServer->realizarConsulta($query2,true);

		
		$resultado=
		array('idResultadoAprendizaje ' => $resultadoaprendizaporid[0]["idResultadoAprendizaje"] ,
			'codigoResultadoAprendizaje ' => $resultadoaprendizaporid[0]["codigoResultadoAprendizaje"] ,
			'tituloResultadoAprendizaje ' => $resultadoaprendizaporid[0]["tituloResultadoAprendizaje"] ,
			'definicionResultadoAprendizaje ' => $resultadoaprendizaporid[0]["definicionResultadoAprendizaje"] ,
			'criteriosEvaluacion' =>$criteriosEvaluacion);	

		$resultadoJson = $this->conexionSqlServer->convertirJson($resultado);
		return $resultadoJson;	
	}



	public function listarUltimoPrimaryKey($nombreCampoID,$tabla){
		$query1="select LAST_INSERT_ID(".$nombreCampoID.") from ".$tabla;
		$resultadoQuery = $this->conexionSqlServer->realizarConsulta($query1,true);
		$query2.="select LAST_INSERT_ID()";
		$resultadoQuery2 = $this->conexionSqlServer->realizarConsulta($query2,true);
		return $resultadoQuery2[0]['LAST_INSERT_ID()'];
	}

	public function agregarResultadoAprendizaje($resultadoAprendizaje){

		$funcionoQueryAgregarResultadoAprendizaje = false;
		$funcionoQueryAgregarCriteriosEvaluacion = false;

		$this->conexionSqlServer->iniciarTransaccion();

		$queryAgregarResultadoAprendizaje="
			INSERT INTO ResultadoAprendizaje(
				definicionResultadoAprendizaje
				,tituloResultadoAprendizaje
				,codigoResultadoAprendizaje)
			VALUES(
				'".$resultadoAprendizaje["definicionResultadoAprendizaje"]."'
				,'".$resultadoAprendizaje["tituloResultadoAprendizaje"]."'
				,'".$resultadoAprendizaje["codigoResultadoAprendizaje"]."')";

		$funcionoQueryAgregarResultadoAprendizaje = 
			$this->conexionSqlServer->realizarConsulta($queryAgregarResultadoAprendizaje,false);
		
		$idResultadoAprendizaje = 
			$this->listarUltimoPrimaryKey('idResultadoAprendizaje','resultadoaprendizaje');

		$funcionoQueryAgregarResultadoAprendizajeDocente = $this->agregarResultadoAprendizajeDocente($idResultadoAprendizaje);

		$funcionoQueryAgregarCriteriosEvaluacion = 
			$this->agregarCriteriosEvaluacion($resultadoAprendizaje["criteriosEvaluacion"],$idResultadoAprendizaje);
		
		$funcionoTransaccion = 
			$this->conexionSqlServer->finalizarTransaccion(
				array($funcionoQueryAgregarCriteriosEvaluacion
						,$funcionoQueryAgregarResultadoAprendizaje
						,$funcionoQueryAgregarResultadoAprendizajeDocente)
				);
		
		return $funcionoTransaccion;
	}


	public function agregarResultadoAprendizajeDocente($idResultadoAprendizaje){
		$idDocente = $this->conexionSqlServer->obtenerVariableSesion("CodPer");
		$query = "INSERT INTO resultadoaprendizajedocente(idResultadoAprendizaje
			,idDocente) 
			VALUES('".$idResultadoAprendizaje."'
					,'".$idDocente."')";
		return $this->conexionSqlServer->realizarConsulta($query);
	}

	public function agregarCriteriosEvaluacion($resultadoAprendizaje,$idResultadoAprendizaje){
		$funcionoQueryAgregarCriteriosEvaluacion = true;
		$objCriterioEvaluacion = new CriterioEvaluacion();
		if(!empty($resultadoAprendizaje)){
			$funcionoQueryAgregarCriteriosEvaluacion = $objCriterioEvaluacion->agregarCriterioEvaluacion(
				$resultadoAprendizaje
				,$idResultadoAprendizaje);
		}
		return $funcionoQueryAgregarCriteriosEvaluacion;
	}

	public function modificarResultadoAprendizaje($ResultadoAprendizaje){
		
		$this->conexionSqlServer->iniciarTransaccion();
		$query = "update ResultadoAprendizaje set
		definicionResultadoAprendizaje='".$ResultadoAprendizaje["definicionResultadoAprendizaje"]."',
		tituloResultadoAprendizaje='".$ResultadoAprendizaje["tituloResultadoAprendizaje"]."', 
		codigoResultadoAprendizaje='".$ResultadoAprendizaje["codigoResultadoAprendizaje"]."',
		tipoResultadoAprendizaje='".$ResultadoAprendizaje["tipoResultadoAprendizaje"]."'
		
		where idResultadoAprendizaje='".$ResultadoAprendizaje["idResultadoAprendizaje"]."'";

		$resultadoModificarResultadoAprendizaje = $this->conexionSqlServer->realizarConsulta($query,false); 

		$resultado=array();
		$resultado[]=$resultadoModificarResultadoAprendizaje;

		if(!empty($ResultadoAprendizaje["criteriosEvaluacionBorrados"])){
		foreach ($ResultadoAprendizaje["criteriosEvaluacion"]   as $idCriterioEvaluacion) {

			$queryCriterio = "update criterioevaluacion set
		descripcionCriterioEvaluacion='".$idCriterioEvaluacion["descripcionCriterioEvaluacion"]."'
		where idCriterioEvaluacion='".$idCriterioEvaluacion["idCriterioEvaluacion"]."'";

		$funionoActualizarCriterioEvaluacion=$this->conexionSqlServer->realizarConsulta($queryCriterio,false);

		$resultado[]=$funionoActualizarCriterioEvaluacion;

		}
  
		$this->conexionSqlServer->finalizarTransaccion($resultado);


		}
		if(!empty($ResultadoAprendizaje["criteriosEvaluacionBorrados"])){
		foreach ($ResultadoAprendizaje["criteriosEvaluacionBorrados"]   as $idCriterioEvaluacion) {

			$queryCriterio = "delete from criterioevaluacion
			where idCriterioEvaluacion ='".$idCriterioEvaluacion["idCriterioEvaluacion"]."'";


		$funcionoEliminarCriteriosEvaluacion=$this->conexionSqlServer->realizarConsulta($queryCriterio,false);
		$resultado[]=$funcionoEliminarCriteriosEvaluacion;

		}
	}
		$this->conexionSqlServer->finalizarTransaccion($resultado);

	}

	public function listarResultadoAprendizajeEscuela(){
		$queryListarResultadoAprendisajeCreadosPorEscuela = 
		"SELECT idResultadoAprendizaje
				,codigoResultadoAprendizaje 
				,tituloResultadoAprendizaje 
				,definicionResultadoAprendizaje   
		FROM resultadoaprendizaje 
		WHERE tipoResultadoAprendizaje = 'Escuela'";
		return $this->conexionSqlServer->realizarConsulta($queryListarResultadoAprendisajeCreadosPorEscuela,true);
	}

	public function listarResultadoAprendizajeEscuelaConCriteriosEvaluacion(){
		$resultadosAprendizajeEscuela = $this->listarResultadoAprendizajeEscuela();
		foreach($resultadosAprendizajeEscuela as &$resultadoAprendizajeEscuela){
			$resultadoAprendizajeEscuela["criteriosEvaluacion"] = CriterioEvaluacion::obtenerObjeto()->listarCriterioEvaluacionPorResultadoAprendizaje($resultadoAprendizajeEscuela["idResultadoAprendizaje"]);
		}
		return $resultadosAprendizajeEscuela;
	}

	public function listarResultadoAprendizaje(){
		$CodPer = $this->conexionSqlServer->obtenerVariableSesion("CodPer");
		$resultadosAprendizajeEscuelaresultadosAprendizajeEscuela =  
		array(
			 "resultadosAprendizaje"=>$this->listarResultadoAprendizajeEscuelaConCriteriosEvaluacion(),
			 "resultadosAprendizajeDocente"=>ResultadoAprendizajeDocente::obtenerObjeto()->listarResultadoAprendizajeDocenteConCriteriosEvaluacion($CodPer)
			 );
		return $resultadosAprendizajeEscuelaresultadosAprendizajeEscuela;
	}

	public function obtenerResultadosAprendizaje(){
		return $this->conexionSqlServer->convertirJson($this->listarResultadoAprendizaje());
	}
}

class ResultadoAprendizajeDocente extends ResultadoAprendizaje{
	private $conexionSqlServer;

	protected function __construct(){
		$this->conexionSqlServer = ConexionFactory::obtenerConexion('sqlserver');
	}

	public function listarResultadoAprendizajeDocente($CodPer){
		$queryListarResultadoAprendizajeDocente =
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
						WHERE idDocente = '".$CodPer."'
				)";
		return $this->conexionSqlServer->realizarConsulta($queryListarResultadoAprendizajeDocente,true);
	}

	public function listarResultadoAprendizajeDocenteConCriteriosEvaluacion($CodPer){
		$resultadosAprendizajeDocente = $this->listarResultadoAprendizajeDocente($CodPer);
		foreach($resultadosAprendizajeDocente as &$resultadoAprendizajeDocente){
			$resultadoAprendizajeDocente["criteriosEvaluacion"] = CriterioEvaluacion::obtenerObjeto()->listarCriterioEvaluacionPorResultadoAprendizaje($resultadoAprendizajeDocente["idResultadoAprendizaje"]);
		}
		return $resultadosAprendizajeDocente;
	}
}
