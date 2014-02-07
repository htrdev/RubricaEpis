<?php

header('Content-type: application/json');

require_once('../clases/ResultadoAprendizaje.php');

$metodo = $_GET['metodo'];

$semestre = new ResultadoAprendizaje();

switch($metodo){
	case 'listarResultadoAprendizaje' : echo $semestre->listarResultadoAprendizaje();break;
}