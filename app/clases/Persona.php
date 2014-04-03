<?php

class Persona extends Master{
	//QUERYS

	public function queryListarAlumnosRegularesPorCurso($idCurso){
		$query = 
		"SELECT  
			ApepPer
			,ApemPer
			,NomPer
			,PERSONA.CodPer 
		FROM PERSONA
			INNER JOIN carga
				ON carga.CodPer = PERSONA.CodPer AND PERSONA.CodEstamento = 10
			INNER JOIN Semestre
				ON Semestre.idsem = carga.idsem	AND Semestre.Activo = 1
			INNER JOIN Curso
				ON carga.idcurso = Curso.idcurso AND carga.idcurso = '".$idCurso."'";
		return $query;
	}

	public function queryListarDocentesActivos(){
		$query = 
		"SELECT DISTINCT 
			ApepPer
			,ApemPer
			,NomPer
			,PERSONA.CodPer 
		FROM PERSONA
			INNER JOIN carga
				ON carga.CodPer = PERSONA.CodPer AND PERSONA.CodEstamento = 1
			INNER JOIN Semestre
				ON Semestre.idsem = carga.idsem	AND Semestre.Activo = 1";
		return $query;
	}

	public function queryListarPersonaPorId($idPersona){
		$query = 
		"SELECT ApepPer
				,ApemPer 
				,NomPer  
		FROM PERSONA 
		WHERE CodPer =  '".$idPersona."'";
		return $query;
	}

	//METODOS

	public function obtenerAlumnosPorCurso($idCurso){
		return $this->conexionSqlServer->realizarConsulta($this->queryListarAlumnosRegularesPorCurso($idCurso),true);
	}

	public function obtenerNombreCompletoPersona($persona){
		return $persona["ApepPer"]." ". $persona["ApemPer"].", ".$persona["NomPer"];
	}

	public function listarPersonaPorId($idPersona){
		$resultado = $persona = $this->conexionSqlServer->realizarConsulta($this->queryListarPersonaPorId($idPersona),true);
		return $resultado[0];
	}

	public function listarDocentesActivos(){
		return $this->conexionSqlServer->realizarConsulta($this->queryListarDocentesActivos(),true);
	}
}
