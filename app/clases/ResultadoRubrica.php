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

	// public function listarResultadoRubricaPorIDModeloRubrica($idModeloRubrica){
	
	// 	$query = "SELECT R.IDRESULTADORUBRICA ,R.FECHACOMPLETADORUBRICA, R.TOTALRUBRICA ,R.ESTADORUBRICA , R.idPersonaCalificadora 
	// 			  FROM RESULTADORUBRICA AS R WHERE R.idModeloRubrica = '".$idModeloRubrica."'";
	// 	$resultados = $this->conexionSqlServer->realizarConsulta($query,true);

	// 	$respaldo=array();
	// 	$contadorResultado=0;
		
	// 	foreach ($resultados as $resultado) {
		
	// 		$idPersonasEvaluadas= "SELECT a.idPersonaCalificada   from asignacionpersonacalificada as a 
	// 							where a.idResultadoRubrica ='".$resultado["IDRESULTADORUBRICA"]."'";
	// 		$resultadosidPersonasEvaluadas = $this->conexionSqlServer->realizarConsulta($idPersonasEvaluadas,true);
			
	// 		$personasEvaluadas=array();
	// 		$i=0;
	// 		$evaluador="";

	// 		foreach ($resultadosidPersonasEvaluadas as $id ) {
				
	// 				$consulta = "select p.ApepPer , p.ApemPer , p.NomPer  from PERSONA as p 
	// 							where p.CodPer ='".$id["idPersonaCalificada"]."'";
	// 				$resultados = $this->conexionSqlServer->realizarConsulta($consulta,true);

	// 				foreach ($resultados as $persona) {	
	// 					$personasEvaluadas[$i]=array("nombreCompletoAlumno"=>$persona["ApepPer"]." ". $persona["ApemPer"].", ".$persona["NomPer"]);
	// 			 		$i++;
	// 				}	
	// 		}

	// 		$consultax = "SELECT P.APEPPER , P.APEMPER , P.NOMPER  FROM PERSONA AS P WHERE P.CODPER = '".$resultado["idPersonaCalificadora"]."'";
	// 		$evaluador = $this->conexionSqlServer->realizarConsulta($consultax,true);
			
	// 		$respaldo[$contadorResultado] = 
	// 			array("idResultadoRubrica"=>$resultado["IDRESULTADORUBRICA"],					
	// 				"alumnosCalificados"=>$personasEvaluadas,
	// 				"docenteCalificador"=>$evaluador[0]["APEPPER"]." ". $evaluador[0]["APEMPER"].", ".$evaluador[0]["NOMPER"],
	// 				"fechaCompletadoRubrica"=>$resultado["FECHACOMPLETADORUBRICA"],
	// 				"totalRubrica"=>$resultado["TOTALRUBRICA"],
	// 				"estadoRubrica"=>$resultado["ESTADORUBRICA"]
					
	// 				); 
	// 		$contadorResultado++;
	// 	}

	// 	$resultadoJson = $this->conexionSqlServer->convertirJson($respaldo);
	// 	return $resultadoJson;
	// }

	public function obtenerResultadoRubricaPorRubricaAsignada($idModeloRubrica){
		$CodPer=$this->conexionSqlServer->obtenerVariableSesion("CodPer");
		$resultado = $this->conexionSqlServer->realizarConsulta($this->queryListarResultadoRubricaPorRubricaAsignada($idModeloRubrica,$CodPer),true);
		foreach ($resultado as &$resultadoRubrica) {
			$personasCalificadas = AsignacionPersonaCalificada::obtenerObjeto()->listarAsignacionPersonaCalificadaPorResultadoRubrica($resultadoRubrica["idResultadoRubrica"]);
			foreach ($personasCalificadas as $personaCalificada) {
				$persona = Persona::obtenerObjeto()->listarPersonaPorId($personaCalificada["idPersonaCalificada"]);
				$nombreCompletoAlumno = Persona::obtenerObjeto()->obtenerNombreCompletoPersona($persona);
				$resultadoRubrica["alumnosCalificados"][] = array("nombreCompletoAlumno"=>$nombreCompletoAlumno);
			}
		}
		return $resultado;
	}

	// public function obtenerResultadoRubricaPorID($idResultadoRubrica){
	// 	$modeloRubrica = ModeloRubrica::obtenerObjeto()->listarModeloRubricaPorResultadoRubrica($idResultadoRubrica);
	// 	$semestre = Semestre::obtenerObjeto()->listarSemestrePorId($modeloRubrica['idSemestre']);
	// 	$curso = Curso::obtenerObjeto()->listarCursoPorId($modeloRubrica['idCurso']);
	// 	$docente = Persona::obtenerObjeto()->listarPersonaPorId($modeloRubrica['idPersonaCreadorRubrica']);
	// 	$alumnosCalificados = AsignacionPersonaCalificada::obtenerObjeto()->listarAsignacionPersonaCalificadaPorResultadoRubrica($idResultadoRubrica);
	// 	foreach ($alumnosCalificados as &$alumnoCalificado) {
	// 			$alumno = Persona::obtenerObjeto()->listarPersonaPorId($alumnoCalificado["idPersonaCalificada"]);
	// 			$alumnoCalificado["nombreCompletoAlumno"] = Persona::obtenerObjeto()->obtenerNombreCompletoPersona($alumno);
	// 			unset($alumnoCalificado["idPersonaCalificada"]);
	// 	}
	// 	$criteriosEvaluacion=AsignacionCriterioEvaluacion::obtenerObjeto()->listarAsignacionCriterioEvaluacionPorModeloRubrica($modeloRubrica["idModeloRubrica"]);
	// 	foreach ($criteriosEvaluacion as &$criterioEvaluacion) {
	// 			$ce = CriterioEvaluacion::obtenerObjeto()->listarCriterioEvaluacionPorId($criterioEvaluacion['idCriterioEvaluacion']);
	// 			$criterioEvaluacion["descripcionCriterioEvaluacion"]=$ce["descripcionCriterioEvaluacion"];
	// 			$criterioEvaluacion["resultadoAprendizaje"] = $ce["tituloResultadoAprendizaje"];
	// 			unset($criterioEvaluacion['idCriterioEvaluacion']);
	// 	}
	// 	$resultadoRubrica = 
	// 			array("idResultadoRubrica"=>$idResultadoRubrica,
	// 				"semestre"=>$semestre['Semestre'],
	// 				"curso"=>$curso['DesCurso'],
	// 				"docenteCreadorRubrica"=>Persona::obtenerObjeto()->obtenerNombreCompletoPersona($docente),
	// 				"ciclo"=>$curso['CicloCurso'],
	// 				"alumnosCalificados"=>$alumnosCalificados,
	// 				"criteriosEvaluacion"=>$criteriosEvaluacion					
	// 				); 
	// 	$resultadoJson = $this->conexionSqlServer->convertirJson($resultadoRubrica);
	// 	return $resultadoJson;
	// }

	// public function completarResultadoRubrica($resultadoRubrica){
	// 	$resultadoRubrica["total"] = $this->obtenerTotalResultadoRubrica($resultadoRubrica["resultadosAprendizaje"]);
	// 	$this->conexionSqlServer->iniciarTransaccion();
	// 	$resultados = array();
	// 	$resultados[] = $this->modificarResultadoRubrica($resultadoRubrica);
	// 	$resultados[] = CalificacionCriterioEvaluacion::obtenerObjeto()->agregarCalificacionCriterioEvaluacion($resultadoRubrica["idResultadoRubrica"],$resultadoRubrica["resultadosAprendizaje"]);
	// 	echo var_dump($resultados);
	// 	return $this->conexionSqlServer->finalizarTransaccion($resultados);
	// }

	// public function modificarResultadoRubrica($resultadoRubrica){
	// 	$query = 
	// 	"UPDATE resultadorubrica
	// 		SET
	// 		totalRubrica = '".$resultadoRubrica["total"]."'
	// 		,estadoRubrica = 'Completado'
	// 		,fechaCompletadoRubrica = '".date('Y/m/d')."'
	// 		WHERE idResultadoRubrica = '".$resultadoRubrica["idResultadoRubrica"]."'";
	// 	return $this->conexionSqlServer->realizarConsulta($query,false);
	// } 

	// public function obtenerTotalResultadoRubrica($resultadosAprendizaje){
	// 	$total = 0;
	// 	foreach ($resultadosAprendizaje as $resultadoAprendizaje) {
	// 		$totalResultadoAprendizaje = 0;
	// 		foreach($resultadoAprendizaje as $criterioEvaluacion){
	// 			$totalResultadoAprendizaje += (int)($criterioEvaluacion["calificacion"]);
	// 		}
	// 		$total += $totalResultadoAprendizaje/count($resultadoAprendizaje);
	// 	}
	// 	return $total/count($resultadosAprendizaje);
	// }
}
