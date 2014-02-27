<?php

header('Content-type: application/json');

require_once('../clases/ResultadoAprendizaje.php');

$json = json_decode(file_get_contents("php://input"),true);
$metodo = $json['metodo'];
$resultadoAprendizaje = $json["resultadoAprendizaje"];

$objResultadoAprendizaje = ResultadoAprendizaje::obtenerObjeto();

switch($metodo){
	case 'obtenerResultadosAprendizaje' : echo $objResultadoAprendizaje->obtenerResultadosAprendizaje();break;
	case 'agregarResultadoAprendizaje' : $ResultadoAprendizaje->agregarResultadoAprendizaje($resultadoAprendizaje);
	case 'modificarResultadoAprendizaje' : $ResultadoAprendizaje->modificarResultadoAprendizaje($resultadoAprendizaje);
}

