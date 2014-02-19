<?php

header('Content-type: application/json');

require_once('Conexion.php');

class AsignacionCriterioEvaluacion{

	private $conexion;

	public function __construct(){
		$this->conexion = ConexionFactory::obtenerConexion('mysql','localhost','htrdev','12345');
	}

		public function agregarAsignacionCriterioEvaluacion($CriterioEvaluacion){

		$query = "INSERT into asignacionCriterioEvaluacion (ModeloRubrica_idModeloRubrica, CriterioEvaluacion_idCriterioEvaluacion) 
		values ('".$CriterioEvaluacion["ModeloRubrica_idModeloRubrica"]."', '".$CriterioEvaluacion["CriterioEvaluacion_idCriterioEvaluacion"]."')";
		$resultado = $this->conexion->realizarConsulta($query,false);
		$resultadoJson = $this->conexion->convertirJson($resultado);
		return $resultadoJson;


	}
}
		/*agregar*/
		$CriterioEvaluacion = array(
		"ModeloRubrica_idModeloRubrica"=>"1",
		"CriterioEvaluacion_idCriterioEvaluacion"=>"11");	
		$objetoModeloRubrica = new AsignacionCriterioEvaluacion();
		echo $objetoModeloRubrica->agregarAsignacionCriterioEvaluacion($CriterioEvaluacion);