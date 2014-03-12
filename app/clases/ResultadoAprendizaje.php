<?php

header('Content-type: application/json');

require_once('Conexion.php');
require_once('CriterioEvaluacion.php');

class ResultadoAprendizaje extends Singleton{

	private $conexion;

	protected function __construct(){
		$this->conexion = ConexionFactory::obtenerConexion('mysql');
	}

	public function listarCriterioAprendizaje($idResultadoAprendizaje){
		$query = "SELECT  c.idCriterioEvaluacion,c.descripcionCriterioEvaluacion,c.ResultadoAprendizaje_idResultadoAprendizaje 
					FROM criterioevaluacion as c WHERE c.ResultadoAprendizaje_idResultadoAprendizaje = '".$idResultadoAprendizaje."'";
		return $this->conexion->realizarConsulta($query,true);
	}

	public function listarResultadoAprendizajePorID($resultadoAprendizaje){

		
		$query="select r.idResultadoAprendizaje,r.codigoResultadoAprendizaje,
		r.tituloResultadoAprendizaje,r.definicionResultadoAprendizaje from resultadoaprendizaje as r
		where r.idResultadoAprendizaje='".$resultadoAprendizaje['idResultadoAprendizaje']."'";


		$resultadoaprendizaporid = $this->conexion->realizarConsulta($query,true);
		
		
		$query2 = "select idCriterioEvaluacion, descripcionCriterioEvaluacion  from resultadoaprendizaje as r 
		inner join criterioevaluacion as c on c.ResultadoAprendizaje_idResultadoAprendizaje=r.idResultadoAprendizaje
		where r.idResultadoAprendizaje ='".$resultadoaprendizaporid[0]["idResultadoAprendizaje"]."'";
		$criteriosEvaluacion = $this->conexion->realizarConsulta($query2,true);

		
		$resultado=
		array('idResultadoAprendizaje ' => $resultadoaprendizaporid[0]["idResultadoAprendizaje"] ,
			'codigoResultadoAprendizaje ' => $resultadoaprendizaporid[0]["codigoResultadoAprendizaje"] ,
			'tituloResultadoAprendizaje ' => $resultadoaprendizaporid[0]["tituloResultadoAprendizaje"] ,
			'definicionResultadoAprendizaje ' => $resultadoaprendizaporid[0]["definicionResultadoAprendizaje"] ,
			'criteriosEvaluacion' =>$criteriosEvaluacion);	

		$resultadoJson = $this->conexion->convertirJson($resultado);
		return $resultadoJson;	
	}



	public function listarUltimoPrimaryKey($nombreCampoID,$tabla){
		$query1="select LAST_INSERT_ID(".$nombreCampoID.") from ".$tabla;
		$resultadoQuery = $this->conexion->realizarConsulta($query1,true);
		$query2.="select LAST_INSERT_ID()";
		$resultadoQuery2 = $this->conexion->realizarConsulta($query2,true);
		return $resultadoQuery2[0]['LAST_INSERT_ID()'];
	}

	public function agregarResultadoAprendizaje($resultadoAprendizaje){

		$funcionoQueryAgregarResultadoAprendizaje = false;
		$funcionoQueryAgregarCriteriosEvaluacion = false;

		$this->conexion->iniciarTransaccion();

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
			$this->conexion->realizarConsulta($queryAgregarResultadoAprendizaje,false);
		
		$idResultadoAprendizaje = 
			$this->listarUltimoPrimaryKey('idResultadoAprendizaje','resultadoaprendizaje');

		$funcionoQueryAgregarResultadoAprendizajeDocente = $this->agregarResultadoAprendizajeDocente($idResultadoAprendizaje);

		$funcionoQueryAgregarCriteriosEvaluacion = 
			$this->agregarCriteriosEvaluacion($resultadoAprendizaje["criteriosEvaluacion"],$idResultadoAprendizaje);
		
		$funcionoTransaccion = 
			$this->conexion->finalizarTransaccion(
				array($funcionoQueryAgregarCriteriosEvaluacion
						,$funcionoQueryAgregarResultadoAprendizaje
						,$funcionoQueryAgregarResultadoAprendizajeDocente)
				);
		
		return $funcionoTransaccion;
	}


	public function agregarResultadoAprendizajeDocente($idResultadoAprendizaje){
		$idDocente = $this->conexion->obtenerVariableSesion("CodPer");
		$query = "INSERT INTO resultadoaprendizajedocente(ResultadoAprendizaje_idResultadoAprendizaje
			,Docente_Persona_idPersona) 
			VALUES('".$idResultadoAprendizaje."'
					,'".$idDocente."')";
		return $this->conexion->realizarConsulta($query);
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
		
		$this->conexion->iniciarTransaccion();
		$query = "update ResultadoAprendizaje set
		definicionResultadoAprendizaje='".$ResultadoAprendizaje["definicionResultadoAprendizaje"]."',
		tituloResultadoAprendizaje='".$ResultadoAprendizaje["tituloResultadoAprendizaje"]."', 
		codigoResultadoAprendizaje='".$ResultadoAprendizaje["codigoResultadoAprendizaje"]."',
		tipoResultadoAprendizaje='".$ResultadoAprendizaje["tipoResultadoAprendizaje"]."'
		
		where idResultadoAprendizaje='".$ResultadoAprendizaje["idResultadoAprendizaje"]."'";

		$resultadoModificarResultadoAprendizaje = $this->conexion->realizarConsulta($query,false); 

		$resultado=array();
		$resultado[]=$resultadoModificarResultadoAprendizaje;

		if(!empty($ResultadoAprendizaje["criteriosEvaluacionBorrados"])){
		foreach ($ResultadoAprendizaje["criteriosEvaluacion"]   as $idCriterioEvaluacion) {

			$queryCriterio = "update criterioevaluacion set
		descripcionCriterioEvaluacion='".$idCriterioEvaluacion["descripcionCriterioEvaluacion"]."'
		where idCriterioEvaluacion='".$idCriterioEvaluacion["idCriterioEvaluacion"]."'";

		$funionoActualizarCriterioEvaluacion=$this->conexion->realizarConsulta($queryCriterio,false);

		$resultado[]=$funionoActualizarCriterioEvaluacion;

		}
  
		$this->conexion->finalizarTransaccion($resultado);


		}
		if(!empty($ResultadoAprendizaje["criteriosEvaluacionBorrados"])){
		foreach ($ResultadoAprendizaje["criteriosEvaluacionBorrados"]   as $idCriterioEvaluacion) {

			$queryCriterio = "delete from criterioevaluacion
			where idCriterioEvaluacion ='".$idCriterioEvaluacion["idCriterioEvaluacion"]."'";


		$funcionoEliminarCriteriosEvaluacion=$this->conexion->realizarConsulta($queryCriterio,false);
		$resultado[]=$funcionoEliminarCriteriosEvaluacion;

		}
	}
		$this->conexion->finalizarTransaccion($resultado);

	}

	public function listarResultadoAprendizajeEscuela(){
		$queryListarResultadoAprendisajeCreadosPorEscuela = 
		"SELECT idResultadoAprendizaje
				,codigoResultadoAprendizaje 
				,tituloResultadoAprendizaje 
				,definicionResultadoAprendizaje   
		FROM resultadoaprendizaje 
		WHERE tipoResultadoAprendizaje = 'Escuela'";
		return $this->conexion->realizarConsulta($queryListarResultadoAprendisajeCreadosPorEscuela,true);
	}

	public function listarResultadoAprendizaje(){
		$CodPer = $this->conexion->obtenerVariableSesion("CodPer");
		$resultadosAprendizajeEscuelaresultadosAprendizajeEscuela =  
		array(
			 "resultadosAprendizaje"=>$this->listarResultadoAprendizajeEscuela(),
			 "resultadosAprendizajeDocente"=>ResultadoAprendizajeDocente::obtenerObjeto()->listarResultadoAprendizajeDocente($CodPer)
			 );
		return $resultadosAprendizajeEscuelaresultadosAprendizajeEscuela;
	}

	public function obtenerResultadosAprendizaje(){
		return $this->conexion->convertirJson($this->listarResultadoAprendizaje());
	}
}

class ResultadoAprendizajeDocente extends ResultadoAprendizaje{
	private $conexion;

	protected function __construct(){
		$this->conexion = ConexionFactory::obtenerConexion('mysql');
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
					ResultadoAprendizaje_idResultadoAprendizaje 
						FROM resultadoaprendizajedocente
						WHERE Docente_Persona_idPersona = '".$CodPer."'
				)";
		return $this->conexion->realizarConsulta($queryListarResultadoAprendizajeDocente,true);
	}
}
