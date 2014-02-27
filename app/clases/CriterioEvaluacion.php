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

	public function listarCriterioEvaluacionPorResultadoAprendizaje(){

	}


	public function listarCriterioEvaluacionPorModeloRubrica(){
		
	}

}


