<?php

require_once('Conexion.php');

class CalificacionCriterioEvaluacion extends Singleton{

	private $conexionSqlServer;

	protected function __construct(){
		$this->conexionSqlServer = ConexionFactory::obtenerConexion('sqlserver');
	}

	public function agregarCalificacionCriterioEvaluacion($idResultadoRubrica,$resultadosAprendizaje){
		$query="";
		foreach($resultadosAprendizaje as $resultadoAprendizaje){
			foreach ($resultadoAprendizaje as $criterioEvaluacion) {
				$query .= 
				"INSERT INTO CalificacionCriterioEvaluacion(
					idResultadoRubrica
					,CalificacionCriterioEvaluacion
					,idAsignacionCriterioEvaluacion) 
				VALUES('".$idResultadoRubrica."','".$criterioEvaluacion["calificacion"]."','".$criterioEvaluacion["idAsignacionCriterioEvaluacion"]."');";
			}
		}
		$funciono = $this->conexionSqlServer->realizarConsulta($query,false);
		return $funciono;	
	}

}
