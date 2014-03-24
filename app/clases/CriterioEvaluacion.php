<?php

header('Content-type: application/json');

require_once('Conexion.php');

class CriterioEvaluacion extends Singleton{

	private $conexion;

	public function __construct(){
		$this->conexion = ConexionFactory::obtenerConexion('mysql');
	}

	public function agregarCriterioEvaluacion($criterioEvaluacion,$idResultadoAprendizaje){
		$query = "INSERT into criterioevaluacion (descripcionCriterioEvaluacion, ResultadoAprendizaje_idResultadoAprendizaje) 
		values";
		$numeroElementos = count($criterioEvaluacion);
		$i = 0;
		foreach($criterioEvaluacion as $criterio){
			$query.= "('".$criterio["descripcionCriterioEvaluacion"]."','".$idResultadoAprendizaje."')";
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

	public function listarCriterioEvaluacionPorResultadoAprendizaje($idResultadoAprendizaje){
		$query = 
		"SELECT idCriterioEvaluacion
				,descripcionCriterioEvaluacion
		FROM CriterioEvaluacion
			WHERE ResultadoAprendizaje_idResultadoAprendizaje = '".$idResultadoAprendizaje."'";
		return $this->conexion->realizarConsulta($query,true);
	}

	public function listarCriterioEvaluacionPorId($idCriterioEvaluacion){
		$query =
		"SELECT c.descripcionCriterioEvaluacion,CONCAT(r.codigoResultadoAPrendizaje,' ',r.tituloResultadoAprendizaje) AS tituloResultadoAprendizaje
		FROM criterioEvaluacion AS c
		INNER JOIN resultadoaprendizaje AS r
			ON c.ResultadoAprendizaje_idResultadoAprendizaje = r.idResultadoAprendizaje AND c.idCriterioEvaluacion ='".$idCriterioEvaluacion."'";
		$resultado = $this->conexion->realizarConsulta($query,true);
		return $resultado[0];
	}


	public function listarCriterioEvaluacionPorModeloRubrica(){
		
	}

}


