<?php

error_reporting(E_ALL); ini_set('display_errors', '1');

//CARGA DE ARCHIVOS
require_once 'Bootstrap.php';
require_once rutaApp.'/app/clases/ResultadoAprendizaje.php';
require_once rutaApp.'/app/clases/CriterioEvaluacion.php';

//SE DECODIFICA EL JSON RECIBIDO
$json = json_decode(file_get_contents("php://input"),true);
$metodo = $json['metodo'];

//SE EJECUTA EL REQUEST
ejecutarMetodo($metodo);


function ejecutarMetodo($metodo){
	switch($metodo){
		case 'obtenerResultadosAprendizaje' : obtenerResultadosAprendizaje();break;
		case 'agregarResultadoAprendizajeDocente' : agregarResultadoAprendizajeDocente();break;
		// case 'agregarResultadoAprendizaje' : agregarResultadoAprendizaje();break;
		// case 'modificarResultadoAprendizaje' : $objResultadoAprendizaje->modificarResultadoAprendizaje($resultadoAprendizaje);break;
		// case 'listarResultadoAprendizajePorID': echo $objResultadoAprendizaje->listarResultadoAprendizajePorID($resultadoAprendizaje);break;
		// }
	}
}

function obtenerResultadosAprendizaje(){
	$objResultadoAprendizaje = ResultadoAprendizaje::obtenerObjeto();
	try{
		header('Content-type: application/json');
		$resultado = $objResultadoAprendizaje->obtenerResultadosAprendizaje();
		echo json_encode($resultado);
	}catch(Exception $ex){
		header("HTTP/1.1 500 Internal Server Error");
		$error["error"] = "No se ha podido listar los Resultado de Aprendizaje :(";
		$error["detalle"] = $ex->getMessage();
		echo json_encode($error);
	}
}

function agregarResultadoAprendizajeDocente(){
	global $json;
	$resultadoAprendizaje = $json["resultadoAprendizaje"];
	$objResultadoAprendizajeDocente = ResultadoAprendizajeDocente::obtenerObjeto();
	try{
		header('Content-type: application/json');
		$objResultadoAprendizajeDocente->agregarResultadoAprendizajeDocente($resultadoAprendizaje);
		echo json_encode("Resultado Aprendizaje Guardado! :)");
	}catch(PDOException $ex){
		header("HTTP/1.1 500 Internal Server Error");
		$error["error"] = "No se ha podido agregar el Resultado de Aprendizaje :(";
		$error["detalle"] = $ex->getMessage();
		echo json_encode($error);
	}
}

?>