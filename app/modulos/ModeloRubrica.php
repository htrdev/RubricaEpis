<?php

header('Content-type: application/json');

require_once('../clases/ModeloRubrica.php');

$json = json_decode(file_get_contents("php://input"),true);
$metodo = $json['metodo'];
$modeloRubrica = $json['modelorubrica'];

$ModeloRubrica = new ModeloRubrica();

switch($metodo){
	case 'agregarModeloRubrica' : echo $ModeloRubrica->agregarModeloRubrica($modeloRubrica);break;
	case 'listarRubricasPorPersona' : echo $ModeloRubrica->listarRubricasPorPersona();break;
}