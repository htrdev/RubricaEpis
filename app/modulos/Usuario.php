<?php

require_once('../clases/Usuario.php');

$json = json_decode(file_get_contents("php://input"),true);
$metodo = $json['metodo'];
$usuario = $json["usuario"];

$Usuario = new Usuario();

switch($metodo){
	case 'verificarUsuario' : echo $Usuario->verificarUsuario();break;
	case 'ingresarSistema' : echo $Usuario->ingresarSistema($usuario["dni"],$usuario["password"]);break;
	case 'salirSistema' : echo $Usuario->salirSistema();
}

