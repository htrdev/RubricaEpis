<?php

header('Content-type: application/json');

require_once('../clases/ModeloRubrica.php');

$json = json_decode(file_get_contents("php://input"),true);

$metodo = $json['metodo'];


$objRubrica = ModeloRubrica::obtenerObjeto();

switch($metodo){
	case 'obtenerInformacionNuevaRubrica' : echo $objRubrica->obtenerInformacionNuevaRubrica();break;
	case 'obtenerRubricasPorPersona' : echo $objRubrica->obtenerRubricasPorPersona();break;
	case 'agregarModeloRubrica' : 
		$modeloRubrica = $json['modelorubrica'];
		$objRubrica->agregarModeloRubrica($modeloRubrica);break;
}

//Metodos