<?php

header('Content-type: application/json');

require_once('Conexion.php');
require_once('AsignacionCriterioEvaluacion.php');
require_once('Semestre.php');
require_once('ResultadoAprendizaje.php');
require_once('Curso.php');
require_once('Persona.php');
require_once('ResultadoRubrica.php');

class ModeloRubrica extends Singleton{

	private $conexionSqlServer;

	public function __construct(){
		$this->conexionSqlServer = ConexionFactory::obtenerConexion('sqlserver');
	}

	public function listarUltimoPrimaryKey($nombreCampoID,$tabla){
		$query1="select LAST_INSERT_ID(".$nombreCampoID.") from ".$tabla;
		$resultadoQuery = $this->conexionSqlServer->realizarConsulta($query1,true);
		$query2.="select LAST_INSERT_ID()";
		$resultadoQuery2 = $this->conexionSqlServer->realizarConsulta($query2,true);
		return $resultadoQuery2[0]['LAST_INSERT_ID()'];
	}

	public function agregarModeloRubrica($modeloRubrica){
		$CodPer = $this->conexionSqlServer->obtenerVariableSesion("CodPer");
		$queryInsertarModeloRubrica="insert into modelorubrica
		(idCurso, idSemestre, fechaInicioRubrica,fechaFinalRubrica,
		 idPersonaCreadorRubrica,personaCalificada)
		values ('".$modeloRubrica["idCurso"]."'
				,'".$modeloRubrica["idSemestre"]."'
				,'".$modeloRubrica["fechaInicio"]."'
				,'".$modeloRubrica["fechaFinal"]."'
				,'".$CodPer."'
				,'".$modeloRubrica["calificacionRubrica"]."')";
		return $this->conexionSqlServer->returnId()->realizarConsulta($queryInsertarModeloRubrica,false);
	}

	public function agregarModeloRubricaYAsignarCriterios($modeloRubrica){
		$funcionoModeloRubrica = false;
		$funcionoCriteriosEvaluacion = false;
		$funcionoResultadoRubrica = false;
		$this->conexionSqlServer->iniciarTransaccion();
		$idModeloRubrica = $this->agregarModeloRubrica($modeloRubrica);
		if($idModeloRubrica!=false){
			$funcionoModeloRubrica = true;
			$funcionoResultadoRubrica = ResultadoRubrica::obtenerObjeto()->agregarResultadoRubricaYAsignacionPersonaCalificada($idModeloRubrica,$modeloRubrica);
		}
		$criteriosEvaluacion = $this->obtenerArrayCriteriosEvaluacion($modeloRubrica["resultadosAprendizaje"]);
		$funcionoCriteriosEvaluacion = $this->agregarCriteriosEvaluacion($idModeloRubrica,$criteriosEvaluacion);
		$funcionoTransaccion = 
			$this->conexionSqlServer->finalizarTransaccion(
				array($funcionoModeloRubrica					
					,$funcionoCriteriosEvaluacion
					,$funcionoResultadoRubrica)
				);
		echo $idModeloRubrica;
		return $funcionoTransaccion;
	}

	public function obtenerArrayCriteriosEvaluacion($resultadosAprendizaje){
		$criteriosEvaluacion = array();
		foreach ($resultadosAprendizaje as $resultadoAprendizaje) {
			foreach($resultadoAprendizaje["criteriosEvaluacion"] as $criterioEvaluacion){
				$criteriosEvaluacion[] = $criterioEvaluacion["idCriterioEvaluacion"];
			}
		}
		return $criteriosEvaluacion;
	}

	public function agregarCriteriosEvaluacion($idModeloRubrica,$agregarModeloRubrica){
		$funcionoQueryAgregarCriteriosEvaluacion = true;
		$objCriterioEvaluacion = AsignacionCriterioEvaluacion::obtenerObjeto();
		if(!empty($agregarModeloRubrica)){
			$funcionoQueryAgregarCriteriosEvaluacion = $objCriterioEvaluacion->agregarAsignacionCriterioEvaluacion(
				$idModeloRubrica 
				,$agregarModeloRubrica);
		}
		return $funcionoQueryAgregarCriteriosEvaluacion;
	}

	public function listarModeloRubricaPorPersona($CodPer,$idSemestre=null){
		$query = 
		"SELECT M.idModeloRubrica
				,S.Semestre AS semestre 
				,C.CodCurso+' '+C.DesCurso AS curso
				,M.personaCalificada 
				,M.fechaInicioRubrica 
				,M.fechaFinalRubrica  
		FROM ModeloRubrica AS M
		INNER JOIN Curso AS C
			ON C.idcurso = M.idcurso
		INNER JOIN Semestre AS S
			ON S.idSem = M.idSemestre
			WHERE M.idPersonaCreadorRubrica = '".$CodPer."'";
		if(is_null($idSemestre)){
			$query.= " AND S.Activo = '1'";
		}else{
			$query.= " AND M.idSemestre = '".$idSemestre."'";
		}
		// echo $query;
		return $this->conexionSqlServer->realizarConsulta($query,true);
	}

	public function listarRubricasPorPersona($idSemestre=null){
		$CodPer=$this->conexionSqlServer->obtenerVariableSesion("CodPer");
		if(is_null($idSemestre)){
			$resultadoMisRubricas = $this->listarModeloRubricaPorPersona($CodPer);
			$resultadoRubricasAsignadas=ResultadoRubrica::obtenerObjeto()->listarResultadoRubricaPorDocente($CodPer);
		}else{
			$resultadoMisRubricas = $this->listarModeloRubricaPorPersona($CodPer,$idSemestre);
			$resultadoRubricasAsignadas=ResultadoRubrica::obtenerObjeto()->listarResultadoRubricaPorDocente($CodPer,$idSemestre);
		}
		$resultado=array("misRubricas"=>$resultadoMisRubricas,"rubricasAsignadas"=>$resultadoRubricasAsignadas);
		return $resultado;
	}

	public function listarRubricasPorPersonaPorSemestre($idSemestre){

	}

	public function obtenerInformacionNuevaRubrica(){
		$cursosPorDocente = Curso::obtenerObjeto()->listarCursosDocente();
		$semestreActivo = Semestre::obtenerObjeto()->listarSemestreActivo();
		$resultadosAprendizaje = ResultadoAprendizaje::obtenerObjeto()->listarResultadoAprendizaje();
		$docentesActivos = Persona::obtenerObjeto()->listarDocentesActivos();
		return $this->conexionSqlServer->convertirJson(array("semestre"=>$semestreActivo
								,"cursos"=>$cursosPorDocente
								,"resultadosAprendizaje"=>$resultadosAprendizaje
								,"docentes"=>$docentesActivos));
	}

	public function obtenerRubricasPorPersona($idSemestre=null){
		if(is_null($idSemestre)){
			$resultado = $this->listarRubricasPorPersona();
			$resultado["semestres"] = Semestre::obtenerObjeto()->listarSemestre();
		}else{
			$resultado = $this->listarRubricasPorPersona($idSemestre);
		}
		return $this->conexionSqlServer->convertirJson($resultado);
	}

	public function listarModeloRubricaPorResultadoRubrica($idResultadoRubrica){
		$query = 
		"SELECT M.idModeloRubrica
				,M.idSemestre
				,M.idCurso
				,M.idPersonaCreadorRubrica
			FROM modelorubrica AS M
			INNER JOIN resultadorubrica as R
				ON R.idModeloRubrica = M.idModeloRubrica AND R.idResultadoRubrica = '".$idResultadoRubrica."'";
		$resultado = $this->conexionSqlServer->realizarConsulta($query,true);
		return $resultado[0];
	}



	public function  listarCalificacionesPromedioPorModeloRubrica($idModeloRubrica){	
		
		$resultadoCalificacionesRA=array();
		$queryModeloRubrica = "SELECT M.idCurso ,M.idPersonaCreadorRubrica ,M.idSemestre  FROM modelorubrica AS M
							   WHERE M.idModeloRubrica = '".$idModeloRubrica."'";
		$resultadoModeloRubrica = $this->conexionSqlServer->realizarConsulta($queryModeloRubrica,true);	
		//CURSO
		$queryCurso = "SELECT C.CodCurso ,C.DesCurso ,C.CicloCurso  FROM curso AS C
					   WHERE C.idcurso ='".$resultadoModeloRubrica[0]['idCurso']."'";
		$resultadoCurso = $this->conexionSqlServer->realizarConsulta($queryCurso,true);
		//
		//CREADOR DE RUBRICA
		$queryDocenteCreador = "SELECT P.ApepPer ,P.ApemPer ,P.NomPer  FROM PERSONA AS P
							    WHERE P.CodPer ='".$resultadoModeloRubrica[0]['idPersonaCreadorRubrica']."'";
		$resultadoDocenteCreador = $this->conexionSqlServer->realizarConsulta($queryDocenteCreador,true);
		//
		//SEMESTRE
		$querySemestre = "SELECT S.Semestre  FROM SEMESTRE AS S
						  WHERE S.IdSem ='".$resultadoModeloRubrica[0]['idSemestre']."'";
		$resultadoSemestre = $this->conexionSqlServer->realizarConsulta($querySemestre,true);
		//
		$queryIdsResultadoRubrica = "SELECT R.idResultadoRubrica FROM resultadorubrica AS R
									 WHERE R.idModeloRubrica ='".$idModeloRubrica."'";
		$resultadoIdsResultadoRubrica = $this->conexionSqlServer->realizarConsulta($queryIdsResultadoRubrica,true);
		$promedioCalificaciones=array();
		$contadorpromedioCalificaciones=0;
		foreach($resultadoIdsResultadoRubrica as $IdResultadoRubrica){
				//Este resultdo a cuantos alumnos evalua
				$queryIdsAlumnosEvaluados = "SELECT A.idPersonaCalificada  FROM asignacionpersonacalificada AS A
											 WHERE A.ResultadoidResultadoRubrica ='".$IdResultadoRubrica['idResultadoRubrica']."'";
				$resultadoIdsAlumnosEvaluados = $this->conexionSqlServer->realizarConsulta($queryIdsAlumnosEvaluados,true);
				foreach ($resultadoIdsAlumnosEvaluados as $idAlumno) {
						//Calificacines Agrupadas por Resultado de Aprendizaje
						$queryCalificaciones = "SELECT R.codigoResultadoAprendizaje ,SUM(C.calificacionResultadoRubrica) AS sumaCriterios, COUNT(C.calificacionResultadoRubrica) AS contadorCriterios
												FROM calificacioncriterioevaluacion AS C
												INNER JOIN asignacioncriterioevaluacion AS A ON A.idAsignacionCriterioEvaluacion = C.idAsignacionCriterioEvaluacion
												INNER JOIN criterioevaluacion AS CRI ON CRI.idCriterioEvaluacion = A.CriterioEvaluacion_idCriterioEvaluacion
												INNER JOIN resultadoaprendizaje AS R ON R.idResultadoAprendizaje = CRI.idResultadoAprendizaje 
												WHERE C.idResultadoRubrica ='".$IdResultadoRubrica['idResultadoRubrica']."' GROUP BY R.idResultadoAprendizaje";
						$resultadoCalificaciones = $this->conexionSqlServer->realizarConsulta($queryCalificaciones,true);
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
		$resultadoJson = $this->conexionSqlServer->convertirJson($resultadoCalificacionesRA);
		return $resultadoJson;
	}
}




