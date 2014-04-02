<?php

// error_reporting(E_ALL); ini_set('display_errors', '1');
// 
require_once('../clases/ResultadoAprendizaje.php');

$json = json_decode(file_get_contents("php://input"),true);
$metodo = $json['metodo'];

switch($metodo){
	case 'obtenerResultadosAprendizaje' : obtenerResultadosAprendizaje();break;
	case 'agregarResultadoAprendizaje' : agregarResultadoAprendizaje();break;
	case 'modificarResultadoAprendizaje' : $objResultadoAprendizaje->modificarResultadoAprendizaje($resultadoAprendizaje);break;
	case 'listarResultadoAprendizajePorID': echo $objResultadoAprendizaje->listarResultadoAprendizajePorID($resultadoAprendizaje);break;
}

function obtenerResultadosAprendizaje(){
	$objResultadoAprendizaje = ResultadoAprendizaje::obtenerObjeto();
	try{
		header('Content-type: application/json');
		$resultado = $objResultadoAprendizaje->obtenerResultadosAprendizaje();
		echo json_encode($resultado);
	}catch(PDOException $ex){
		header("HTTP/1.1 500 Internal Server Error");
		$error["error"] = "No se ha podido listar los Resultado de Aprendizaje :(";
		$error["detalle"] = $ex->getMessage();
		echo json_encode($error);
	}
}

function agregarResultadoAprendizaje(){
	$resultadoAprendizaje = $json["resultadoAprendizaje"];
	$objResultadoAprendizajeDocente = ResultadoAprendizajeDocente::obtenerObjeto();
	try{
		header('Content-type: application/json');
		$objResultadoAprendizajeDocente->agregarResultadoAprendizajeDocente();
		echo json_encode("Resultado Aprendizaje Guardado! :)");
	}catch(PDOException $ex){
		header("HTTP/1.1 500 Internal Server Error");
		$error["error"] = "No se ha podido agregar el Resultado de Aprendizaje :(";
		$error["detalle"] = $ex->getMessage();
		echo json_encode($error);
	}
}

?>