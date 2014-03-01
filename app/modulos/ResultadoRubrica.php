<?php

header('Content-type: application/json');

require_once('../clases/ResultadoRubrica.php');

$json = json_decode(file_get_contents("php://input"),true);
$metodo = $json['metodo'];
$idModeloRubrica= $json['idModeloRubrica'];

$ResultadoRubrica = new ResultadoRubrica();

switch($metodo){

	case 'listarResultadoRubricaPorIDModeloRubrica' : echo $ResultadoRubrica->listarResultadoRubricaPorIDModeloRubrica($idModeloRubrica);break;
	case 'listarResultadoRubricaPorcionRubricaAsignada' : echo $ResultadoRubrica->listarResultadoRubricaPorcionRubricaAsignada();break;
}