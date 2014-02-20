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
	

}

$objeto = new ModeloRubrica();
echo  $objeto->listarRubricasPorPersona();
 






