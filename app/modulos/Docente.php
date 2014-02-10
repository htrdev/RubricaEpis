<?php

header('Content-type: application/json');

require_once('../clases/Docente.php');

$metodo = $_POST['metodo'];

$Docente = new Docente();

switch($metodo){
	case 'listarDocenteActivo' : echo $Docente->listarDocenteActivo();break;
	case 'listarCursosDocente' : echo $Docente->listarCursosDocente();break;
}