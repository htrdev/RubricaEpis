<?php

header('Content-type: application/json');

require_once('../clases/Docente.php');

$json = json_decode(file_get_contents("php://input"),true);
$metodo = $json['metodo'];

$Docente = new Docente();

switch($metodo){
	case 'listarDocenteActivo' : echo $Docente->listarDocenteActivo();break;
	case 'listarCursosDocente' : echo $Docente->listarCursosDocente();break;
}