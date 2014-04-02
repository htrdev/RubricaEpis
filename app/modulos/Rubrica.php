<?php
error_reporting(E_ALL); ini_set('display_errors', '1');
require_once('../clases/ModeloRubrica.php');
require_once('../clases/Persona.php');

$json = json_decode(file_get_contents("php://input"),true);
$metodo = $json['metodo'];
$objRubrica = ModeloRubrica::obtenerObjeto();

switch($metodo){
	case 'obtenerInformacionNuevaRubrica' : echo $objRubrica->obtenerInformacionNuevaRubrica();break;
	case 'obtenerRubricasPorPersona' : 
		if(is_null($json["semestreSeleccionado"])){
			echo $objRubrica->obtenerRubricasPorPersona();
		}else{
			echo $objRubrica->obtenerRubricasPorPersona($json["semestreSeleccionado"]["idSem"]);
		};break;
	case 'agregarModeloRubrica' : 
		$modeloRubrica = $json['modelorubrica'];
		echo $objRubrica->agregarModeloRubricaYAsignarCriterios($modeloRubrica);break;
	case 'obtenerAlumnosPorCurso' : 
		$idCurso = $json['idCurso'];
		echo Persona::obtenerObjeto()->obtenerAlumnosPorCurso($idCurso);
}

//Metodos