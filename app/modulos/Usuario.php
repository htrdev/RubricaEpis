<?php

header('Content-type: application/json');

require_once('../clases/Usuario.php');

$metodo = $_POST['metodo'];
$usuario = $_POST['usuario'];

$Usuario = new Usuario();

switch($metodo){
	case 'verificarUsuario' : echo $Usuario->verificarUsuario();break;
	case 'ingresarSistema' : echo $Usuario->ingresarSistema($usuario["email"],$usuario["password"]);break;
	case 'salirSistema' : echo $Usuario->salirSistema();
}

