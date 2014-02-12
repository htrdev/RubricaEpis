<?php

header('Content-type: application/json');

require_once('../clases/ResultadoAprendizaje.php');

$metodo = $_POST['metodo'];

$ResultadoAprendizaje = new ResultadoAprendizaje();

switch($metodo){
	case 'listarResultadoAprendizaje' : echo $ResultadoAprendizaje->listarResultadoAprendizaje();break;
}



