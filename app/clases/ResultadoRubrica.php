<?php

header('Content-type: application/json');

require_once('Conexion.php');

class ResultadoRubrica{

	private $conexion;

	public function __construct(){
		$this->conexion = ConexionFactory::obtenerConexion('mysql','192.168.1.34','htrdev','12345');
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

	public function listarResultadoRubricaPorIDModeloRubrica($idModeloRubrica=1){

		$query = "SELECT R.IDRESULTADORUBRICA ,R.FECHACOMPLETADORUBRICA, R.TOTALRUBRICA ,R.ESTADORUBRICA , R.PERSONA_IDPERSONA 
				  FROM RESULTADORUBRICA AS R WHERE R.MODELORUBRICA_IDMODELRUBRICA = '".$idModeloRubrica."'";

		$resultados = $this->conexion->realizarConsulta($query,true);
		//$personasEvaluadas= array();
		//$i=0;
		foreach ($resultados as $resultado) {
			echo $resultado["IDRESULTADORUBRICA"]."\n";
			$idPersonasEvaluadas= "SELECT a.Persona_idPersona   from asignacionpersonacalificada as a 
								where a.ResultadoRubrica_idResultadoRubrica ='".$resultado["IDRESULTADORUBRICA"]."'";
			$resultadosidPersonasEvaluadas = $this->conexion->realizarConsulta($idPersonasEvaluadas,true);
			
			foreach ($resultadosidPersonasEvaluadas as $id ) {
				 echo $id["Persona_idPersona"]."\n";
			}
			//echo $resultadosidPersonasEvaluadas["Persona_idPersona"]."\n";
			//$personasEvaluadas[$i]=$idPersonasEvaluadas["PERSONA_IDPERSONA"];
			//$i++;
		}

		/*
		foreach ($personasEvaluadas as $id) {
			echo "hahahha".$id."\n";
		}
		*/

		echo "\n\n";
		$resultadoJson = $this->conexion->convertirJson($resultados);
		return $resultadoJson;


	}



}

$objeto = new ResultadoRubrica();
echo  $objeto->listarResultadoRubricaPorIDModeloRubrica();


		/*agregar*/
		/*$CriterioEvaluacion = array(
		"idResultadoRubrica"=>"3",
		"fechaCompletadoRubrica"=>"2014-03-03",
		"estadoRubrica"=>"1",
		"totalRubrica"=>"90",
		);	
		$objetoModeloRubrica = new ResultadoRubrica();
		echo $objetoModeloRubrica->agregarResultadoRubrica($CriterioEvaluacion);

		*/
