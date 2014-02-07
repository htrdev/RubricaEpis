<?php

header('Content-type: application/json');

require_once('Conexion.php');

class Usuario{

	private $conexion;

	public function __construct(){
		$this->conexion = ConexionFactory::obtenerConexion('sqlserver','192.168.1.38','sa','123cuatro');
	}

	public function listarUsuarios(){
		$usuario = $this->conexion->realizarConsulta("SELECT * FROM PERSONA");
		$resultado = $this->conexion->convertirJson($usuario);
		return $resultado;
	}

	private function buscarUsuarioPorNombreUsuario(){
		$nombreUsuario = $_POST['txtUsuario'];
		$passwordUsuario = $_POST['txtPassword'];
		$usuario = $this->conexion->realizarConsulta(
			"SELECT * FROM usuario 
				where usuario.usuario ='".$nombreUsuario."' 
					and 
					  usuario.password='".$passwordUsuario."'");
		return $usuario;
	}

	public function ingresarSistema(){
		$usuario = $this->buscarUsuarioPorNombreUsuario();
		if(empty($usuario)){
			$resultado = $this->conexion->convertirJson(array("usuario"=>"","estado"=>"false"));
		}
		else{
			session_start();
			$_SESSION['estado'] = true;
			$_SESSION['usuario'] = $usuario[0]['usuario'];
			$resultado = $this->conexion->convertirJson(array("usuario"=>$_SESSION['usuario'],"estado"=>$_SESSION['estado']));
		}
		return $resultado;
	}

	public function verificarUsuario(){
		session_start();
		if(!isset($_SESSION['estado'])){
			$resultado = $this->conexion->convertirJson(array("usuario"=>"","estado"=>"false"));
		}
		else{

			$resultado = $this->conexion->convertirJson(array("usuario"=>$_SESSION['usuario'],"estado"=>$_SESSION['estado']));
		}
		return $resultado;
	}
}

$usuario = new Usuario();
echo $usuario->listarUsuarios();

?>