<?php

header('Content-type: application/json');

require_once('Conexion.php');
require_once('CriterioEvaluacion.php');

class ResultadoAprendizaje{

	private $conexion;

	public function __construct(){
		$this->conexion = ConexionFactory::obtenerConexion('mysql','192.168.1.88','htrdev','12345');
	}

	public function listarCriterioAprendizaje($idResultadoAprendizaje){
		$query = "SELECT  c.idCriterioEvaluacion,c.descripcionCriterioEvaluacion,c.ResultadoAprendizaje_idResultadoAprendizaje 
					FROM criterioevaluacion as c WHERE c.ResultadoAprendizaje_idResultadoAprendizaje = '".$idResultadoAprendizaje."'";
		return $this->conexion->realizarConsulta($query,true);
	}

/*
	public function listarResultadoAprendizaje(){
		$query = "SELECT  r.idResultadoAprendizaje, r.codigoResultadoAprendizaje , r.tituloResultadoAprendizaje  FROM resultadoaprendizaje as r";
		$resultadosAprendizaje = $this->conexion->realizarConsulta($query,true);
		$resultado = array();
		$contadorResultado = 0;
		foreach($resultadosAprendizaje as $resultadoAprendizaje){
			$idResultadoAprendizaje = $resultadoAprendizaje["idResultadoAprendizaje"];
			$criteriosAprendizaje = $this->listarCriterioAprendizaje($idResultadoAprendizaje);
			$resultado[$contadorResultado] = 
				array("tituloResultadoAprendizaje"=>$resultadoAprendizaje["tituloResultadoAprendizaje"],
					"codigoResultadoAprendizaje"=>$resultadoAprendizaje["codigoResultadoAprendizaje"],
					"criteriosEvaluacion"=>$criteriosAprendizaje); 
			$contadorResultado++;
		}
		$resultadoJson = $this->conexion->convertirJson($resultado);
		return $resultadoJson;
	}
*/
	public function listarResultadoAprendizajePorID($listarResultadoAprendizaje){

		
		$query="select r.idResultadoAprendizaje,r.codigoResultadoAprendizaje,
		r.tituloResultadoAprendizaje,r.definicionResultadoAprendizaje from resultadoaprendizaje as r
		where r.idResultadoAprendizaje='".$idResultadoAprendizaje."'";
		$resultadoaprendizaporid = $this->conexion->realizarConsulta($query,true);
		
		
		$query2 = "select idCriterioEvaluacion, descripcionCriterioEvaluacion  from resultadoaprendizaje as r 
		inner join criterioevaluacion as c on c.ResultadoAprendizaje_idResultadoAprendizaje=r.idResultadoAprendizaje
		where r.idResultadoAprendizaje ='".$resultadoaprendizaporid[0]["idResultadoAprendizaje"]."'";
		$criteriosEvaluacion = $this->conexionSqlServer->realizarConsulta($query2,true);

		
		$resultado=
		array('idResultadoAprendizaje ' => $resultadoaprendizaporid[0]["idResultadoAprendizaje"] ,
			'codigoResultadoAprendizaje ' => $resultadoaprendizaporid[0]["codigoResultadoAprendizaje"] ,
			'tituloResultadoAprendizaje ' => $resultadoaprendizaporid[0]["tituloResultadoAprendizaje"] ,
			'definicionResultadoAprendizaje ' => $resultadoaprendizaporid[0]["definicionResultadoAprendizaje"] ,
			'criteriosEvaluacion' =>$criteriosEvaluacion);	

		$resultadoJson = $this->conexion->convertirJson($resultado);
		return $resultadoJson;	
	}



	public function listarUltimoPrimaryKey($nombreCampoID,$tabla){
		$query1="select LAST_INSERT_ID(".$nombreCampoID.") from ".$tabla;
		$resultadoQuery = $this->conexion->realizarConsulta($query1,true);
		$query2.="select LAST_INSERT_ID()";
		$resultadoQuery2 = $this->conexion->realizarConsulta($query2,true);
		return $resultadoQuery2[0]['LAST_INSERT_ID()'];
	}

	public function agregarResultadoAprendizaje($resultadoAprendizaje){

		$funcionoQueryAgregarResultadoAprendizaje = false;
		$funcionoQueryAgregarCriteriosEvaluacion = false;

		$this->conexion->iniciarTransaccion();

		$queryAgregarResultadoAprendizaje="
			INSERT INTO ResultadoAprendizaje(
				definicionResultadoAprendizaje
				,tituloResultadoAprendizaje
				,codigoResultadoAprendizaje)
			VALUES(
				'".$resultadoAprendizaje["definicionResultadoAprendizaje"]."'
				,'".$resultadoAprendizaje["tituloResultadoAprendizaje"]."'
				,'".$resultadoAprendizaje["codigoResultadoAprendizaje"]."')";

		$funcionoQueryAgregarResultadoAprendizaje = 
			$this->conexion->realizarConsulta($queryAgregarResultadoAprendizaje,false);
		
		$idResultadoAprendizaje = 
			$this->listarUltimoPrimaryKey('idResultadoAprendizaje','resultadoaprendizaje');

		$funcionoQueryAgregarCriteriosEvaluacion = 
			$this->agregarCriteriosEvaluacion($resultadoAprendizaje["criteriosEvaluacion"],$idResultadoAprendizaje);
		
		$funcionoTransaccion = 
			$this->conexion->finalizarTransaccion(
				array($funcionoQueryAgregarCriteriosEvaluacion
						,$funcionoQueryAgregarResultadoAprendizaje)
				);
		
		return $funcionoTransaccion;
	}

	public function agregarCriteriosEvaluacion($resultadoAprendizaje,$idResultadoAprendizaje){
		$funcionoQueryAgregarCriteriosEvaluacion = true;
		$objCriterioEvaluacion = new CriterioEvaluacion();
		if(!empty($resultadoAprendizaje)){
			$funcionoQueryAgregarCriteriosEvaluacion = $objCriterioEvaluacion->agregarCriterioEvaluacion(
				$resultadoAprendizaje
				,$idResultadoAprendizaje);
		}
		return $funcionoQueryAgregarCriteriosEvaluacion;
	}

	public function modificarResultadoAprendizaje($ResultadoAprendizaje){


		$resultadoModificarResultadoAprendizaje = false;
		$funcionoQueryModificarCriteriosEvaluacion = false;

		$this->conexion->iniciarTransaccion();


		$query = "update ResultadoAprendizaje set
		definicionResultadoAprendizaje='".$ResultadoAprendizaje["definicionResultadoAprendizaje"]."',
		tituloResultadoAprendizaje='".$ResultadoAprendizaje["tituloResultadoAprendizaje"]."', 
		codigoResultadoAprendizaje='".$ResultadoAprendizaje["codigoResultadoAprendizaje"]."'
		where idResultadoAprendizaje='".$ResultadoAprendizaje["idResultadoAprendizaje"]."'";
		$resultadoModificarResultadoAprendizaje = $this->conexion->realizarConsulta($query,false);



		$funcionoQueryModificarCriteriosEvaluacion = 
			$this->asignarCriteriosParaModificar($ResultadoAprendizaje["criteriosEvaluacion"],$idResultadoAprendizaje);

		$funcionoTransaccion = 
			$this->conexion->finalizarTransaccion(
				array($funcionoQueryModificarCriteriosEvaluacion
						,$resultadoModificarResultadoAprendizaje)
				);
		
		return $funcionoTransaccion;


		$resultadoModificarResultadoAprendizaje = false;
		$funcionoQueryModificarCriteriosEvaluacion = false;

		$this->conexion->iniciarTransaccion();


		$query = "update ResultadoAprendizaje set
		definicionResultadoAprendizaje='".$ResultadoAprendizaje["definicionResultadoAprendizaje"]."',
		tituloResultadoAprendizaje='".$ResultadoAprendizaje["tituloResultadoAprendizaje"]."', 
		codigoResultadoAprendizaje='".$ResultadoAprendizaje["codigoResultadoAprendizaje"]."'
		where idResultadoAprendizaje='".$ResultadoAprendizaje["idResultadoAprendizaje"]."'";
		$resultadoModificarResultadoAprendizaje = $this->conexion->realizarConsulta($query,false);

		$funcionoQueryModificarCriteriosEvaluacion = 
			$this->asignarCriteriosParaModificar($ResultadoAprendizaje["criteriosEvaluacion"],$idResultadoAprendizaje);

		$funcionoTransaccion = 
			$this->conexion->finalizarTransaccion(
				array($funcionoQueryModificarCriteriosEvaluacion
						,$resultadoModificarResultadoAprendizaje)
				);
		
		return $funcionoTransaccion;

		$resultadoJson = $this->conexion->convertirJson($resultado);
		return $resultadoJson;	
	}


	public function asignarCriteriosParaModificar($ResultadoAprendizaje, $idResultadoAprendizaje){
		$funcionoQueryModificarCriteriosEvaluacion = true;
		$objCriterioEvaluacion = new CriterioEvaluacion();
		if(!empty($ResultadoAprendizaje)){
			$funcionoQueryModificarCriteriosEvaluacion = $objCriterioEvaluacion->modificarCriterioEvaluacion(
				$ResultadoAprendizaje
				,$idResultadoAprendizaje);
		}
		return $funcionoQueryModificarCriteriosEvaluacion;



	}



	public function listarResultadoAprendizaje(){
		
		$queryListarResultadoAprendisajeCreadosPorDocentes = "SELECT R.ResultadoAprendizaje_idResultadoAprendizaje  FROM resultadoaprendizajedocente AS R";
		$resultadosListarResultadoAprendisajeCreadosPorDocentes = $this->conexion->realizarConsulta($queryListarResultadoAprendisajeCreadosPorDocentes,true);		
		
		$queryListarResultadoAprendisaje = "SELECT R.idResultadoAprendizaje FROM resultadoaprendizaje AS R
			       WHERE R.idResultadoAprendizaje";
		$resultadosListarResultadoAprendisaje = $this->conexion->realizarConsulta($queryListarResultadoAprendisaje,true);

		$resultadosAprendizaje= array();
		$contador=0;
		foreach ($resultadosListarResultadoAprendisaje as $resultado) {
			$aux=false;
			foreach ($resultadosListarResultadoAprendisajeCreadosPorDocentes as $resultadoAprendisajeDocente) {				
				if ($resultado["idResultadoAprendizaje"]==$resultadoAprendisajeDocente["ResultadoAprendizaje_idResultadoAprendizaje"]){
					$aux=true;
				}
			}
			if(!($aux)){
				
				$queryResultadoAprendisaje = "SELECT R.idResultadoAprendizaje, R.codigoResultadoAprendizaje,R.tituloResultadoAprendizaje,R.definicionResultadoAprendizaje FROM resultadoaprendizaje AS R
					  						  WHERE R.idResultadoAprendizaje ='".$resultado["idResultadoAprendizaje"]."'";
			    $resultadosResultadoAprendisaje = $this->conexion->realizarConsulta($queryResultadoAprendisaje,true);

			    //criteros
				$queryCriterios = "SELECT C.idCriterioEvaluacion ,C.descripcionCriterioEvaluacion  FROM criterioevaluacion AS C 
							   WHERE C.ResultadoAprendizaje_idResultadoAprendizaje = '".$resultadosResultadoAprendisaje[0]["idResultadoAprendizaje"]."'";
				$resultadosCriterio = $this->conexion->realizarConsulta($queryCriterios,true);

				$i=0;
				$criteriosEvaluacion=array();
				foreach ($resultadosCriterio as $criterio) {

					$criteriosEvaluacion[$i] = 
					array("idCriterioEvaluacion"=>$criterio["idCriterioEvaluacion"],
						"descripcionCriterioEvaluacion"=>$criterio["descripcionCriterioEvaluacion"]
						); 

					$i++;
				}

				$resultadosAprendizaje[$contador] = 
					array("idResultadoAprendizaje"=>$resultadosResultadoAprendisaje[0]["idResultadoAprendizaje"],
						"codigoResultadoAprendizaje"=>$resultadosResultadoAprendisaje[0]["codigoResultadoAprendizaje"],
						"tituloResultadoAprendizaje"=>$resultadosResultadoAprendisaje[0]["tituloResultadoAprendizaje"],
						"definicionResultadoAprendizaje"=>$resultadosResultadoAprendisaje[0]["definicionResultadoAprendizaje"],
						"criteriosEvaluacion"=>$criteriosEvaluacion
						); 
				$contador++;
			}	
		}


		//Resultados de Aprendizaje creadas por un Docente y sus respectivos criterios asignados
		$docente=1;
		$query = "SELECT R.ResultadoAprendizaje_idResultadoAprendizaje FROM resultadoaprendizajedocente AS R 
				  WHERE R.Docente_Persona_idPersona = '".$docente."'";
		$resultados = $this->conexion->realizarConsulta($query,true);

		$resultadosAprendisajeDocentes=array();
		$contador=0;
		foreach ($resultados as $resultado) {

			//resultado de aprendisaje
			$queryResultadoAprendisaje = "SELECT R.idResultadoAprendizaje, R.codigoResultadoAprendizaje,R.tituloResultadoAprendizaje,R.definicionResultadoAprendizaje FROM resultadoaprendizaje AS R
					  					  WHERE R.idResultadoAprendizaje ='".$resultado["ResultadoAprendizaje_idResultadoAprendizaje"]."'";
			$resultadosResultadoAprendisaje = $this->conexion->realizarConsulta($queryResultadoAprendisaje,true);

			//criteros
			$queryCriterios = "SELECT C.idCriterioEvaluacion ,C.descripcionCriterioEvaluacion  FROM criterioevaluacion AS C 
							   WHERE C.ResultadoAprendizaje_idResultadoAprendizaje = '".$resultadosResultadoAprendisaje[0]["idResultadoAprendizaje"]."'";
			$resultadosCriterio = $this->conexion->realizarConsulta($queryCriterios,true);

			$i=0;
			$criteriosEvaluacion=array();
			foreach ($resultadosCriterio as $criterio) {

				$criteriosEvaluacion[$i] = 
				array("idCriterioEvaluacion"=>$criterio["idCriterioEvaluacion"],
					"descripcionCriterioEvaluacion"=>$criterio["descripcionCriterioEvaluacion"]
					); 

				$i++;
			}

			$resultadosAprendisajeDocentes[$contador] = 
				array("idResultadoAprendizaje"=>$resultadosResultadoAprendisaje[0]["idResultadoAprendizaje"],
					"codigoResultadoAprendizaje"=>$resultadosResultadoAprendisaje[0]["codigoResultadoAprendizaje"],
					"tituloResultadoAprendizaje"=>$resultadosResultadoAprendisaje[0]["tituloResultadoAprendizaje"],
					"definicionResultadoAprendizaje"=>$resultadosResultadoAprendisaje[0]["definicionResultadoAprendizaje"],
					"criteriosEvaluacion"=>$criteriosEvaluacion
					); 

			$contador++;
		}

		$resultadosAprendizaje_resultadosAprendizajeDocente =array();
		$resultadosAprendizaje_resultadosAprendizajeDocente= array(
			"resultadosAprendizaje"=>$resultadosAprendizaje,
			"resultadosAprendizajeDocente"=>$resultadosAprendisajeDocentes);
		$resultadoJson = $this->conexion->convertirJson($resultadosAprendizaje_resultadosAprendizajeDocente);
		return $resultadoJson;
	}
	


	public function listarResultadoAprendizaje(){
		$escuela='Escuela';

		$queryListarResultadoAprendisajeCreadosPorEscuela = "SELECT R.idResultadoAprendizaje,R.codigoResultadoAprendizaje ,R.tituloResultadoAprendizaje ,R.definicionResultadoAprendizaje   FROM resultadoaprendizaje AS R 
															 WHERE R.tipoResultadoAprendizaje = '".$escuela."'";
		$resultadoListarResultadoAprendisajeCreadosPorEscuela = $this->conexion->realizarConsulta($queryListarResultadoAprendisajeCreadosPorEscuela,true);		
		
		$resultadosAprendizajeEscuela= array();
		$contador=0;
		foreach ($resultadoListarResultadoAprendisajeCreadosPorEscuela as $resultado) {
			
			    //criteros
				$queryCriterios = "SELECT C.idCriterioEvaluacion ,C.descripcionCriterioEvaluacion  FROM criterioevaluacion AS C
									WHERE C.ResultadoAprendizaje_idResultadoAprendizaje = '".$resultado["idResultadoAprendizaje"]."'";
				$resultadosCriterio = $this->conexion->realizarConsulta($queryCriterios,true);

				$resultadosAprendizajeEscuela[$contador] = 
					array("idResultadoAprendizaje"=>$resultado["idResultadoAprendizaje"],
						"codigoResultadoAprendizaje"=>$resultado["codigoResultadoAprendizaje"],
						"tituloResultadoAprendizaje"=>$resultado["tituloResultadoAprendizaje"],
						"definicionResultadoAprendizaje"=>$resultado["definicionResultadoAprendizaje"],
						"criteriosEvaluacion"=>$resultadosCriterio
						); 
				$contador++;
		
		}

		////////////

		$codPer=$this->conexion->obtenerVariableSesion("CodPer");

		$queryListarResultadoAprendisajeCreadosPorDocente = "SELECT R.ResultadoAprendizaje_idResultadoAprendizaje FROM resultadoaprendizajedocente AS R
															 WHERE R.Docente_Persona_idPersona = '".$codPer."'";
		$resultadoListarResultadoAprendisajeCreadosPorDocente = $this->conexion->realizarConsulta($queryListarResultadoAprendisajeCreadosPorDocente,true);		
		
		$resultadosAprendizajeDocente= array();
		$contador=0;
		foreach ($resultadoListarResultadoAprendisajeCreadosPorDocente as $resultado) {


				//Resultado Aprendizaje
				$queryRA = "SELECT R.idResultadoAprendizaje ,R.codigoResultadoAprendizaje ,R.tituloResultadoAprendizaje ,R.definicionResultadoAprendizaje  FROM resultadoaprendizaje AS R
							WHERE R.idResultadoAprendizaje = '".$resultado["ResultadoAprendizaje_idResultadoAprendizaje"]."'";
				$resultadosRA = $this->conexion->realizarConsulta($queryRA,true);

			    //criteros
				$queryCriterios = "SELECT C.idCriterioEvaluacion ,C.descripcionCriterioEvaluacion  FROM criterioevaluacion AS C
								   WHERE C.ResultadoAprendizaje_idResultadoAprendizaje = '".$resultadosRA[0]["idResultadoAprendizaje"]."'";
				$resultadosCriterio = $this->conexion->realizarConsulta($queryCriterios,true);

				$resultadosAprendizajeDocente[$contador] = 
					array("idResultadoAprendizaje"=>$resultadosRA[0]["idResultadoAprendizaje"],
						"codigoResultadoAprendizaje"=>$resultadosRA[0]["codigoResultadoAprendizaje"],
						"tituloResultadoAprendizaje"=>$resultadosRA[0]["tituloResultadoAprendizaje"],
						"definicionResultadoAprendizaje"=>$resultadosRA[0]["definicionResultadoAprendizaje"],
						"criteriosEvaluacion"=>$resultadosCriterio
						); 
				$contador++;
		}

		$resultadosAprendizajeEscuelaresultadosAprendizajeEscuela =  array(
							"resultadosAprendizaje"=>$resultadosAprendizajeEscuela,
							"resultadosAprendizajeDocente"=>$resultadosAprendizajeDocente);

		$resultadoJson = $this->conexion->convertirJson($resultadosAprendizajeEscuelaresultadosAprendizajeEscuela);
		return $resultadoJson;

	}


	public function listarResultadoAprendizaje(){
		$escuela='Escuela';

		$queryListarResultadoAprendisajeCreadosPorEscuela = "SELECT R.idResultadoAprendizaje,R.codigoResultadoAprendizaje ,R.tituloResultadoAprendizaje ,R.definicionResultadoAprendizaje   FROM resultadoaprendizaje AS R 
															 WHERE R.tipoResultadoAprendizaje = '".$escuela."'";
		$resultadoListarResultadoAprendisajeCreadosPorEscuela = $this->conexion->realizarConsulta($queryListarResultadoAprendisajeCreadosPorEscuela,true);		
		
		$resultadosAprendizajeEscuela= array();
		$contador=0;
		foreach ($resultadoListarResultadoAprendisajeCreadosPorEscuela as $resultado) {
			
			    //criteros
				$queryCriterios = "SELECT C.idCriterioEvaluacion ,C.descripcionCriterioEvaluacion  FROM criterioevaluacion AS C
									WHERE C.ResultadoAprendizaje_idResultadoAprendizaje = '".$resultado["idResultadoAprendizaje"]."'";
				$resultadosCriterio = $this->conexion->realizarConsulta($queryCriterios,true);

				$resultadosAprendizajeEscuela[$contador] = 
					array("idResultadoAprendizaje"=>$resultado["idResultadoAprendizaje"],
						"codigoResultadoAprendizaje"=>$resultado["codigoResultadoAprendizaje"],
						"tituloResultadoAprendizaje"=>$resultado["tituloResultadoAprendizaje"],
						"definicionResultadoAprendizaje"=>$resultado["definicionResultadoAprendizaje"],
						"criteriosEvaluacion"=>$resultadosCriterio
						); 
				$contador++;
		
		}

		////////////

		$codPer=1;//  $this->conexion->obtenerVariableSesion("CodPer");

		$queryListarResultadoAprendisajeCreadosPorDocente = "SELECT R.ResultadoAprendizaje_idResultadoAprendizaje FROM resultadoaprendizajedocente AS R
															 WHERE R.Docente_Persona_idPersona = '".$codPer."'";
		$resultadoListarResultadoAprendisajeCreadosPorDocente = $this->conexion->realizarConsulta($queryListarResultadoAprendisajeCreadosPorDocente,true);		
		
		$resultadosAprendizajeDocente= array();
		$contador=0;
		foreach ($resultadoListarResultadoAprendisajeCreadosPorDocente as $resultado) {


				//Resultado Aprendizaje
				$queryRA = "SELECT R.idResultadoAprendizaje ,R.codigoResultadoAprendizaje ,R.tituloResultadoAprendizaje ,R.definicionResultadoAprendizaje  FROM resultadoaprendizaje AS R
							WHERE R.idResultadoAprendizaje = '".$resultado["ResultadoAprendizaje_idResultadoAprendizaje"]."'";
				$resultadosRA = $this->conexion->realizarConsulta($queryRA,true);

			    //criteros
				$queryCriterios = "SELECT C.idCriterioEvaluacion ,C.descripcionCriterioEvaluacion  FROM criterioevaluacion AS C
								   WHERE C.ResultadoAprendizaje_idResultadoAprendizaje = '".$resultadosRA[0]["idResultadoAprendizaje"]."'";
				$resultadosCriterio = $this->conexion->realizarConsulta($queryCriterios,true);

				$resultadosAprendizajeDocente[$contador] = 
					array("idResultadoAprendizaje"=>$resultadosRA[0]["idResultadoAprendizaje"],
						"codigoResultadoAprendizaje"=>$resultadosRA[0]["codigoResultadoAprendizaje"],
						"tituloResultadoAprendizaje"=>$resultadosRA[0]["tituloResultadoAprendizaje"],
						"definicionResultadoAprendizaje"=>$resultadosRA[0]["definicionResultadoAprendizaje"],
						"criteriosEvaluacion"=>$resultadosCriterio
						); 
				$contador++;
		}

		$resultadosAprendizajeEscuelaresultadosAprendizajeEscuela =  array(
							"resultadosAprendizaje"=>$resultadosAprendizajeEscuela,
							"resultadosAprendizajeDocente"=>$resultadosAprendizajeDocente);

		$resultadoJson = $this->conexion->convertirJson($resultadosAprendizajeEscuelaresultadosAprendizajeEscuela);
		return $resultadoJson;

	}
	

}

class ResultadoAprendizajeDocente extends ResultadoAprendizaje{
	private $conexion;

	public function __construct(){
		$this->conexion = ConexionFactory::obtenerConexion('mysql','localhost','htrdev','12345');
	}

	public function agregarResultadoAprendizajeDocente(){

	}

	public function modificarResultadoAprendizajeDocente(){
		
	}

	public function ResultadoAprendizajePorDocente(){
		$docente = $_POST['txtDocente'];
		$query = "select d.ResultadoAprendizaje_idResultadoAprendizaje, c.definicionResultadoAprendizaje, c.tituloResultadoAprendizaje from   resultadoaprendizaje as c inner join resultadoaprendizajedocente as d on d.ResultadoAprendizaje_idResultadoAprendizaje = c.idResultadoAprendizaje where d.Docente_Persona_idPersona ='".$docente."'";
		$resultado = $this->conexion->realizarConsulta($query,true);
		$resultadoJson = $this->conexion->convertirJson($resultado);
		return $resultadoJson;	
	}

}



 


