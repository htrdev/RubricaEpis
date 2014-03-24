<?php

require_once('Conexion.php');

class CalificacionCriterioEvaluacion extends Singleton{

	private $conexion;

	protected function __construct(){
		$this->conexion = ConexionFactory::obtenerConexion('mysql','localhost','htrdev','12345');
	}

	public function agregarCalificacionCriterioEvaluacion($idResultadoRubrica,$resultadosAprendizaje){
		$query = 
		"INSERT INTO calificacionCriterioEvaluacion(
			Rubrica_idResultadoRubrica
			,calificacionResultadoRubrica
			,AsignacionCriterioEvaluacion_idAsignacionCriterioEvaluacion) 
		VALUES";
		$j = 0;
		$numeroElementosTotales = count($resultadosAprendizaje);
		foreach($resultadosAprendizaje as $resultadoAprendizaje){
			$i = 0;
			$numeroElementos = count($resultadoAprendizaje);
			foreach ($resultadoAprendizaje as $criterioEvaluacion) {
				$query.= "('".$idResultadoRubrica."','".$criterioEvaluacion["calificacion"]."','".$criterioEvaluacion["idAsignacionCriterioEvaluacion"]."')";
				if(++$i != $numeroElementos){
					$query .= ",";
				}
			}
			if(++$j == $numeroElementosTotales){
				$query.=";";
			}
			else{
				$query.=",";
			}
		}
		$funciono = $this->conexion->realizarConsulta($query,false);
		return $funciono;	
	}

}
