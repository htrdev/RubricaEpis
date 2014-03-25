<?php

require_once('Conexion.php');

class CalificacionCriterioEvaluacion extends Singleton{

	private $conexionSqlServer;

	protected function __construct(){
		$this->conexionSqlServer = ConexionFactory::obtenerConexion('sqlserver');
	}

	public function agregarCalificacionCriterioEvaluacion($idResultadoRubrica,$resultadosAprendizaje){
		$query = 
		"INSERT INTO calificacionCriterioEvaluacion(
			idResultadoRubrica
			,calificacionResultadoRubrica
			,idAsignacionCriterioEvaluacion) 
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
		$funciono = $this->conexionSqlServer->realizarConsulta($query,false);
		return $funciono;	
	}

}
