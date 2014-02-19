<?php

header('Content-type: application/json');

require_once('Conexion.php');

class Usuario{

	private $conexionsql;
	private $conexionmysql;

	public function __construct(){
		$this->conexionsql = ConexionFactory::obtenerConexion('sqlserver','192.168.1.38','sa','123cuatro');
		$this->conexionmysql = ConexionFactory::obtenerConexion('mysql','192.168.1.35','htrdev','12345');
	}

	public function listarUsuarios(){
		$usuario = $this->conexion->realizarConsulta("SELECT * FROM PERSONA");
		$resultado = $this->conexion->convertirJson($usuario);
		return $resultado;
	}

	private function buscarUsuarioPorEmail($emailUsuario){
		$persona = $this->conexionsql->realizarConsulta(
			"SELECT PERSONA.CodPer,PERSONA.NomPer,PERSONA.ApepPer,PERSONA.Email FROM PERSONA 
				where PERSONA.Email ='".$emailUsuario."'",true);
		$usuario = $this->conexionmysql->realizarConsulta(
			"SELECT usuario.passwordUsuario,usuario.tipoUsuario FROM usuario 
				where usuario.idUsuario ='".$persona[0]["CodPer"]."'"
			,true);
		$usuario[0]["CodPer"]=$persona[0]["CodPer"];
		$usuario[0]["nombreCompleto"]=$persona[0]["NomPer"].' '.$persona[0]["ApepPer"];
		$usuario[0]["Email"]=$persona[0]["Email"];
		return $usuario;
	}


	public function ingresarSistema($emailUsuario,$passwordUsuario){
		$usuario = $this->buscarUsuarioPorEmail($emailUsuario);
		$autenticado = $this->verificarDatosUsuario($emailUsuario,$passwordUsuario,$usuario);
		if(!$autenticado){
			$resultado = $this->conexionsql->convertirJson(array("usuario"=>"","estado"=>false));
		}
		else{
			session_start();
			$_SESSION['CodPer'] = $usuario[0]['CodPer'];
			$_SESSION['estado'] = true;
			$_SESSION['usuario'] = $usuario[0]['nombreCompleto'];
			$resultado = $this->conexionsql->convertirJson(array("usuario"=>$_SESSION['usuario'],"estado"=>$_SESSION['estado']));
		}
		return $resultado;
	}

	private function verificarDatosUsuario($emailUsuario,$passwordUsuario,$usuario){
		if($emailUsuario == $usuario[0]["Email"] && $passwordUsuario == $usuario[0]["passwordUsuario"])
		{
			return true;
		}
		return false;
	}

	public function verificarUsuario(){
		session_start();
		if(!isset($_SESSION['estado'])){
			$resultado = $this->conexionsql->convertirJson(array("usuario"=>"","estado"=>false));
		}
		else{

			$resultado = $this->conexionsql->convertirJson(array("usuario"=>$_SESSION['usuario'],"estado"=>$_SESSION['estado']));
		}
		return $resultado;
	}

	public function salirSistema(){
		session_start();
		session_destroy();
		$this->verificarUsuario();
	}
}
?>