<?php

class ResultadoRubrica extends Master{

	//QUERYES

	public function queryListarResultadoRubricaPorDocente($idSemestre=null){
		$CodPer = $this->conexionSqlServer->obtenerVariableSesion("CodPer");
		$query = 
		"SELECT 
			M.idModeloRubrica
			,P.ApepPer+' '+P.ApemPer+', '+P.NomPer AS autor
			,M.personaCalificada
			,C.DesCurso as curso
			,M.fechaFinalRubrica
			,(CASE WHEN 
				COUNT(CASE WHEN R.estadoRubrica='Completado' THEN 1 END)
				=COUNT(R.idResultadoRubrica) 
				THEN 'Completado' ELSE 'Pendiente' END) AS estadoRubrica
		FROM ResultadoRubrica AS R
		INNER JOIN ModeloRubrica AS M
			ON M.idModeloRubrica = R.idModeloRubrica
		INNER JOIN PERSONA AS P
			ON P.CodPer = M.idPersonaCreadorRubrica
		INNER JOIN Curso AS C
			ON M.idcurso = C.idCurso
		INNER JOIN Semestre AS S
			on S.idsem = M.idSemestre
				  WHERE R.idPersonaCalificadora = '".$CodPer."'";
		if(is_null($idSemestre)){
			$query.= " AND S.Activo = '1' 
			GROUP BY M.idModeloRubrica
					,P.ApepPer+' '+P.ApemPer+', '+P.NomPer
					,M.personaCalificada
					,C.DesCurso
					,M.fechaFinalRubrica";
		}else{
			$query.= " AND M.idSemestre = '".$idSemestre."' 
			GROUP BY M.idModeloRubrica
					,P.ApepPer+' '+P.ApemPer+', '+P.NomPer
					,M.personaCalificada
					,C.DesCurso
					,M.fechaFinalRubrica";
		}
		return $query;
	}

	public function queryAgregarResultadoRubrica($idModeloRubrica,$idDocente){
		$query = 
				"INSERT INTO resultadoRubrica(
					idPersonaCalificadora
					,idModeloRubrica
					)
				VALUES
					(".$idDocente."
					,".$idModeloRubrica."
					)";
		return $query;
	}

	public function queryListarResultadoRubricaPorRubricaAsignada($idModeloRubrica,$idDocenteCalificador){
		$query =
		"SELECT R.idResultadoRubrica
			,R.fechaCompletadoRubrica
			,R.totalRubrica
			,R.estadoRubrica  
		FROM resultadorubrica AS R
				  WHERE R.idModeloRubrica = '".$idModeloRubrica."'" ." 
				  	AND R.idPersonaCalificadora = '".$idDocenteCalificador."'";
		return $query;
	}

	public function queryModificarResultadoRubrica($resultadoRubrica){
		$query = 
		"UPDATE resultadorubrica
			SET
			totalRubrica = '".$resultadoRubrica["total"]."'
			,estadoRubrica = 'Completado'
			,fechaCompletadoRubrica = '".date('d/m/Y')."'
			WHERE idResultadoRubrica = '".$resultadoRubrica["idResultadoRubrica"]."'";
		return $query;
	}

	public function queryListarResultadoRubricaPorModeloRubrica($idModeloRubrica){
		$query =
		"SELECT R.idResultadoRubrica
				,R.fechaCompletadoRubrica
				,R.totalRubrica
				,R.estadoRubrica
				,P.ApepPer+' '+P.ApemPer+', '+P.NomPer as docenteCalificador
		FROM ResultadoRubrica as R
		INNER JOIN Persona as P
			ON P.CodPer = R.idPersonaCalificadora
				WHERE R.idModeloRubrica ='".$idModeloRubrica."'";
		return $query;
	}

	
	//METODOS

	public function listarResultadoRubricaPorDocente($idSemestre=null){
		if(is_null($idSemestre)){
			$resultado = $this->conexionSqlServer->realizarConsulta($this->queryListarResultadoRubricaPorDocente(),true);
		}else{
			$resultado = $this->conexionSqlServer->realizarConsulta($this->queryListarResultadoRubricaPorDocente($idSemestre),true);
		}
		return $resultado;
	}

	public function agregarResultadoRubrica($idModeloRubrica,$modeloRubrica){
		foreach($modeloRubrica["docentes"] as $idDocente){
			foreach ($modeloRubrica["alumnos"] as $alumno) {
				$idResultadoRubrica = $this->conexionSqlServer->returnId()->realizarConsulta($this->queryAgregarResultadoRubrica($idModeloRubrica,$idDocente),false);	
				AsignacionPersonaCalificada::obtenerObjeto()->agregarAsignacionPersonaCalificada($idResultadoRubrica,$alumno);
			}
		}
  	}

	public function obtenerResultadoRubricaPorModeloRubrica($idModeloRubrica){
		$resultadosRubrica = $this->conexionSqlServer->realizarConsulta($this->queryListarResultadoRubricaPorModeloRubrica($idModeloRubrica),true);
		foreach($resultadosRubrica as &$resultadoRubrica){
			$resultadoRubrica["alumnosCalificados"] = AsignacionPersonaCalificada::obtenerObjeto()->listarAsignacionPersonaCalificadaPorResultadoRubrica($resultadoRubrica["idResultadoRubrica"]);
		}
		return $resultadosRubrica;
	}

	public function obtenerResultadoRubricaPorRubricaAsignada($idModeloRubrica){
		$CodPer=$this->conexionSqlServer->obtenerVariableSesion("CodPer");
		$resultado = $this->conexionSqlServer->realizarConsulta($this->queryListarResultadoRubricaPorRubricaAsignada($idModeloRubrica,$CodPer),true);
		foreach ($resultado as &$resultadoRubrica) {
			$resultadoRubrica["alumnosCalificados"] = AsignacionPersonaCalificada::obtenerObjeto()->listarAsignacionPersonaCalificadaPorResultadoRubrica($resultadoRubrica["idResultadoRubrica"]);
		}
		return $resultado;
	}

	public function obtenerResultadoRubricaPorId($idResultadoRubrica){
		$resultadoRubrica = ModeloRubrica::obtenerObjeto()->listarModeloRubricaPorResultadoRubrica($idResultadoRubrica);
		$resultadoRubrica["alumnosCalificados"] = AsignacionPersonaCalificada::obtenerObjeto()->listarAsignacionPersonaCalificadaPorResultadoRubrica($idResultadoRubrica);
		$resultadoRubrica["criteriosEvaluacion"]=AsignacionCriterioEvaluacion::obtenerObjeto()->listarAsignacionCriterioEvaluacionPorModeloRubrica($resultadoRubrica["idModeloRubrica"]);
		return $resultadoRubrica;
	}

	public function completarResultadoRubrica($resultadoRubrica){
		$this->conexionSqlServer->iniciarTransaccion();
		try{
			$resultadoRubrica["total"] = $this->obtenerTotalResultadoRubrica($resultadoRubrica["resultadosAprendizaje"]);
			$this->modificarResultadoRubrica($resultadoRubrica);
			CalificacionCriterioEvaluacion::obtenerObjeto()->agregarCalificacionCriterioEvaluacion($resultadoRubrica["idResultadoRubrica"],$resultadoRubrica["resultadosAprendizaje"]);
			$this->conexionSqlServer->commit();
		}catch(PDOException $ex){
			$this->conexionSqlServer->rollback();
			throw new PDOException($ex->getMessage());
		}
	}

	public function modificarResultadoRubrica($resultadoRubrica){
		return $this->conexionSqlServer->realizarConsulta($this->queryModificarResultadoRubrica($resultadoRubrica),false);
	} 

	public function obtenerTotalResultadoRubrica($resultadosAprendizaje){
		$total = 0;
		foreach ($resultadosAprendizaje as $resultadoAprendizaje) {
			$totalResultadoAprendizaje = 0;
			foreach($resultadoAprendizaje as $criterioEvaluacion){
				$totalResultadoAprendizaje += (int)($criterioEvaluacion["calificacion"]);
			}
			$total += $totalResultadoAprendizaje/count($resultadoAprendizaje);
		}
		return $total/count($resultadosAprendizaje);
	}
}
