<?php

header('Content-type: application/json');
require_once('Conexion.php');
require_once('AsignacionCriterioEvaluacion.php');
require_once('Semestre.php');
require_once('ResultadoAprendizaje.php');
require_once('Docente.php');
require_once('Curso.php');

class ModeloRubrica extends Singleton{

	private $conexionMysql;
	private $conexionSqlServer;

	public function __construct(){
		$this->conexionMysql = ConexionFactory::obtenerConexion('mysql','localhost','root','123456');
		$this->conexionMysql = ConexionFactory::obtenerConexion('mysql','localhost','root','123456');
		$this->conexionSqlServer = ConexionFactory::obtenerConexion('sqlserver','192.168.1.38','sa','123cuatro');
	}

	public function listarUltimoPrimaryKey($nombreCampoID,$tabla){
		$query1="select LAST_INSERT_ID(".$nombreCampoID.") from ".$tabla;
		$resultadoQuery = $this->conexionMysql->realizarConsulta($query1,true);
		$query2.="select LAST_INSERT_ID()";
		$resultadoQuery2 = $this->conexionMysql->realizarConsulta($query2,true);
		return $resultadoQuery2[0]['LAST_INSERT_ID()'];
	}

	public function agregarModeloRubrica($agregarModeloRubrica){
		$queryAgregarModeloRubrica = false;
		$funcionoQueryAgregarCriteriosEvaluacion = false;
		$queryAgregarDocentes = false;
		$CodPer = $this->conexionMysql->obtenerVariableSesion("CodPer");

		$this->conexionMysql->iniciarTransaccion();

		$queryInsertarModeloRubrica="insert into modelorubrica
		(Curso_idCurso, Semestre_idSemestre, fechaInicioRubrica,fechaFinalRubrica,
		 Docente_Persona_idPersona,calificacionRubrica)
		values ('".$agregarModeloRubrica["idCurso"]."'
				,'".$agregarModeloRubrica["idSemestre"]."'
				,'".$agregarModeloRubrica["fechaInicio"]."'
				,'".$agregarModeloRubrica["fechaFinal"]."'
				,'".$CodPer."'
				,'".$agregarModeloRubrica["calificacionRubrica"]."')";

			
		$queryAgregarModeloRubrica= $this->conexionMysql->realizarConsulta($queryInsertarModeloRubrica,false);
		
		$idModeloRubrica = $this->listarUltimoPrimaryKey('idModeloRubrica','modelorubrica');
		
		$funcionoQueryAgregarCriteriosEvaluacion=
		$this->agregarCriteriosEvaluacion($idModeloRubrica,$agregarModeloRubrica["criteriosEvaluacion"]);
	
/*
	e
		
		$this->agregarModelosDocentes($idModeloRubrica,$agregarModeloRubrica["docentesAsignados"]); */

		$funcionoTransaccion = 
			$this->conexionMysql->finalizarTransaccion(
				array($funcionoQueryAgregarCriteriosEvaluacion					
					,$queryAgregarModeloRubrica)
				);
		return $funcionoTransaccion;
		}


/*	public function agregarModelosDocentes($idModeloRubrica,$docentes){
		
		$query = "INSERT INTO resultadorubrica (fechaCompletadoRubrica,idDocenteCalificador,ModeloRubrica_idModelRubrica,estadoRubrica,totalRubrica)
		values";

		$numeroElementos = count($docentes);
		$fechaCompletadoRubrica="";
		$estadoRubrica=0;
		$totalRubrica=0.00;
		$i = 0;
		foreach($docentes as $asignarDocentes){
			
			$query.= "('".$fechaCompletadoRubrica."','".$asignarDocentes["idDocentesAsignados"]."','".$idModeloRubrica."','".$estadoRubrica."','".$totalRubrica."')";
			if(++$i == $numeroElementos){
				$query.=";";
			}
			else{
				$query.=",";
			}
		}
		$funciono = $this->conexionMysql->realizarConsulta($query,false);
		//return $funciono;
				
	}
	
*/


	public function agregarCriteriosEvaluacion($idModeloRubrica,$agregarModeloRubrica){
		$funcionoQueryAgregarCriteriosEvaluacion = true;
		$objCriterioEvaluacion = new AsignacionCriterioEvaluacion();
		if(!empty($agregarModeloRubrica)){
			$funcionoQueryAgregarCriteriosEvaluacion = $objCriterioEvaluacion->agregarAsignacionCriterioEvaluacion(
				$idModeloRubrica 
				,$agregarModeloRubrica);
		}
		return $funcionoQueryAgregarCriteriosEvaluacion;
	}

	public function listarRubricasPorPersona(){


		$CodPer=$this->conexionMysql->obtenerVariableSesion("CodPer");
		$query = "SELECT idModeloRubrica,Semestre_idSemestre ,Curso_idCurso ,calificacionRubrica ,fechaInicioRubrica ,fechaFinalRubrica  FROM modelorubrica AS M 
				  WHERE Docente_Persona_idPersona = '".$CodPer."'";
		$resultados = $this->conexionMysql->realizarConsulta($query,true);

		$misRubricas=array();
		foreach ($resultados as $resultado) {
	
			$querySemestre = "SELECT S.Semestre  FROM SEMESTRE AS S WHERE S.IdSem = '".$resultado["Semestre_idSemestre"]."'";
			$semestre = $this->conexionSqlServer->realizarConsulta($querySemestre,true);

			$queryCurso = "SELECT  c.DesCurso  from .curso as c where c.idcurso = '".$resultado["Curso_idCurso"]."'";
			$curso = $this->conexionSqlServer->realizarConsulta($queryCurso,true);
			$misRubricas[] = 
				array(
					"idModeloRubrica"=>$resultado["idModeloRubrica"],
					"semestre"=>$semestre[0]["Semestre"],
					"curso"=>$curso[0]["DesCurso"],
					"calificaA"=>$resultado["calificacionRubrica"],
					"fechaInicio"=>$resultado["fechaInicioRubrica"],
					"fechaFinal"=>$resultado["fechaFinalRubrica"]
					); 
		}

	
		$query = "SELECT  idModeloRubrica , Semestre_idSemestre ,Curso_idCurso ,calificacionRubrica ,idDocenteCalificador ,fechaFinalRubrica  FROM resultadorubrica AS R 
				  INNER JOIN modelorubrica AS M ON idModeloRubrica = R.ModeloRubrica_idModelRubrica 
				  WHERE R.idDocenteCalificador = '".$CodPer."'";

		$resultados = $this->conexionMysql->realizarConsulta($query,true);
		$misRubricasAsignadas=array();
		foreach ($resultados as $resultado) {
		
			$querySemestre = "SELECT S.Semestre  FROM SEMESTRE AS S WHERE S.IdSem = '".$resultado["Semestre_idSemestre"]."'";
			$semestre = $this->conexionSqlServer->realizarConsulta($querySemestre,true);
		
			$queryCurso = "SELECT  c.DesCurso  from .curso as c where c.idcurso = '".$resultado["Curso_idCurso"]."'";
			$curso = $this->conexionSqlServer->realizarConsulta($queryCurso,true);
		
			$queryDocente = "select p.ApepPer, p.ApemPer ,p.NomPer  from PERSONA as p where p.CodPer =  '".$resultado["idDocenteCalificador"]."'";
			$docente = $this->conexionSqlServer->realizarConsulta($queryDocente,true);

			$misRubricasAsignadas[] = 
				array("idModeloRubrica"=>$resultado["idModeloRubrica"],
					"semestre"=>$semestre[0]["Semestre"],
					"curso"=>$curso[0]["DesCurso"],
					"calificaA"=>$resultado["calificacionRubrica"],
					"autor"=>$docente[0]["ApepPer"]." ". $docente[0]["ApemPer"].", ".$docente[0]["NomPer"],
					"fechaFinal"=>$resultado["fechaFinalRubrica"]
					); 
		}

		$misRubricas_rubricasAsignadas=array();
		$misRubricas_rubricasAsignadas=array("misRubricas"=>$misRubricas,"rubricasAsignadas"=>$misRubricasAsignadas);
		return $misRubricas_rubricasAsignadas;
	}

	public function obtenerInformacionNuevaRubrica(){
		$cursosPorDocente = Curso::obtenerObjeto()->listarCursosDocente();
		$semestreActivo = Semestre::obtenerObjeto()->listarSemestreActivo();
		$resultadosAprendizaje = ResultadoAprendizaje::obtenerObjeto()->listarResultadoAprendizaje();
		$docentesActivos = Docente::obtenerObjeto()->listarDocenteActivo();
		return $this->conexionMysql->convertirJson(array("semestre"=>$semestreActivo
								,"cursos"=>$cursosPorDocente
								,"resultadosAprendizaje"=>$resultadosAprendizaje
								,"docentes"=>$docentesActivos));
	}

	public function obtenerRubricasPorPersona(){
		return $this->conexionMysql->convertirJson($this->listarRubricasPorPersona());
	}



	public function  listarCalificacionesPromedioPorModeloRubrica($idModeloRubrica){	
		
		$resultadoCalificacionesRA=array();
		$queryModeloRubrica = "SELECT M.Curso_idCurso ,M.Docente_Persona_idPersona ,M.Semestre_idSemestre  FROM modelorubrica AS M
							   WHERE M.idModeloRubrica = '".$idModeloRubrica."'";
		$resultadoModeloRubrica = $this->conexionMysql->realizarConsulta($queryModeloRubrica,true);	
		//CURSO
		$queryCurso = "SELECT C.CodCurso ,C.DesCurso ,C.CicloCurso  FROM curso AS C
					   WHERE C.idcurso ='".$resultadoModeloRubrica[0]['Curso_idCurso']."'";
		$resultadoCurso = $this->conexionSqlServer->realizarConsulta($queryCurso,true);
		//
		//CREADOR DE RUBRICA
		$queryDocenteCreador = "SELECT P.ApepPer ,P.ApemPer ,P.NomPer  FROM PERSONA AS P
							    WHERE P.CodPer ='".$resultadoModeloRubrica[0]['Docente_Persona_idPersona']."'";
		$resultadoDocenteCreador = $this->conexionSqlServer->realizarConsulta($queryDocenteCreador,true);
		//
		//SEMESTRE
		$querySemestre = "SELECT S.Semestre  FROM SEMESTRE AS S
						  WHERE S.IdSem ='".$resultadoModeloRubrica[0]['Semestre_idSemestre']."'";
		$resultadoSemestre = $this->conexionSqlServer->realizarConsulta($querySemestre,true);
		//
		$queryIdsResultadoRubrica = "SELECT R.idResultadoRubrica FROM resultadorubrica AS R
									 WHERE R.ModeloRubrica_idModelRubrica ='".$idModeloRubrica."'";
		$resultadoIdsResultadoRubrica = $this->conexionMysql->realizarConsulta($queryIdsResultadoRubrica,true);
		$promedioCalificaciones=array();
		$contadorpromedioCalificaciones=0;
		foreach($resultadoIdsResultadoRubrica as $IdResultadoRubrica){
				//Este resultdo a cuantos alumnos evalua
				$queryIdsAlumnosEvaluados = "SELECT A.idPersonaCalificada  FROM asignacionpersonacalificada AS A
											 WHERE A.ResultadoRubrica_idResultadoRubrica ='".$IdResultadoRubrica['idResultadoRubrica']."'";
				$resultadoIdsAlumnosEvaluados = $this->conexionMysql->realizarConsulta($queryIdsAlumnosEvaluados,true);
				foreach ($resultadoIdsAlumnosEvaluados as $idAlumno) {
						//Calificacines Agrupadas por Resultado de Aprendizaje
						$queryCalificaciones = "SELECT R.codigoResultadoAprendizaje ,SUM(C.calificacionResultadoRubrica) AS sumaCriterios, COUNT(C.calificacionResultadoRubrica) AS contadorCriterios
												FROM calificacioncriterioevaluacion AS C
												INNER JOIN asignacioncriterioevaluacion AS A ON A.idAsignacionCriterioEvaluacion = C.AsignacionCriterioEvaluacion_idAsignacionCriterioEvaluacion
												INNER JOIN criterioevaluacion AS CRI ON CRI.idCriterioEvaluacion = A.CriterioEvaluacion_idCriterioEvaluacion
												INNER JOIN resultadoaprendizaje AS R ON R.idResultadoAprendizaje = CRI.ResultadoAprendizaje_idResultadoAprendizaje 
												WHERE C.Rubrica_idResultadoRubrica ='".$IdResultadoRubrica['idResultadoRubrica']."' GROUP BY R.idResultadoAprendizaje";
						$resultadoCalificaciones = $this->conexionMysql->realizarConsulta($queryCalificaciones,true);
						$resultadoAprendizaje=array();
						$contadorresultadoAprendizaje=0;
						foreach ($resultadoCalificaciones as $calificacion) {  
								$resultadoAprendizaje[$contadorresultadoAprendizaje]= 
								array("codigoResultadoAprendizaje"=>$calificacion['codigoResultadoAprendizaje'],
									  "promedioCalificacionDocentes"=>$calificacion['sumaCriterios'] / $calificacion['contadorCriterios']	
									 ); 
								$contadorresultadoAprendizaje++;
						}
						//
						//ALUMNO CALIFICADO
						$queryAlumno = "SELECT P.ApepPer ,P.ApemPer ,P.NomPer  FROM PERSONA AS P
							    WHERE P.CodPer ='".$idAlumno['idPersonaCalificada']."'";
						$resultadoAlumno = $this->conexionSqlServer->realizarConsulta($queryDocenteCreador,true);
						//
						$promedioCalificaciones[$contadorpromedioCalificaciones]= 
								array("nombreAlumno"=>$resultadoAlumno[0]['ApepPer']." ".$resultadoAlumno[0]['ApemPer'].", ".$resultadoAlumno[0]['NomPer'],
									  "resultadoAprendizaje"=>$resultadoAprendizaje	
									 ); 
				$contadorpromedioCalificaciones++;
				}		
		}
		$resultadoCalificacionesRA = 
				array("curso"=>$resultadoCurso[0]['CodCurso']." ".$resultadoCurso[0]['DesCurso'],
					"docenteCreadoRubrica"=>$resultadoDocenteCreador[0]['ApepPer']." ".$resultadoDocenteCreador[0]['ApemPer'].", ".$resultadoDocenteCreador[0]['NomPer'],
					"ciclo"=>$resultadoCurso[0]['CicloCurso'],
					"semestre"=>$resultadoSemestre[0]['Semestre'],
					"promedioCalificaciones"=>$promedioCalificaciones
					); 
		$resultadoJson = $this->conexionMysql->convertirJson($resultadoCalificacionesRA);
		return $resultadoJson;
	}
}




