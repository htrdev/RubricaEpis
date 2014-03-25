<?php

header('Content-type: application/json');

require_once('Conexion.php');
require_once('Singleton.php');

class AsignacionPersonaCalificada extends Singleton{

	private $conexionSqlServer;

	public function __construct(){
		$this->conexionSqlServer = ConexionFactory::obtenerConexion('sqlserver');
	}
	
	public function agregarAsignacionPersonaCalificada($idResultadoRubrica,$alumnos){
		$query = 
		"INSERT INTO asignacionpersonacalificada(
			idResultadoRubrica, 
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
		$funciono = $this->conexionSqlServer->realizarConsulta($query,false);
		return $funciono;		
	}

	public function listarAsignacionPersonaCalificadaPorResultadoRubrica($idResultadoRubrica){
		$query =
		"SELECT A.idPersonaCalificada  
			FROM asignacionpersonacalificada AS A
				WHERE A.idResultadoRubrica  = '".$idResultadoRubrica."'";
		return $this->conexionSqlServer->realizarConsulta($query,true);
	}
}
