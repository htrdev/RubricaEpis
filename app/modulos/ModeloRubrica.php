<?php

require_once('../clases/ModeloRubrica.php');

$json = json_decode(file_get_contents("php://input"),true);
$metodo = $json['metodo'];
$idModeloRubrica = $json["idModeloRubrica"];

// $objModeloRubrica = ModeloRubrica::obtenerObjeto();

// switch($metodo){
// 	case 'listarCalificacionesPromedioPorModeloRubrica' : echo $objModeloRubrica->listarCalificacionesPromedioPorModeloRubrica($idModeloRubrica);break;
	
// }