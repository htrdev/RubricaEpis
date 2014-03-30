<?php

header('Content-type: application/json');

require_once('Conexion.php');

class CriterioEvaluacion extends Singleton{

	private $conexionSqlServer;

	public function __construct(){
		$this->conexionSqlServer = ConexionFactory::obtenerConexion('sqlserver');
	}

	public function agregarCriterioEvaluacion($criterioEvaluacion,$idResultadoAprendizaje){
		$query = "INSERT into criterioevaluacion (descripcionCriterioEvaluacion, idResultadoAprendizaje) 
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
		$funciono = $this->conexionSqlServer->realizarConsulta($query,false);
		return $funciono;		
	}

	public function listarCriterioEvaluacionPorResultadoAprendizaje($idResultadoAprendizaje){
		$query = 
		"SELECT idCriterioEvaluacion
				,descripcionCriterioEvaluacion
		FROM CriterioEvaluacion
			WHERE idResultadoAprendizaje = '".$idResultadoAprendizaje."'";
		return $this->conexionSqlServer->realizarConsulta($query,true);
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


	public function listarCriterioEvaluacionPorModeloRubrica(){
		
	}

}


