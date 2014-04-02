<?php

class Usuario extends Master{

	public function listarUsuarios(){
		$usuario = $this->conexion->realizarConsulta("SELECT * FROM PERSONA");
		$resultado = $this->conexion->convertirJson($usuario);
		return $resultado;
	}

	private function buscarUsuarioPorDni($dniUsuario){
		$query = 
		"SELECT 
				PERSONA.CodPer
				,PERSONA.NomPer
				,PERSONA.ApepPer
				,PERSONA.Dni 
			FROM PERSONA 
				WHERE PERSONA.Dni ='".$dniUsuario."'";
		$persona = $this->conexionSqlServer->realizarConsulta($query,true);
		$persona[0]["nombreCompleto"]=$persona[0]["NomPer"].' '.$persona[0]["ApepPer"];
		return $persona[0];
	}

	public function ingresarSistema($dniUsuario,$passwordUsuario){
		$usuario = $this->buscarUsuarioPorDni($dniUsuario);
		$autenticado = $this->verificarDatosUsuario($dniUsuario,$passwordUsuario,$usuario);
		if(!$autenticado){
			$resultado = $this->conexionSqlServer->convertirJson(array("usuario"=>"","estado"=>false));
		}
		else{
			session_start();
			$_SESSION['CodPer'] = $usuario['CodPer'];
			$_SESSION['estado'] = true;
			$_SESSION['usuario'] = $usuario['nombreCompleto'];
			$resultado = $this->conexionSqlServer->convertirJson(array("usuario"=>$_SESSION['usuario'],"estado"=>$_SESSION['estado']));
		}
		return $resultado;
	}

	private function verificarDatosUsuario($dniUsuario,$passwordUsuario,$usuario){
		if($dniUsuario == $usuario["Dni"])
		{
			return true;
		}
		return false;
	}

	public function verificarUsuario(){
		session_start();
		if(!isset($_SESSION['estado'])){
			$resultado = $this->conexionSqlServer->convertirJson(array("usuario"=>"","estado"=>false));
		}
		else{

			$resultado = $this->conexionSqlServer->convertirJson(array("usuario"=>$_SESSION['usuario'],"estado"=>$_SESSION['estado']));
		}
		return $resultado;
	}

	public function salirSistema(){
		session_start();
		session_destroy();
		return $this->verificarUsuario();
	}
}
?>