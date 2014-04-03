<?php
// error_reporting(E_ALL); ini_set('display_errors', '1');

//CARGA DE ARCHIVOS
require_once 'Bootstrap.php';
require_once rutaApp.'/app/clases/Usuario.php';
require_once rutaApp.'/app/clases/Persona.php';

$json = json_decode(file_get_contents("php://input"),true);
$metodo = $json['metodo'];
$usuario = $json["usuario"];
$objUsuario = Usuario::obtenerObjeto();
switch($metodo){
	case 'verificarUsuario' : echo $objUsuario->verificarUsuario();break;
	case 'ingresarSistema' : echo $objUsuario->ingresarSistema($usuario["dni"],$usuario["password"]);break;
	case 'salirSistema' : echo $objUsuario->salirSistema();
}

