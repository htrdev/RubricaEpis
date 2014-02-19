<?php

header('Content-type: application/json');

require_once('Conexion.php');

class ResultadoRubrica{

	private $conexionMysql;
	private $conexionSqlServer;

	public function __construct(){
		$this->conexionMysql = ConexionFactory::obtenerConexion('mysql','localhost','root','123456');
		$this->conexionSqlServer = ConexionFactory::obtenerConexion('sqlserver','192.168.1.38','sa','123cuatro');

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

		$resultados = $this->conexionMysql->realizarConsulta($query,true);

		$respaldo=array();
		$contadorResultado=0;
		
		foreach ($resultados as $resultado) {
		
			$idPersonasEvaluadas= "SELECT a.Persona_idPersona   from asignacionpersonacalificada as a 
								where a.ResultadoRubrica_idResultadoRubrica ='".$resultado["IDRESULTADORUBRICA"]."'";
			$resultadosidPersonasEvaluadas = $this->conexionMysql->realizarConsulta($idPersonasEvaluadas,true);
			
			$personasEvaluadas=array();
			$i=0;
			$evaluador="";

			foreach ($resultadosidPersonasEvaluadas as $id ) {
				 //select por id 
					$consulta = "select p.ApepPer , p.ApemPer , p.NomPer  from PERSONA as p 
								where p.CodPer ='".$id["Persona_idPersona"]."'";
					$resultados = $this->conexionSqlServer->realizarConsulta($consulta,true);

					foreach ($resultados as $persona) {	
						$personasEvaluadas[$i]=array("NomPer"=>$persona["ApepPer"]." ". $persona["ApemPer"]." , ".$persona["NomPer"]);
				 		$i++;
					}	
			}

			// Evaluador
			//echo $resultado["PERSONA_IDPERSONA"]."\n";
			$consultax = "SELECT P.APEPPER , P.APEMPER , P.NOMPER  FROM PERSONA AS P WHERE P.CODPER = '".$resultado["PERSONA_IDPERSONA"]."'";
			$evaluador = $this->conexionSqlServer->realizarConsulta($consultax,true);
			
			$respaldo[$contadorResultado] = 
				array("idResultadoRubrica "=>$resultado["IDRESULTADORUBRICA"],
					"fechaCompletadoRubrica "=>$resultado["FECHACOMPLETADORUBRICA"],
					"personaEvaluada  "=>$personasEvaluadas,
					"totalRubrica "=>$resultado["TOTALRUBRICA"],
					"estadoRubrica "=>$resultado["ESTADORUBRICA"],
					"evaluadoPor "=>$evaluador[0]["APEPPER"]." ". $evaluador[0]["APEMPER"]." , ".$evaluador[0]["NOMPER"]
					); 
			$contadorResultado++;
		}

		$resultadoJson = $this->conexionMysql->convertirJson($respaldo);
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
