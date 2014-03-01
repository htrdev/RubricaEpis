<?php

header('Content-type: application/json');

require_once('../clases/ResultadoRubrica.php');

$json = json_decode(file_get_contents("php://input"),true);
$metodo = $json['metodo'];

$resultadoRubrica = ResultadoRubrica::obtenerObjeto();


switch($metodo){

	case 'listarResultadoRubricaPorIDModeloRubrica' : echo $ResultadoRubrica->listarResultadoRubricaPorIDModeloRubrica($idModeloRubrica);break;
	case 'listarResultadoRubricaPorcionRubricaAsignada' : 
		$idModeloRubrica= $json['idModeloRubrica'];
		echo $ResultadoRubrica->listarResultadoRubricaPorcionRubricaAsignada($idModeloRubrica);break;
	case 'listarResultadoRubricaPorIDModeloRubrica' : echo $resultadoRubrica->listarResultadoRubricaPorIDModeloRubrica($idModeloRubrica);break;
}