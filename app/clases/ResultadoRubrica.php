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

	public function listarResultadoRubricaPorDocente($idDocente){
		$query = 
		"SELECT  M.idModeloRubrica 
				,M.Semestre_idSemestre 
				,M.Curso_idCurso 
				,M.calificacionRubrica 
				,R.idDocenteCalificador 
				,M.fechaFinalRubrica  
		FROM resultadorubrica as R
			INNER JOIN modelorubrica AS M 
				ON M.idModeloRubrica = R.ModeloRubrica_idModelRubrica 
				  WHERE R.idDocenteCalificador = '".$idDocente."'";
		return $this->conexionMysql->realizarConsulta($query,true);
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
				array("nombreCompletoAlumno"=>$alumnos[0]["ApepPer"]." ".$alumnos[0]["ApemPer"].", ".$alumnos[0]["NomPer"]
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

	public function resultadoRubricaPorID($idResultadoRubrica){
		$resultadoRubrica;
		$queryIdModeloRubrica = "SELECT R.ModeloRubrica_idModelRubrica FROM resultadorubrica AS R
								 WHERE R.idResultadoRubrica = '".$idResultadoRubrica."'";
		$resultadoIdModeloRubrica = $this->conexionMysql->realizarConsulta($queryIdModeloRubrica,true);
		$queryModeloRubrica = "SELECT M.Semestre_idSemestre,M.Curso_idCurso ,M.Docente_Persona_idPersona  FROM modelorubrica AS M 
							   WHERE M.idModeloRubrica = '".$resultadoIdModeloRubrica[0]['ModeloRubrica_idModelRubrica']."'";
		$resultadoModeloRubrica = $this->conexionMysql->realizarConsulta($queryModeloRubrica,true);
		//semestre
		$querySemestre = "SELECT S.Semestre  FROM SEMESTRE AS S
						  WHERE S.IdSem = '".$resultadoModeloRubrica[0]['Semestre_idSemestre']."'";
		$resultadoSemestre = $this->conexionSqlServer->realizarConsulta($querySemestre,true);
		//curso
		$queryCurso = "SELECT C.DesCurso ,C.CicloCurso  FROM curso AS C
					WHERE C.idcurso = '".$resultadoModeloRubrica[0]['Curso_idCurso']."'";
		$resultadoCurso = $this->conexionSqlServer->realizarConsulta($queryCurso,true);
		//docenteCreador de la Rubrica 
		$queryDocenteCreadorRubrica = "SELECT P.ApepPer ,P.ApemPer ,P.NomPer  FROM .PERSONA AS P 
									   WHERE P.CodPer = '".$resultadoModeloRubrica[0]['Docente_Persona_idPersona']."'";
		$resultadoDocenteCreadorRubrica = $this->conexionSqlServer->realizarConsulta($queryDocenteCreadorRubrica,true);
		//alumnos Calificados
		$queryAlumnosCalificados = "SELECT A.idPersonaCalificada  FROM asignacionpersonacalificada AS A
									WHERE A.ResultadoRubrica_idResultadoRubrica  = '".$idResultadoRubrica."'";
		$resultadoAlumnosCalificados = $this->conexionMysql->realizarConsulta($queryAlumnosCalificados,true);
		$alumnosCalificados=array();
		$contadorAlumnos=0;
		foreach ($resultadoAlumnosCalificados as $alumno) {
				//echo "alumno Calificado : ".$alumno['idPersonaCalificada']."\n";
				$queryAlumnoCalificado = "SELECT P.ApepPer ,P.ApemPer ,P.NomPer  FROM .PERSONA AS P 
									   WHERE P.CodPer = '".$alumno['idPersonaCalificada']."'";
				$resultadoAlumnoCalificado= $this->conexionSqlServer->realizarConsulta($queryAlumnoCalificado,true);
				
				$alumnosCalificados[$contadorAlumnos]= 
			  		array("nombreCompletoAlumno"=>$resultadoAlumnoCalificado[0]["ApepPer"]." ".$resultadoAlumnoCalificado[0]["ApemPer"].", ".$resultadoAlumnoCalificado[0]["NomPer"],
					); 	
				$contadorAlumnos++;
		}
		//criterios Evaluacion
		$queryIdCriteriosEvaluacion = "SELECT A.CriterioEvaluacion_idCriterioEvaluacion  FROM asignacioncriterioevaluacion AS A 
									WHERE A.ModeloRubrica_idModeloRubrica = '".$resultadoIdModeloRubrica[0]['ModeloRubrica_idModelRubrica']."'";
		$resultadoIdCriterios = $this->conexionMysql->realizarConsulta($queryIdCriteriosEvaluacion,true);
		$criteriosEvaluacion=array();
		$contadorCriterios=0;
		foreach ($resultadoIdCriterios as $criterio) {
				//echo "alumno Calificado
				$queryCriterio = "SELECT C.descripcionCriterioEvaluacion,C.ResultadoAprendizaje_idResultadoAprendizaje FROM criterioevaluacion AS C
								  WHERE C.idCriterioEvaluacion = '".$criterio['CriterioEvaluacion_idCriterioEvaluacion']."'";
				$resultadoCriterio= $this->conexionMysql->realizarConsulta($queryCriterio,true);
				//resultadoaprendizaje
				$queryRA = "SELECT R.codigoResultadoAprendizaje,R.tituloResultadoAprendizaje FROM resultadoaprendizaje AS R
								  WHERE R.idResultadoAprendizaje =  '".$resultadoCriterio[0]['ResultadoAprendizaje_idResultadoAprendizaje']."'";
				$resultadoRA= $this->conexionMysql->realizarConsulta($queryRA,true);
				//			
				$criteriosEvaluacion[$contadorCriterios]= 
			  		array("idCriterioEvaluacion"=>$criterio['CriterioEvaluacion_idCriterioEvaluacion'],
			  			  "descripcionCriterioEvaluacion"=>$resultadoCriterio[0]["descripcionCriterioEvaluacion"],
			  			  "resultadoAprendizaje"=>$resultadoRA[0]["codigoResultadoAprendizaje"]." ".$resultadoRA[0]["tituloResultadoAprendizaje"]
					); 	
				$contadorCriterios++;
		}
		$resultadoRubrica = 
				array("idResultadoRubrica"=>$idResultadoRubrica,
					"semestre"=>$resultadoSemestre[0]['Semestre'],
					"curso"=>$resultadoCurso[0]['DesCurso'],
					"docenteCreadorRubrica"=>$resultadoDocenteCreadorRubrica[0]["ApepPer"]." ".$resultadoDocenteCreadorRubrica[0]["ApemPer"].", ".$resultadoDocenteCreadorRubrica[0]["NomPer"],
					"ciclo"=>$resultadoCurso[0]['CicloCurso'],
					"alumnosCalificados"=>$alumnosCalificados,
					"criteriosEvaluacion"=>$criteriosEvaluacion					
					); 
		$resultadoJson = $this->conexionMysql->convertirJson($resultadoRubrica);
		return $resultadoJson;

	}
}
