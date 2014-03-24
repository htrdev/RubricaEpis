<?php

header('Content-type: application/json');

require_once('Conexion.php');
require_once('Singleton.php');

class AsignacionCriterioEvaluacion extends Singleton{

	private $conexion;

	public function __construct(){
		$this->conexion = ConexionFactory::obtenerConexion('mysql');
	}
	
	public function agregarAsignacionCriterioEvaluacion($idModeloRubrica,$CriterioEvaluacion){
		$query = "INSERT into asignacionCriterioEvaluacion (ModeloRubrica_idModeloRubrica, CriterioEvaluacion_idCriterioEvaluacion)
		values";
		$numeroElementos = count($CriterioEvaluacion);
		$i = 0;
		foreach($CriterioEvaluacion as $idCriterioEvaluacion){
			$query.= "('".$idModeloRubrica."','".$idCriterioEvaluacion."')";
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

	public function listarAsignacionCriterioEvaluacionPorModeloRubrica($idModeloRubrica){
		$query = 
		"SELECT A.CriterioEvaluacion_idCriterioEvaluacion AS idCriterioEvaluacion
				,A.idAsignacionCriterioEvaluacion
			FROM asignacioncriterioevaluacion AS A 
				WHERE A.ModeloRubrica_idModeloRubrica = '".$idModeloRubrica."'";
		return $this->conexion->realizarConsulta($query,true);
	}
}
