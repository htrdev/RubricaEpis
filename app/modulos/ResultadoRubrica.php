<?php

header('Content-type: application/json');

require_once('../clases/ResultadoRubrica.php');

$json = json_decode(file_get_contents("php://input"),true);
$metodo = $json['metodo'];
$idModeloRubrica= $json['idModeloRubrica'];
$idResultadoRubrica= $json['idResultadoRubrica'];

$resultadoRubrica = ResultadoRubrica::obtenerObjeto();


switch($metodo){
	case 'resultadoRubricaPorID' : echo $resultadoRubrica->resultadoRubricaPorID($idResultadoRubrica);break;

	case 'listarResultadoRubricaPorIDModeloRubrica' : 
		$idModeloRubrica = $json['idModeloRubrica'];
		echo $resultadoRubrica->listarResultadoRubricaPorIDModeloRubrica($idModeloRubrica);break;
	case 'listarResultadoRubricaPorcionRubricaAsignada' : 
		$idModeloRubrica = $json['idModeloRubrica'];
		echo $resultadoRubrica->listarResultadoRubricaPorcionRubricaAsignada($idModeloRubrica);break;
}