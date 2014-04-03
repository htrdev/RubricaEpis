<?php

require_once('../clases/ResultadoRubrica.php');

$json = json_decode(file_get_contents("php://input"),true);
$metodo = $json['metodo'];

$objResultadoRubrica = ResultadoRubrica::obtenerObjeto();


switch($metodo){
	case 'obtenerResultadoRubricaPorID' : 
		$idResultadoRubrica= $json['idResultadoRubrica'];
		echo $objResultadoRubrica->obtenerResultadoRubricaPorID($idResultadoRubrica);break;

	case 'listarResultadoRubricaPorIDModeloRubrica' : 
		$idModeloRubrica = $json['idModeloRubrica'];
		echo $objResultadoRubrica->listarResultadoRubricaPorIDModeloRubrica($idModeloRubrica);break;
	case 'listarResultadoRubricaPorcionRubricaAsignada' : obtenerResultadoRubricaPorRubricaAsignada();break;
	case 'completarResultadoRubrica' : 
		$resultadoRubrica = $json['resultadoRubrica'];
		echo $objResultadoRubrica->completarResultadoRubrica($resultadoRubrica);break;
}

