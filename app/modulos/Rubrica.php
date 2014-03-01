<?php

header('Content-type: application/json');

require_once('../clases/ModeloRubrica.php');

$json = json_decode(file_get_contents("php://input"),true);

$metodo = $json['metodo'];
$modeloRubrica = $json['modelorubrica'];
$agregarModeloRubrica = $json['agregarModeloRubrica'];


$objRubrica = ModeloRubrica::obtenerObjeto();

switch($metodo){
	case 'obtenerInformacionNuevaRubrica' : echo $objRubrica->obtenerInformacionNuevaRubrica();break;
	case 'obtenerRubricasPorPersona' : echo $objRubrica->obtenerRubricasPorPersona();break;
	case 'agregarModeloRubrica' : $objRubrica->agregarModeloRubrica($agregarModeloRubrica);
}

//Metodos