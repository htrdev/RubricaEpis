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
		$this->conexionMysql = ConexionFactory::obtenerConexion('mysql','localhost','htrdev','12345');
		$this->conexionMysql = ConexionFactory::obtenerConexion('mysql','localhost','htrdev','12345');
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

		$this->conexionMysql->iniciarTransaccion();

		$queryInsertarModeloRubrica="insert into modelorubrica
		(Curso_idCurso, Semestre_idSemestre, fechaInicioRubrica,fechaFinalRubrica,
		 Docente_Persona_idPersona,calificacionRubrica)
		values ('".$agregarModeloRubrica["Curso_idCurso"]."'
				,'".$agregarModeloRubrica["Semestre_idSemestre"]."'
				,'".$agregarModeloRubrica["fechaInicioRubrica"]."'
				,'".$agregarModeloRubrica["fechaFinalRubrica"]."'
				,'".$agregarModeloRubrica["Docente_Persona_idPersona"]."'
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
		$query = "SELECT  Semestre_idSemestre ,Curso_idCurso ,calificacionRubrica ,fechaInicioRubrica ,fechaFinalRubrica  FROM modelorubrica AS M 
				  WHERE Docente_Persona_idPersona = '".$CodPer."'";
		$resultados = $this->conexionMysql->realizarConsulta($query,true);

		$misRubricas=array();
		foreach ($resultados as $resultado) {
	
			$querySemestre = "SELECT S.Semestre  FROM SEMESTRE AS S WHERE S.IdSem = '".$resultado["Semestre_idSemestre"]."'";
			$semestre = $this->conexionSqlServer->realizarConsulta($querySemestre,true);

			$queryCurso = "SELECT  c.DesCurso  from .curso as c where c.idcurso = '".$resultado["Curso_idCurso"]."'";
			$curso = $this->conexionSqlServer->realizarConsulta($queryCurso,true);
			$misRubricas[] = 
				array("semestre"=>$semestre[0]["Semestre"],
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
}

