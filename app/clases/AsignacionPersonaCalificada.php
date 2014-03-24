<?php

header('Content-type: application/json');

require_once('Conexion.php');
require_once('Singleton.php');

class AsignacionPersonaCalificada extends Singleton{

	private $conexion;

	public function __construct(){
		$this->conexion = ConexionFactory::obtenerConexion('mysql');
	}
	
	public function agregarAsignacionPersonaCalificada($idResultadoRubrica,$alumnos){
		$query = 
		"INSERT INTO asignacionpersonacalificada(
			ResultadoRubrica_idResultadoRubrica, 
			idPersonaCalificada)
		values";
		$numeroElementos = count($alumnos);
		$i = 0;
		foreach($alumnos as $idAlumno){
			$query.= "('".$idResultadoRubrica."','".$idAlumno."')";
			if(++$i == $numeroElementos){
				$query.=";";
			}
			else{
				$query.=",";
			}
		}
		$funciono = $this->conexion->realizarConsulta($query,false);
		return $funciono;		
	}

	public function listarAsignacionPersonaCalificadaPorResultadoRubrica($idResultadoRubrica){
		$query =
		"SELECT A.idPersonaCalificada  
			FROM asignacionpersonacalificada AS A
				WHERE A.ResultadoRubrica_idResultadoRubrica  = '".$idResultadoRubrica."'";
		return $this->conexion->realizarConsulta($query,true);
	}
}
