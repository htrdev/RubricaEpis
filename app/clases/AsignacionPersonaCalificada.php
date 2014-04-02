<?php

class AsignacionPersonaCalificada extends Master{

	//QUERYS

	public function queryAgregarAsignacionPersonaCalificada($idResultadoRubrica,$idAlumno){
		$query = 
		"INSERT INTO asignacionpersonacalificada(
			idResultadoRubrica, 
			idPersonaCalificada)
		VALUES(
			'".$idResultadoRubrica."'
			,'".$idAlumno."');";
		return $query;
	}

	public function queryListarAsignacionPersonaCalificadaPorResultadoRubrica($idResultadoRubrica){
		$query =
		"SELECT A.idPersonaCalificada  
			FROM asignacionpersonacalificada AS A
				WHERE A.idResultadoRubrica  = '".$idResultadoRubrica."'";
		return $query;
	}

	//METODOS

	public function agregarAsignacionPersonaCalificada($idResultadoRubrica,$alumnos){
		$queryMultiple="";
		foreach($alumnos as $idAlumno){
			$queryMultiple.=$this->queryAgregarAsignacionPersonaCalificada($idResultadoRubrica,$idAlumno);
		}
		$this->conexionSqlServer->realizarConsulta($queryMultiple,false);
	}

	public function listarAsignacionPersonaCalificadaPorResultadoRubrica($idResultadoRubrica){
		return $this->conexionSqlServer->realizarConsulta($this->queryListarAsignacionPersonaCalificadaPorResultadoRubrica($idResultadoRubrica),true);
	}
}
