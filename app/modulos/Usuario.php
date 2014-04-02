<?php
error_reporting(E_ALL); ini_set('display_errors', '1');
require_once $_SERVER["DOCUMENT_ROOT"].'/app/clases/Usuario.php';

$json = json_decode(file_get_contents("php://input"),true);
$metodo = $json['metodo'];
$usuario = $json["usuario"];
$objUsuario = new Usuario();
switch($metodo){
	case 'verificarUsuario' : echo $objUsuario->verificarUsuario();break;
	case 'ingresarSistema' : echo $objUsuario->ingresarSistema($usuario["dni"],$usuario["password"]);break;
	case 'salirSistema' : echo $objUsuario->salirSistema();
}

