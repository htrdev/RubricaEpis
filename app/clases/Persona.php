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

	public function listarDocentesActivos(){
		$query = 
		"SELECT DISTINCT 
			ApepPer
			,ApemPer
			,NomPer 
		FROM PERSONA
			INNER JOIN carga
				ON carga.CodPer = PERSONA.CodPer AND PERSONA.CodEstamento = 1
			INNER JOIN Semestre
				ON Semestre.idsem = carga.idsem	AND Semestre.Activo = 1";
		return $this->conexion->realizarConsulta($query,true);
	}
}
