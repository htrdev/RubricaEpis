<?php

header('Content-type: application/json');

require_once('../clases/ResultadoRubrica.php');

$json = json_decode(file_get_contents("php://input"),true);
$metodo = $json['metodo'];
$idModeloRubrica= $json['idModeloRubrica'];

$resultadoRubrica = ResultadoRubrica::obtenerObjeto();


switch($metodo){

	case 'listarResultadoRubricaPorIDModeloRubrica' : echo $resultadoRubrica->listarResultadoRubricaPorIDModeloRubrica($idModeloRubrica);break;
	case 'listarResultadoRubricaPorcionRubricaAsignada' : echo $resultadoRubrica->listarResultadoRubricaPorcionRubricaAsignada($idModeloRubrica);break;
}