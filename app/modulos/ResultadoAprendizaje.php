<?php

// error_reporting(E_ALL); ini_set('display_errors', '1');

require_once('../clases/ResultadoAprendizaje.php');

$json = json_decode(file_get_contents("php://input"),true);
$metodo = $json['metodo'];
$resultadoAprendizaje = $json["resultadoAprendizaje"];

$objResultadoAprendizaje = ResultadoAprendizaje::obtenerObjeto();

switch($metodo){
	case 'obtenerResultadosAprendizaje' : echo $objResultadoAprendizaje->obtenerResultadosAprendizaje();break;
	case 'agregarResultadoAprendizaje' : echo $objResultadoAprendizaje->agregarResultadoAprendizaje($resultadoAprendizaje);break;
	case 'modificarResultadoAprendizaje' : $objResultadoAprendizaje->modificarResultadoAprendizaje($resultadoAprendizaje);break;
	case 'listarResultadoAprendizajePorID': echo $objResultadoAprendizaje->listarResultadoAprendizajePorID($resultadoAprendizaje);break;
}

?>