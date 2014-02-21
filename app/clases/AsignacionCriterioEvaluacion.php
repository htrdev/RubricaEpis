<?php

header('Content-type: application/json');

require_once('Conexion.php');

class AsignacionCriterioEvaluacion{

	private $conexion;

	public function __construct(){
		$this->conexion = ConexionFactory::obtenerConexion('mysql','localhost','root','');
	}

	
		public function agregarAsignacionCriterioEvaluacion($idModeloRubrica,$CriterioEvaluacion){

		$query = "INSERT into asignacionCriterioEvaluacion (ModeloRubrica_idModeloRubrica, CriterioEvaluacion_idCriterioEvaluacion)
		values";
		$numeroElementos = count($CriterioEvaluacion);
		$i = 0;
		foreach($CriterioEvaluacion as $AsignarCriterioEvaluacion){
			$query.= "('".$idModeloRubrica."','".$AsignarCriterioEvaluacion["CriterioEvaluacion_idCriterioEvaluacion"]."')";
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
}
		/*agregar*/
		/*$CriterioEvaluacion = array(
		"ModeloRubrica_idModeloRubrica"=>"1",
		"CriterioEvaluacion_idCriterioEvaluacion"=>"11");	
		$objetoModeloRubrica = new AsignacionCriterioEvaluacion();
		echo $objetoModeloRubrica->agregarAsignacionCriterioEvaluacion($CriterioEvaluacion);*/