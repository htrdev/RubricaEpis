<?php

header('Content-type: application/json');

require_once('../clases/CriterioEvaluacion.php');

$metodo = $_POST['metodo'];

$CriterioEvaluacion = new CriterioEvaluacion();

switch($metodo){
	case 'agregarCriterioEvaluacion' : echo $CriterioEvaluacion->agregarCriterioEvaluacion();break;
	
}