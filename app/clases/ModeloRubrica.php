<?php

class ModeloRubrica extends Master{

	//QUERYS
	protected function queryListarModeloRubricaPorPersona($idSemestre=null){
		$CodPer=$this->conexionSqlServer->obtenerVariableSesion("CodPer");
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
		return $query;
	}

	protected function queryAgregarModeloRubrica($modeloRubrica){
		$CodPer=$this->conexionSqlServer->obtenerVariableSesion("CodPer");
		$query = 
		"INSERT INTO modelorubrica
		(idCurso
		,idSemestre
		,fechaInicioRubrica
		,fechaFinalRubrica
		,idPersonaCreadorRubrica
		,personaCalificada)
		VALUES ('".$modeloRubrica["idCurso"]."'
				,'".$modeloRubrica["idSemestre"]."'
				,'".$modeloRubrica["fechaInicio"]."'
				,'".$modeloRubrica["fechaFinal"]."'
				,'".$CodPer."'
				,'".$modeloRubrica["calificacionRubrica"]."')";
		return $query;
	}
	//METODOS

	protected function listarModeloRubricaPorPersona($idSemestre = null){
		if(is_null($idSemestre)){
			$resultado = $this->conexionSqlServer->realizarConsulta($this->queryListarModeloRubricaPorPersona(),true);
		}else{
			$resultado = $this->conexionSqlServer->realizarConsulta($this->queryListarModeloRubricaPorPersona($idSemestre),true);
		}
		return $resultado;
	}

	public function agregarModeloRubrica($modeloRubrica){
		$this->conexionSqlServer->iniciarTransaccion();
		try{
			$idModeloRubrica = $this->conexionSqlServer->returnId()->realizarConsulta($this->queryAgregarModeloRubrica($modeloRubrica),false);
			ResultadoRubrica::obtenerObjeto()->agregarResultadoRubrica($idModeloRubrica,$modeloRubrica);
			$criteriosEvaluacion = $this->obtenerArrayCriteriosEvaluacion($modeloRubrica["resultadosAprendizaje"]);
			AsignacionCriterioEvaluacion::obtenerObjeto()->agregarAsignacionCriterioEvaluacion($idModeloRubrica,$criteriosEvaluacion);
			$this->conexionSqlServer->commit();
		}catch(PDOException $ex){
			$this->conexionSqlServer->rollback();
			throw new PDOException($ex->getMessage());
		}
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

	// public function agregarCriteriosEvaluacion($idModeloRubrica,$agregarModeloRubrica){
	// 	$funcionoQueryAgregarCriteriosEvaluacion = true;
	// 	$objCriterioEvaluacion = AsignacionCriterioEvaluacion::obtenerObjeto();
	// 	if(!empty($agregarModeloRubrica)){
	// 		$funcionoQueryAgregarCriteriosEvaluacion = $objCriterioEvaluacion->agregarAsignacionCriterioEvaluacion(
	// 			$idModeloRubrica 
	// 			,$agregarModeloRubrica);
	// 	}
	// 	return $funcionoQueryAgregarCriteriosEvaluacion;
	// }


	public function listarRubricasPorPersona($idSemestre=null){
		$objResultadoRubrica = ResultadoRubrica::obtenerObjeto();
		if(is_null($idSemestre)){
			$resultadoMisRubricas = $this->listarModeloRubricaPorPersona();
			$resultadoRubricasAsignadas=$objResultadoRubrica->listarResultadoRubricaPorDocente();
		}else{
			$resultadoMisRubricas = $this->listarModeloRubricaPorPersona($idSemestre);
			$resultadoRubricasAsignadas=$objResultadoRubrica->listarResultadoRubricaPorDocente($idSemestre);
		}
		$resultado=array(
			"misRubricas"=>$resultadoMisRubricas
			,"rubricasAsignadas"=>$resultadoRubricasAsignadas);
		return $resultado;
	}

	public function obtenerInformacionNuevaRubrica(){
		$cursosPorDocente = Curso::obtenerObjeto()->listarCursosDocente();
		$semestreActivo = Semestre::obtenerObjeto()->listarSemestreActivo();
		$resultadosAprendizaje = ResultadoAprendizaje::obtenerObjeto()->obtenerResultadosAprendizaje();
		$docentesActivos = Persona::obtenerObjeto()->listarDocentesActivos();
		$resultado =  array("semestre"=>$semestreActivo
								,"cursos"=>$cursosPorDocente
								,"resultadosAprendizaje"=>$resultadosAprendizaje
								,"docentes"=>$docentesActivos);
		return $resultado;
	}

	public function obtenerRubricasPorPersona($idSemestre=null){
		if(is_null($idSemestre)){
			$resultado = $this->listarRubricasPorPersona();
			$resultado["semestres"] = Semestre::obtenerObjeto()->listarSemestre();
		}else{
			$resultado = $this->listarRubricasPorPersona($idSemestre);
		}
		return $resultado;
	}

	// public function listarModeloRubricaPorResultadoRubrica($idResultadoRubrica){
	// 	$query = 
	// 	"SELECT M.idModeloRubrica
	// 			,M.idSemestre
	// 			,M.idCurso
	// 			,M.idPersonaCreadorRubrica
	// 		FROM modelorubrica AS M
	// 		INNER JOIN resultadorubrica as R
	// 			ON R.idModeloRubrica = M.idModeloRubrica AND R.idResultadoRubrica = '".$idResultadoRubrica."'";
	// 	$resultado = $this->conexionSqlServer->realizarConsulta($query,true);
	// 	return $resultado[0];
	// }



	// public function  listarCalificacionesPromedioPorModeloRubrica($idModeloRubrica){	
		
	// 	$resultadoCalificacionesRA=array();
	// 	$queryModeloRubrica = "SELECT M.idCurso ,M.idPersonaCreadorRubrica ,M.idSemestre  FROM modelorubrica AS M
	// 						   WHERE M.idModeloRubrica = '".$idModeloRubrica."'";
	// 	$resultadoModeloRubrica = $this->conexionSqlServer->realizarConsulta($queryModeloRubrica,true);	
	// 	//CURSO
	// 	$queryCurso = "SELECT C.CodCurso ,C.DesCurso ,C.CicloCurso  FROM curso AS C
	// 				   WHERE C.idcurso ='".$resultadoModeloRubrica[0]['idCurso']."'";
	// 	$resultadoCurso = $this->conexionSqlServer->realizarConsulta($queryCurso,true);
	// 	//
	// 	//CREADOR DE RUBRICA
	// 	$queryDocenteCreador = "SELECT P.ApepPer ,P.ApemPer ,P.NomPer  FROM PERSONA AS P
	// 						    WHERE P.CodPer ='".$resultadoModeloRubrica[0]['idPersonaCreadorRubrica']."'";
	// 	$resultadoDocenteCreador = $this->conexionSqlServer->realizarConsulta($queryDocenteCreador,true);
	// 	//
	// 	//SEMESTRE
	// 	$querySemestre = "SELECT S.Semestre  FROM SEMESTRE AS S
	// 					  WHERE S.IdSem ='".$resultadoModeloRubrica[0]['idSemestre']."'";
	// 	$resultadoSemestre = $this->conexionSqlServer->realizarConsulta($querySemestre,true);
	// 	//
	// 	$queryIdsResultadoRubrica = "SELECT R.idResultadoRubrica FROM resultadorubrica AS R
	// 								 WHERE R.idModeloRubrica ='".$idModeloRubrica."'";
	// 	$resultadoIdsResultadoRubrica = $this->conexionSqlServer->realizarConsulta($queryIdsResultadoRubrica,true);
	// 	$promedioCalificaciones=array();
	// 	$contadorpromedioCalificaciones=0;
	// 	foreach($resultadoIdsResultadoRubrica as $IdResultadoRubrica){
	// 			//Este resultdo a cuantos alumnos evalua
	// 			$queryIdsAlumnosEvaluados = "SELECT A.idPersonaCalificada  FROM asignacionpersonacalificada AS A
	// 										 WHERE A.ResultadoidResultadoRubrica ='".$IdResultadoRubrica['idResultadoRubrica']."'";
	// 			$resultadoIdsAlumnosEvaluados = $this->conexionSqlServer->realizarConsulta($queryIdsAlumnosEvaluados,true);
	// 			foreach ($resultadoIdsAlumnosEvaluados as $idAlumno) {
	// 					//Calificacines Agrupadas por Resultado de Aprendizaje
	// 					$queryCalificaciones = "SELECT R.codigoResultadoAprendizaje ,SUM(C.calificacionResultadoRubrica) AS sumaCriterios, COUNT(C.calificacionResultadoRubrica) AS contadorCriterios
	// 											FROM calificacioncriterioevaluacion AS C
	// 											INNER JOIN asignacioncriterioevaluacion AS A ON A.idAsignacionCriterioEvaluacion = C.idAsignacionCriterioEvaluacion
	// 											INNER JOIN criterioevaluacion AS CRI ON CRI.idCriterioEvaluacion = A.CriterioEvaluacion_idCriterioEvaluacion
	// 											INNER JOIN resultadoaprendizaje AS R ON R.idResultadoAprendizaje = CRI.idResultadoAprendizaje 
	// 											WHERE C.idResultadoRubrica ='".$IdResultadoRubrica['idResultadoRubrica']."' GROUP BY R.idResultadoAprendizaje";
	// 					$resultadoCalificaciones = $this->conexionSqlServer->realizarConsulta($queryCalificaciones,true);
	// 					$resultadoAprendizaje=array();
	// 					$contadorresultadoAprendizaje=0;
	// 					foreach ($resultadoCalificaciones as $calificacion) {  
	// 							$resultadoAprendizaje[$contadorresultadoAprendizaje]= 
	// 							array("codigoResultadoAprendizaje"=>$calificacion['codigoResultadoAprendizaje'],
	// 								  "promedioCalificacionDocentes"=>$calificacion['sumaCriterios'] / $calificacion['contadorCriterios']	
	// 								 ); 
	// 							$contadorresultadoAprendizaje++;
	// 					}
	// 					//
	// 					//ALUMNO CALIFICADO
	// 					$queryAlumno = "SELECT P.ApepPer ,P.ApemPer ,P.NomPer  FROM PERSONA AS P
	// 						    WHERE P.CodPer ='".$idAlumno['idPersonaCalificada']."'";
	// 					$resultadoAlumno = $this->conexionSqlServer->realizarConsulta($queryDocenteCreador,true);
	// 					//
	// 					$promedioCalificaciones[$contadorpromedioCalificaciones]= 
	// 							array("nombreAlumno"=>$resultadoAlumno[0]['ApepPer']." ".$resultadoAlumno[0]['ApemPer'].", ".$resultadoAlumno[0]['NomPer'],
	// 								  "resultadoAprendizaje"=>$resultadoAprendizaje	
	// 								 ); 
	// 			$contadorpromedioCalificaciones++;
	// 			}		
	// 	}
	// 	$resultadoCalificacionesRA = 
	// 			array("curso"=>$resultadoCurso[0]['CodCurso']." ".$resultadoCurso[0]['DesCurso'],
	// 				"docenteCreadoRubrica"=>$resultadoDocenteCreador[0]['ApepPer']." ".$resultadoDocenteCreador[0]['ApemPer'].", ".$resultadoDocenteCreador[0]['NomPer'],
	// 				"ciclo"=>$resultadoCurso[0]['CicloCurso'],
	// 				"semestre"=>$resultadoSemestre[0]['Semestre'],
	// 				"promedioCalificaciones"=>$promedioCalificaciones
	// 				); 
	// 	$resultadoJson = $this->conexionSqlServer->convertirJson($resultadoCalificacionesRA);
	// 	return $resultadoJson;
	// }
}




