<?php

header('Content-type: application/json');

require_once('../clases/Curso.php');

$json = json_decode(file_get_contents("php://input"),true);
$metodo = $json['metodo'];

$Curso = new Curso();

switch($metodo){
	case 'listarCursoActivoSemestre' : echo $Curso->listarCursoActivoSemestre();break;
	case 'listarCursosDocente' : echo $Curso->listarCursosDocente();break;
}