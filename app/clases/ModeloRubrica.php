<?php

header('Content-type: application/json');

require_once('Conexion.php');

class ModeloRubrica{

	private $conexion;

	public function __construct(){
		$this->conexion = ConexionFactory::obtenerConexion('mysql','localhost','htrdev','12345');
	}

	public function agregarModeloRubrica(){

	}

	public function modificarModeloRubrica(){
	}
	//Aun falta parametros 
	public function listarModeloRubricaPorCriterios(){

		$query1 = "SELECT * FROM modelorubrica where idModeloRubrica = 1";
		$resultado1 = $this->conexion->realizarConsulta($query1);

		$query2 = "SELECT a.CriterioEvaluacion_idCriterioEvaluacion,r.definicionResultadoAprendizaje ,c.descripcionCriterioEvaluacion  FROM asignacioncriterioevaluacion as a
		inner join criterioevaluacion  as c on c.idCriterioEvaluacion = a.CriterioEvaluacion_idCriterioEvaluacion 
		inner join resultadoaprendizaje as r on r.idResultadoAprendizaje =c.ResultadoAprendizaje_idResultadoAprendizaje 
		where ModeloRubrica_idModeloRubrica = 1";
		$resultado2 = $this->conexion->realizarConsulta($query2);
		//Probando
		//
		$a = array('modelo'=>$resultado1,'criterio'=>$resultado2);
		$resultadoJson = $this->conexion->convertirJson($a);
		return $resultadoJson;
	}

	public function listarModeloRubricaPorDocente(){
	}


	


}

$objetoModeloRubrica = new ModeloRubrica();
echo $objetoModeloRubrica->listarModeloRubricaPorCriterios();