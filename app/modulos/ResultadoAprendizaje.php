<?php

header('Content-type: application/json');

require_once('../clases/ResultadoAprendizaje.php');

$json = json_decode(file_get_contents("php://input"),true);
$metodo = $json['metodo'];
$resultadoAprendizaje = $json["resultadoAprendizaje"];


$ResultadoAprendizaje = new ResultadoAprendizaje();

switch($metodo){
	case 'listarResultadoAprendizajePorID' : echo $ResultadoAprendizaje->listarResultadoAprendizajePorID($resultadoAprendizaje);break;
	case 'agregarResultadoAprendizaje' : $ResultadoAprendizaje->agregarResultadoAprendizaje($resultadoAprendizaje);
	case 'modificarResultadoAprendizaje' : $ResultadoAprendizaje->modificarResultadoAprendizaje($resultadoAprendizaje);
}

