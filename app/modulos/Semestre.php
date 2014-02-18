<?php

header('Content-type: application/json');

require_once('../clases/Semestre.php');

$metodo = $_POST['metodo'];

$semestre = new Semestre();

switch($metodo){
	case 'listarSemestre' : echo $semestre->listarSemestre();break;
	case 'listarSemestreActivo' : echo $semestre->listarSemestreActivo();break;
}

