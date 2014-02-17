<?php

header('Content-type: application/json');

require_once('Conexion.php');

class CalificacionCriterioEvaluacion{

	private $conexion;

	public function __construct(){
		$this->conexion = ConexionFactory::obtenerConexion('mysql','localhost','htrdev','12345');

	}

	public function agregarCalificacionCriterioEvaluacion($CriterioEvaluacion){

		$query = "INSERT into calificacionCriterioEvaluacion (Rubrica_idResultadoRubrica, calificacionResultadoRubrica, AsignacionCriterioEvaluacion_idAsignacionCriterioEvaluacion) 
		values ('".$CriterioEvaluacion["Rubrica_idResultadoRubrica"]."', '".$CriterioEvaluacion["calificacionResultadoRubrica"]."', '".$CriterioEvaluacion["AsignacionCriterioEvaluacion_idAsignacionCriterioEvaluacion"]."')";
		$resultado = $this->conexion->realizarConsulta($query,false);
		$resultadoJson = $this->conexion->convertirJson($resultado);
		return $resultadoJson;	


	}

}
		/*agregar*/
		$CriterioEvaluacion = array(
		"Rubrica_idResultadoRubrica"=>"1",
		"calificacionResultadoRubrica"=>"30",
		"AsignacionCriterioEvaluacion_idAsignacionCriterioEvaluacion"=>"4"
		);	
		$objetoModeloRubrica = new CalificacionCriterioEvaluacion();
		echo $objetoModeloRubrica->agregarCalificacionCriterioEvaluacion($CriterioEvaluacion);