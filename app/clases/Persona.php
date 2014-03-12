<?php

header('Content-type: application/json');

require_once('Conexion.php');

class Persona extends Singleton{

	private $conexion;

	public function __construct(){
		$this->conexion = ConexionFactory::obtenerConexion('sqlserver');
	}

	public function obtenerNombreCompletoPersona($persona){
		return $persona["ApepPer"]." ". $persona["ApemPer"].", ".$persona["NomPer"];
	}

	public function listarPersonaPorId($idPersona){
		$queryPersona = 
		"SELECT ApepPer
				,ApemPer 
				,NomPer  
		FROM PERSONA 
		WHERE CodPer =  '".$idPersona."'";
		$persona = $this->conexion->realizarConsulta($queryPersona,true);
		return $persona[0];
	}
}
