<?php

header('Content-type: application/json');

require_once('Conexion.php');
require_once('AsignacionPersonaCalificada.php');
require_once('ModeloRubrica.php');
require_once('Persona.php');
require_once('AsignacionCriterioEvaluacion.php');
require_once('Curso.php');
require_once('CriterioEvaluacion.php');
require_once('Semestre.php');
require_once('CalificacionCriterioEvaluacion.php');

class ResultadoRubrica extends Singleton{

	private $conexionSqlServer;

	public function __construct(){
		$this->conexionSqlServer = ConexionFactory::obtenerConexion('sqlserver');
	}

	public function agregarResultadoRubrica($idModeloRubrica,$idDocente){
		$query = 
				"INSERT INTO resultadoRubrica(
					fechaCompletadoRubrica
					,idPersonaCalificadora
					,idModeloRubrica
					,estadoRubrica
					,totalRubrica)
				VALUES
					('0000-00-00'
					,".$idDocente."
					,".$idModeloRubrica."
					,'Pendiente'
					,'0')";
		$idResultadoRubrica = $this->conexionSqlServer->returnId()->realizarConsulta($query,false);
		if($idResultadoRubrica!=false){
			return $idResultadoRubrica;
		}
		return $idResultadoRubrica;
	}

	public function agregarResultadoRubricaYAsignacionPersonaCalificada($idModeloRubrica,$modeloRubrica){
		foreach($modeloRubrica["docentes"] as $idDocente){
			foreach ($modeloRubrica["alumnos"] as $alumno) {
				$idResultadoRubrica = $this->agregarResultadoRubrica($idModeloRubrica,$idDocente);	
				if($idResultadoRubrica!=false){
					$funcionoAsignacionPersonaCalificada = AsignacionPersonaCalificada::obtenerObjeto()->agregarAsignacionPersonaCalificada($idResultadoRubrica,$alumno);
					if($funcionoAsignacionPersonaCalificada==false){
						return false;
					}
				}		
				else{
					echo $idResultadoRubrica;
					return false;
				}
			}
			
		}
		return true;
  	}

	public function listarResultadoRubricaPorIDModeloRubrica($idModeloRubrica){
	
		$query = "SELECT R.IDRESULTADORUBRICA ,R.FECHACOMPLETADORUBRICA, R.TOTALRUBRICA ,R.ESTADORUBRICA , R.idPersonaCalificadora 
				  FROM RESULTADORUBRICA AS R WHERE R.idModeloRubrica = '".$idModeloRubrica."'";
		$resultados = $this->conexionSqlServer->realizarConsulta($query,true);

		$respaldo=array();
		$contadorResultado=0;
		
		foreach ($resultados as $resultado) {
		
			$idPersonasEvaluadas= "SELECT a.idPersonaCalificada   from asignacionpersonacalificada as a 
								where a.idResultadoRubrica ='".$resultado["IDRESULTADORUBRICA"]."'";
			$resultadosidPersonasEvaluadas = $this->conexionSqlServer->realizarConsulta($idPersonasEvaluadas,true);
			
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

			$consultax = "SELECT P.APEPPER , P.APEMPER , P.NOMPER  FROM PERSONA AS P WHERE P.CODPER = '".$resultado["idPersonaCalificadora"]."'";
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

		$resultadoJson = $this->conexionSqlServer->convertirJson($respaldo);
		return $resultadoJson;
	}

	public function listarResultadoRubricaPorDocente($idDocente){
		$query = 
		"SELECT  M.idModeloRubrica 
				,M.idSemestre 
				,M.idCurso 
				,M.personaCalificada 
				,R.idPersonaCalificadora 
				,M.fechaFinalRubrica  
		FROM resultadorubrica as R
			INNER JOIN modelorubrica AS M 
				ON M.idModeloRubrica = R.idModeloRubrica 
				  WHERE R.idPersonaCalificadora = '".$idDocente."'";
		return $this->conexionSqlServer->realizarConsulta($query,true);
	}

	public function listarResultadoRubricaPorcionRubricaAsignada($idModeloRubrica){


		$docenteCalificador=$this->conexionSqlServer->obtenerVariableSesion("CodPer");
		$query = "SELECT R.idResultadoRubrica , R.fechaCompletadoRubrica , R.totalRubrica , R.estadoRubrica  FROM resultadorubrica AS R
				  WHERE R.idModeloRubrica = '".$idModeloRubrica."'" ." AND R.idPersonaCalificadora = '".$docenteCalificador."'";

		$resultados = $this->conexionSqlServer->realizarConsulta($query,true);
		$resultadoRubricaAsigada=array();	
		$contadorResultado=0;

		foreach ($resultados as $resultado) {
			
			$query = "SELECT A.idPersonaCalificada FROM  asignacionpersonacalificada AS A
				      WHERE A.idResultadoRubrica = '".$resultado["idResultadoRubrica"]."'";
			$queryResultadosAlumnosEvaluados = $this->conexionSqlServer->realizarConsulta($query,true);
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
		$resultadoJson = $this->conexionSqlServer->convertirJson($resultadoRubricaAsigada);
		return $resultadoJson;
	}

	public function obtenerResultadoRubricaPorID($idResultadoRubrica){
		$modeloRubrica = ModeloRubrica::obtenerObjeto()->listarModeloRubricaPorResultadoRubrica($idResultadoRubrica);
		$semestre = Semestre::obtenerObjeto()->listarSemestrePorId($modeloRubrica['idSemestre']);
		$curso = Curso::obtenerObjeto()->listarCursoPorId($modeloRubrica['idCurso']);
		$docente = Persona::obtenerObjeto()->listarPersonaPorId($modeloRubrica['Docente_Persona_idPersona']);
		$alumnosCalificados = AsignacionPersonaCalificada::obtenerObjeto()->listarAsignacionPersonaCalificadaPorResultadoRubrica($idResultadoRubrica);
		foreach ($alumnosCalificados as &$alumnoCalificado) {
				$alumno = Persona::obtenerObjeto()->listarPersonaPorId($alumnoCalificado["idPersonaCalificada"]);
				$alumnoCalificado["nombreCompletoAlumno"] = Persona::obtenerObjeto()->obtenerNombreCompletoPersona($alumno);
				unset($alumnoCalificado["idPersonaCalificada"]);
		}
		$criteriosEvaluacion=AsignacionCriterioEvaluacion::obtenerObjeto()->listarAsignacionCriterioEvaluacionPorModeloRubrica($modeloRubrica["idModeloRubrica"]);
		foreach ($criteriosEvaluacion as &$criterioEvaluacion) {
				$ce = CriterioEvaluacion::obtenerObjeto()->listarCriterioEvaluacionPorId($criterioEvaluacion['idCriterioEvaluacion']);
				$criterioEvaluacion["descripcionCriterioEvaluacion"]=$ce["descripcionCriterioEvaluacion"];
				$criterioEvaluacion["resultadoAprendizaje"] = $ce["tituloResultadoAprendizaje"];
				unset($criterioEvaluacion['idCriterioEvaluacion']);
		}
		$resultadoRubrica = 
				array("idResultadoRubrica"=>$idResultadoRubrica,
					"semestre"=>$semestre['Semestre'],
					"curso"=>$curso['DesCurso'],
					"docenteCreadorRubrica"=>Persona::obtenerObjeto()->obtenerNombreCompletoPersona($docente),
					"ciclo"=>$curso['CicloCurso'],
					"alumnosCalificados"=>$alumnosCalificados,
					"criteriosEvaluacion"=>$criteriosEvaluacion					
					); 
		$resultadoJson = $this->conexionSqlServer->convertirJson($resultadoRubrica);
		return $resultadoJson;
	}

	public function completarResultadoRubrica($resultadoRubrica){
		$resultadoRubrica["total"] = $this->obtenerTotalResultadoRubrica($resultadoRubrica["resultadosAprendizaje"]);
		$this->conexionSqlServer->iniciarTransaccion();
		$resultados = array();
		$resultados[] = $this->modificarResultadoRubrica($resultadoRubrica);
		$resultados[] = CalificacionCriterioEvaluacion::obtenerObjeto()->agregarCalificacionCriterioEvaluacion($resultadoRubrica["idResultadoRubrica"],$resultadoRubrica["resultadosAprendizaje"]);
		return $this->conexionSqlServer->finalizarTransaccion($resultados);
	}

	public function modificarResultadoRubrica($resultadoRubrica){
		$query = 
		"UPDATE resultadorubrica
			SET
			totalRubrica = '".$resultadoRubrica["total"]."'
			,estadoRubrica = 'Completado'
			,fechaCompletadoRubrica = '".date('Y/m/d')."'
			WHERE idResultadoRubrica = '".$resultadoRubrica["idResultadoRubrica"]."'";
		return $this->conexionSqlServer->realizarConsulta($query,false);
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
