<?php

header('Content-type: application/json');

require_once('../clases/Semestre.php');

$json = json_decode(file_get_contents("php://input"),true);
$metodo = $json['metodo'];
$resultadoAprendizaje = $json["resultadoAprendizaje"];

$semestre = new Semestre();

switch($metodo){
	case 'listarSemestre' : echo $semestre->listarSemestre();break;
	case 'listarSemestreActivo' : echo $semestre->listarSemestreActivo();break;
}

