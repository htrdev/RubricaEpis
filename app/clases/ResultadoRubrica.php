<?php

header('Content-type: application/json');

require_once('Conexion.php');

class ResultadoRubrica{

	private $conexion;

	public function __construct(){
		$this->conexion = ConexionFactory::obtenerConexion('mysql','192.168.1.35','htrdev','12345');
	}


	public function agregarResultadoRubrica($CriterioEvaluacion){

		$query = "INSERT into resultadoRubrica (idResultadoRubrica, fechaCompletadoRubrica, estadoRubrica, totalRubrica ) 
		values ('".$CriterioEvaluacion["idResultadoRubrica"]."', '".$CriterioEvaluacion["fechaCompletadoRubrica"]."', '".$CriterioEvaluacion["estadoRubrica"]."', '".$CriterioEvaluacion["totalRubrica"]."')";
		$resultado = $this->conexion->realizarConsulta($query,false);
		$resultadoJson = $this->conexion->convertirJson($resultado);
		return $resultadoJson;

	}

	public function listarResultadoRubrica(){

	}

}

		/*agregar*/
		$CriterioEvaluacion = array(
		"idResultadoRubrica"=>"3",
		"fechaCompletadoRubrica"=>"2014-03-03",
		"estadoRubrica"=>"1",
		"totalRubrica"=>"90",
		);	
		$objetoModeloRubrica = new ResultadoRubrica();
		echo $objetoModeloRubrica->agregarResultadoRubrica($CriterioEvaluacion);