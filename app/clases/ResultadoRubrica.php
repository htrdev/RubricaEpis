<?php

header('Content-type: application/json');

require_once('Conexion.php');

class ResultadoRubrica extends Singleton{

	private $conexionMysql;
	private $conexionSqlServer;

	public function __construct(){
		$this->conexionMysql = ConexionFactory::obtenerConexion('mysql');
		$this->conexionSqlServer = ConexionFactory::obtenerConexion('sqlserver');
	}

	public function agregarResultadoRubrica($CriterioEvaluacion){
		$query = "INSERT into resultadoRubrica (idResultadoRubrica, fechaCompletadoRubrica, estadoRubrica, totalRubrica ) 
		values ('".$CriterioEvaluacion["idResultadoRubrica"]."', '".$CriterioEvaluacion["fechaCompletadoRubrica"]."', '".$CriterioEvaluacion["estadoRubrica"]."', '".$CriterioEvaluacion["totalRubrica"]."')";
		$resultado = $this->conexion->realizarConsulta($query,false);
		$resultadoJson = $this->conexion->convertirJson($resultado);
		return $resultadoJson;
	}

	public function listarResultadoRubricaPorIDModeloRubrica($idModeloRubrica){
	
		$query = "SELECT R.IDRESULTADORUBRICA ,R.FECHACOMPLETADORUBRICA, R.TOTALRUBRICA ,R.ESTADORUBRICA , R.idDocenteCalificador 
				  FROM RESULTADORUBRICA AS R WHERE R.MODELORUBRICA_IDMODELRUBRICA = '".$idModeloRubrica."'";

		$resultados = $this->conexionMysql->realizarConsulta($query,true);

		$respaldo=array();
		$contadorResultado=0;
		
		foreach ($resultados as $resultado) {
		
			$idPersonasEvaluadas= "SELECT a.idPersonaCalificada   from asignacionpersonacalificada as a 
								where a.ResultadoRubrica_idResultadoRubrica ='".$resultado["IDRESULTADORUBRICA"]."'";
			$resultadosidPersonasEvaluadas = $this->conexionMysql->realizarConsulta($idPersonasEvaluadas,true);
			
			$personasEvaluadas=array();
			$i=0;
			$evaluador="";

			foreach ($resultadosidPersonasEvaluadas as $id ) {
				
					$consulta = "select p.ApepPer , p.ApemPer , p.NomPer  from PERSONA as p 
								where p.CodPer ='".$id["idPersonaCalificada"]."'";
					$resultados = $this->conexionSqlServer->realizarConsulta($consulta,true);

					foreach ($resultados as $persona) {	
						$personasEvaluadas[$i]=array("nombreCompletoAlumno"=>$persona["ApepPer"]." ". $persona["ApemPer"].", ".$persona["NomPer"]);
				 		$i++;
					}	
			}

			$consultax = "SELECT P.APEPPER , P.APEMPER , P.NOMPER  FROM PERSONA AS P WHERE P.CODPER = '".$resultado["idDocenteCalificador"]."'";
			$evaluador = $this->conexionSqlServer->realizarConsulta($consultax,true);
			
			$respaldo[$contadorResultado] = 
				array("idResultadoRubrica"=>$resultado["IDRESULTADORUBRICA"],					
					"alumnosCalificados"=>$personasEvaluadas,
					"docenteCalificador"=>$evaluador[0]["APEPPER"]." ". $evaluador[0]["APEMPER"].", ".$evaluador[0]["NOMPER"],
					"fechaCompletadoRubrica"=>$resultado["FECHACOMPLETADORUBRICA"],
					"totalRubrica"=>$resultado["TOTALRUBRICA"],
					"estadoRubrica"=>$resultado["ESTADORUBRICA"]
					
					); 
			$contadorResultado++;
		}

		$resultadoJson = $this->conexionMysql->convertirJson($respaldo);
		return $resultadoJson;
	}


	public function listarResultadoRubricaPorcionRubricaAsignada($idModeloRubrica){


		$docenteCalificador=$this->conexionMysql->obtenerVariableSesion("CodPer");
		$query = "SELECT R.idResultadoRubrica , R.fechaCompletadoRubrica , R.totalRubrica , R.estadoRubrica  FROM resultadorubrica AS R
				  WHERE R.ModeloRubrica_idModelRubrica = '".$idModeloRubrica."'" ." AND R.idDocenteCalificador = '".$docenteCalificador."'";

		$resultados = $this->conexionMysql->realizarConsulta($query,true);
		$resultadoRubricaAsigada=array();	
		$contadorResultado=0;

		foreach ($resultados as $resultado) {
			
			$query = "SELECT A.idPersonaCalificada FROM  asignacionpersonacalificada AS A
				      WHERE A.ResultadoRubrica_idResultadoRubrica = '".$resultado["idResultadoRubrica"]."'";
			$queryResultadosAlumnosEvaluados = $this->conexionMysql->realizarConsulta($query,true);
			$resultadosAlumnosEvaluados=array();
			$i=0;
			foreach ($queryResultadosAlumnosEvaluados as $alumno) {

				$query = "SELECT P.ApepPer,P.ApemPer,P.NomPer FROM PERSONA AS P
						  WHERE P.CodPer = '".$alumno["idPersonaCalificada"]."'";
				$alumnos = $this->conexionSqlServer->realizarConsulta($query,true);

				$resultadosAlumnosEvaluados[$i] = 
				array("nombreCompleto"=>$alumnos[0]["ApepPer"]." ".$alumnos[0]["ApemPer"].", ".$alumnos[0]["NomPer"]
					); 
				$i++;
			}

			$resultadoRubricaAsigada[$contadorResultado] = 
				array("idResultadoRubrica"=>$resultado["idResultadoRubrica"],
					"alumnosCalificados"=>$resultadosAlumnosEvaluados,
					"fechaCompletadoRubrica"=>$resultado["fechaCompletadoRubrica"],
					"totalRubrica"=>$resultado["totalRubrica"],
					"estadoRubrica"=>$resultado["estadoRubrica"]
					); 
			$contadorResultado++;

		}
		$resultadoJson = $this->conexionMysql->convertirJson($resultadoRubricaAsigada);
		return $resultadoJson;
	}
}
