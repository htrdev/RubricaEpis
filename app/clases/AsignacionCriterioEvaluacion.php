<?php

header('Content-type: application/json');

require_once('Conexion.php');
require_once('Singleton.php');

class AsignacionCriterioEvaluacion extends Singleton{

	private $conexionSqlServer;

	public function __construct(){
		$this->conexionSqlServer = ConexionFactory::obtenerConexion('sqlserver');
	}
	
	public function agregarAsignacionCriterioEvaluacion($idModeloRubrica,$CriterioEvaluacion){
		$query = "";
		foreach($CriterioEvaluacion as $idCriterioEvaluacion){
			$query .= 
			"INSERT INTO asignacionCriterioEvaluacion(
				idModeloRubrica
				,idCriterioEvaluacion)
			VALUES(
				'".$idModeloRubrica."'
				,'".$idCriterioEvaluacion."');";
		}
		$funciono = $this->conexionSqlServer->realizarConsulta($query,false);
		return $funciono;		
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
