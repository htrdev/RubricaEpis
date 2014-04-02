<?php

// error_reporting(E_ALL); ini_set('display_errors', '1');

//CARGA DE ARCHIVOS
require_once 'Bootstrap.php';
require_once rutaApp.'/app/clases/Semestre.php';
require_once rutaApp.'/app/clases/ModeloRubrica.php';
require_once rutaApp.'/app/clases/ResultadoRubrica.php';
require_once rutaApp.'/app/clases/Persona.php';
require_once rutaApp.'/app/clases/AsignacionCriterioEvaluacion.php';
require_once rutaApp.'/app/clases/AsignacionPersonaCalificada.php';
require_once rutaApp.'/app/clases/CalificacionCriterioEvaluacion.php';
require_once rutaApp.'/app/clases/CriterioEvaluacion.php';
require_once rutaApp.'/app/clases/Curso.php';
require_once rutaApp.'/app/clases/ResultadoAprendizaje.php';


//SE DECODIFICA EL JSON RECIBIDO
$json = json_decode(file_get_contents("php://input"),true);
$metodo = $json['metodo'];

switch($metodo){
	case 'obtenerInformacionNuevaRubrica' : obtenerInformacionNuevaRubrica();break;
	case 'obtenerRubricasPorPersona' : obtenerRubricasPorPersona();break;
	case 'agregarModeloRubrica' : agregarModeloRubrica();break;
	case 'obtenerAlumnosPorCurso' : obtenerAlumnosPorCurso();break;
	case 'obtenerResultadoRubricaPorRubricaAsignada' : obtenerResultadoRubricaPorRubricaAsignada();break;
	// case 'obtenerResultadoRubricaPorID' : 
	// 	$idResultadoRubrica= $json['idResultadoRubrica'];
	// 	echo $objResultadoRubrica->obtenerResultadoRubricaPorID($idResultadoRubrica);break;

	// case 'listarResultadoRubricaPorIDModeloRubrica' : 
	// 	$idModeloRubrica = $json['idModeloRubrica'];
	// 	echo $objResultadoRubrica->listarResultadoRubricaPorIDModeloRubrica($idModeloRubrica);break;
	
	// case 'completarResultadoRubrica' : 
	// 	$resultadoRubrica = $json['resultadoRubrica'];
	// 	echo $objResultadoRubrica->completarResultadoRubrica($resultadoRubrica);break;
}

//Metodos
function obtenerAlumnosPorCurso(){
	global $json;
	$idCurso = $json['idCurso'];
	$objModeloRubrica = Persona::obtenerObjeto();
	try{
		header('Content-type: application/json');
		$resultado = $objModeloRubrica->obtenerAlumnosPorCurso($idCurso);
		echo json_encode($resultado);
	}catch(Exception $ex){
		header("HTTP/1.1 500 Internal Server Error");
		$error["error"] = "No se ha podido obtener la informacion de los Alumnos :(";
		$ex = definirExcepcion($ex);
		$error["detalle"] = $ex->getMessage();
		echo json_encode($error);
	}
}

function obtenerInformacionNuevaRubrica(){
	$objModeloRubrica = ModeloRubrica::obtenerObjeto();
	try{
		header('Content-type: application/json');
		$resultado = $objModeloRubrica->obtenerInformacionNuevaRubrica();
		echo json_encode($resultado);
	}catch(Exception $ex){
		header("HTTP/1.1 500 Internal Server Error");
		$error["error"] = "No se ha podido obtener la informacion necesaria para crear una Rubrica :(";
		$ex = definirExcepcion($ex);
		$error["detalle"] = $ex->getMessage();
		echo json_encode($error);
	}
}

function obtenerRubricasPorPersona(){
	global $json;
	$objModeloRubrica = ModeloRubrica::obtenerObjeto();
	try{
		header('Content-type: application/json');
		$semestreSeleccionado = $json["semestreSeleccionado"];
		if(is_null($semestreSeleccionado)){
			$resultado = $objModeloRubrica->obtenerRubricasPorPersona();
		}else{
			$resultado = $objModeloRubrica->obtenerRubricasPorPersona($semestreSeleccionado["idSem"]);
		}
		echo json_encode($resultado);
	}catch(Exception $ex){
		header("HTTP/1.1 500 Internal Server Error");
		$error["error"] = "No se ha podido obtener las Rubricas :(";
		$ex = definirExcepcion($ex);
		$error["detalle"] = $ex->getMessage();
		echo json_encode($error);
	}
}

function agregarModeloRubrica(){
	global $json;
	$objModeloRubrica = ModeloRubrica::obtenerObjeto();
	try{
		header('Content-type: application/json');
		$modeloRubrica = $json["modelorubrica"];
		$objModeloRubrica->agregarModeloRubrica($modeloRubrica);
		echo json_encode($resultado);
	}catch(Exception $ex){
		header("HTTP/1.1 500 Internal Server Error");
		$error["error"] = "No se ha podido obtener las Rubricas :(";
		$ex = definirExcepcion($ex);
		$error["detalle"] = $ex->getMessage();
		echo json_encode($error);
	}
}

function obtenerResultadoRubricaPorRubricaAsignada(){
	global $json;
	$idModeloRubrica = $json['idModeloRubrica'];
	$objResultadoRubrica = ResultadoRubrica::obtenerObjeto();
	try{
		header('Content-type: application/json');
		$resultado = $objResultadoRubrica->obtenerResultadoRubricaPorRubricaAsignada($idModeloRubrica);
		echo json_encode($resultado);
	}catch(Exception $ex){
		header("HTTP/1.1 500 Internal Server Error");
		$error["error"] = "No se ha podido obtener la informacion de los Alumnos :(";
		$ex = definirExcepcion($ex);
		$error["detalle"] = $ex->getMessage();
		echo json_encode($error);
	}
}