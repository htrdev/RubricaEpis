<?php

header('Content-type: application/json');

require_once('../clases/Curso.php');

$metodo = $_POST['metodo'];

$Curso = new Curso();

switch($metodo){
	case 'listarCursoActivoSemestre' : echo $Curso->listarCursoActivoSemestre();break;
	case 'listarCursosDocente' : echo $Curso->listarCursosDocente();break;
}