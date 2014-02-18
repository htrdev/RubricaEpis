<?php

header('Content-type: application/json');

require_once('../clases/CriterioEvaluacion.php');

$json = json_decode(file_get_contents("php://input"),true);
$metodo = $json['metodo'];

$CriterioEvaluacion = new CriterioEvaluacion();

switch($metodo){
	case 'agregarCriterioEvaluacion' : echo $CriterioEvaluacion->agregarCriterioEvaluacion();break;
	
}