<?php

header('Content-type: application/json');
require_once('Conexion.php');

class ModeloRubrica{

	private $conexionMysql;
	private $conexionSqlServer;

	public function __construct(){
		$this->conexionMysql = ConexionFactory::obtenerConexion('mysql','192.168.1.35','htrdev','12345');
		$this->conexionSqlServer = ConexionFactory::obtenerConexion('sqlserver','192.168.1.38','sa','123cuatro');
	}

	public function listarRubricasPorPersona(){
		//echo $this->conexion->obtenerVariableSesion("CodPer");
		echo $this->conexionMysql->obtenerVariableSesion("CodPer");
	}

	public function listarUltimoPrimaryKey($nombreCampoID,$tabla){
		$query1="select LAST_INSERT_ID(".$nombreCampoID.") from ".$tabla;
		$resultadoQuery = $this->conexion->realizarConsulta($query1,true);
		$query2.="select LAST_INSERT_ID()";
		$resultadoQuery2 = $this->conexion->realizarConsulta($query2,true);
		return $resultadoQuery2[0]['LAST_INSERT_ID()'];
	}

	public function agregarModeloRubrica($agregarModeloRubrica){

		$queryAgregarModeloRubrica = false;
		$funcionoQueryAgregarCriteriosEvaluacion = false;

		$this->conexion->iniciarTransaccion();
		$queryInsertarModeloRubrica="insert into modelorubrica as m 
		(m.Curso_idCurso, m.Semestre_idSemestre, m.fechaInicioRubrica,m.fechaFinalRubrica,
		 m.Docente_Persona_idPersona,m.calificacionRubrica)
		values ('".$agregarModeloRubrica["Curso_idCurso"]."'
				,'".$agregarModeloRubrica["Semestre_idSemestre"]."'
				,'".$agregarModeloRubrica["fechaInicioRubrica"]."'
				,'".$agregarModeloRubrica["fechaFinalRubrica"]."'
				,'".$agregarModeloRubrica["Docente_Persona_idPersona"]."'
				,'".$agregarModeloRubrica["calificacionRubrica"]."')";

		$queryAgregarModeloRubrica= $this->conexion->realizarConsulta($query,false);

		$idModeloRubrica = $this->listarUltimoPrimaryKey('idModeloRubrica','criterioevaluacion');

		$funcionoQueryAgregarCriteriosEvaluacion=
		$this->agregarCriteriosEvaluacion($agregarModeloRubrica["criteriosEvaluacion"],$idModeloRubrica);

		$funcionoTransaccion = 
			$this->conexion->finalizarTransaccion(
				array($funcionoQueryAgregarCriteriosEvaluacion
						,$queryAgregarModeloRubrica)
				);
		
		return $funcionoTransaccion;
	}
	public function agregarCriteriosEvaluacion($agregarModeloRubrica,$idModeloRubrica){

		$funcionoQueryAgregarCriteriosEvaluacion = true;
		$objCriterioEvaluacion = new AsignacionCriterioEvaluacion();
		if(!empty($agregarModeloRubrica)){
			$funcionoQueryAgregarCriteriosEvaluacion = $objCriterioEvaluacion->agregarAsignacionCriterioEvaluacion(
				$agregarModeloRubrica
				,$idModeloRubrica);
		}
		return $funcionoQueryAgregarCriteriosEvaluacion;
	}

public function listarRubricasPorPersona(){

		//$CodPer=1 deberá ser cambiado por : $this->conexion->obtenerVariableSesion("CodPer");
		//MIS RUBRICAS

		$CodPer=$this->conexionMysql->obtenerVariableSesion("CodPer");
		echo "Variable Sesion : ".$CodPer;
		session_start();
		echo var_dump($_SESSION);
		$query = "SELECT  M.Semestre_idSemestre ,M.Curso_idCurso ,M.calificacionRubrica ,M.fechaInicioRubrica ,M.fechaFinalRubrica  FROM modelorubrica AS M 
				  WHERE M.Docente_Persona_idPersona = '".$CodPer."'";
		$resultados = $this->conexionMysql->realizarConsulta($query,true);

		$misRubricas=array();
		$contadorResultado=0;
		foreach ($resultados as $resultado) {
			//semestre
			$querySemestre = "SELECT S.Semestre  FROM SEMESTRE AS S WHERE S.IdSem = '".$resultado["Semestre_idSemestre"]."'";
			$semestre = $this->conexionSqlServer->realizarConsulta($querySemestre,true);
			//curso
			$queryCurso = "SELECT  c.DesCurso  from .curso as c where c.idcurso = '".$resultado["Curso_idCurso"]."'";
			$curso = $this->conexionSqlServer->realizarConsulta($queryCurso,true);
			$misRubricas[$contadorResultado] = 
				array("semestre "=>$semestre[0]["Semestre"],
					"curso "=>$curso[0]["DesCurso"],
					"calificaA  "=>$resultado["calificacionRubrica"],
					"fechaInicio "=>$resultado["fechaInicioRubrica"],
					"fechaFinal  "=>$resultado["fechaFinalRubrica"]
					); 
			$contadorResultado++;
		}

		//MIS RUBRICAS ASIGNADAS
		$query = "SELECT  M.idModeloRubrica , M.Semestre_idSemestre ,M.Curso_idCurso ,M.calificacionRubrica ,M.Docente_Persona_idPersona ,M.fechaFinalRubrica  FROM resultadorubrica AS R 
				  INNER JOIN modelorubrica AS M ON M.idModeloRubrica = R.ModeloRubrica_idModelRubrica 
				  WHERE R.Persona_idPersona = '".$CodPer."'";

		$resultados = $this->conexionMysql->realizarConsulta($query,true);
		$misRubricasAsignadas=array();
		$contadorResultado=0;
		foreach ($resultados as $resultado) {
			//semestre
			$querySemestre = "SELECT S.Semestre  FROM SEMESTRE AS S WHERE S.IdSem = '".$resultado["Semestre_idSemestre"]."'";
			$semestre = $this->conexionSqlServer->realizarConsulta($querySemestre,true);
			//curso
			$queryCurso = "SELECT  c.DesCurso  from .curso as c where c.idcurso = '".$resultado["Curso_idCurso"]."'";
			$curso = $this->conexionSqlServer->realizarConsulta($queryCurso,true);
			//docente
			$queryDocente = "select p.ApepPer, p.ApemPer ,p.NomPer  from PERSONA as p where p.CodPer =  '".$resultado["Docente_Persona_idPersona"]."'";
			$docente = $this->conexionSqlServer->realizarConsulta($queryDocente,true);

			$misRubricasAsignadas[$contadorResultado] = 
				array("idModeloRubrica "=>$resultado["idModeloRubrica"],
					"semestre "=>$semestre[0]["Semestre"],
					"curso "=>$curso[0]["DesCurso"],
					"calificaA  "=>$resultado["calificacionRubrica"],
					"autor "=>$docente[0]["ApepPer"]." ". $docente[0]["ApemPer"].", ".$docente[0]["NomPer"],
					"fechaFinal  "=>$resultado["fechaFinalRubrica"]
					); 
			$contadorResultado++;
		}

		$misRubricas_rubricasAsignadas=array();
		$misRubricas_rubricasAsignadas=array("misRubricas "=>$misRubricas,"rubricasAsignadas "=>$misRubricasAsignadas);
		$resultadoJson = $this->conexionMysql->convertirJson($misRubricas_rubricasAsignadas);
		return $resultadoJson;
	}


}


 






