<?php
require_once('../clases/ModeloRubrica.php');
require_once('../clases/Persona.php');

$json = json_decode(file_get_contents("php://input"),true);
$metodo = $json['metodo'];
$objRubrica = ModeloRubrica::obtenerObjeto();

switch($metodo){
	case 'obtenerInformacionNuevaRubrica' : echo $objRubrica->obtenerInformacionNuevaRubrica();break;
	case 'obtenerRubricasPorPersona' : echo $objRubrica->obtenerRubricasPorPersona();break;
	case 'agregarModeloRubrica' : 
		$modeloRubrica = $json['modelorubrica'];
		echo $objRubrica->agregarModeloRubricaYAsignarCriterios($modeloRubrica);break;
	case 'obtenerAlumnosPorCurso' : 
		$idCurso = $json['idCurso'];
		echo Persona::obtenerObjeto()->obtenerAlumnosPorCurso($idCurso);
}

//Metodos