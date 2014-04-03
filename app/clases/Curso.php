<?php

class Curso extends Master{

	// QUERYS

	public function queryListarCursosDocente(){
		$idDocente = $this->conexionSqlServer->obtenerVariableSesion('CodPer');
		$query =
		"SELECT  cu.idcurso,cu.DesCurso, cu.CodCurso,cu.CicloCurso FROM carga AS c
		INNER JOIN PERSONA AS p ON p.CodPer = c.codper
		INNER JOIN curso AS cu ON cu.idcurso = c.idcurso
		INNER JOIN SEMESTRE AS s ON s.IdSem = c.idsem WHERE p.CodPer='".$idDocente."' and s.Activo=1";
		return $query;
	}

	//METODOS

	public function listarCursosDocente(){
		$resultado = $this->conexionSqlServer->realizarConsulta($this->queryListarCursosDocente(),true);
		return $resultado;
	}

	public function listarCursoPorId($idCurso){
		$queryCurso = 
		"SELECT  
			DesCurso
			,CicloCurso 
		FROM curso 
		WHERE idcurso = '".$idCurso."'";
		$curso = $this->conexionSqlServer->realizarConsulta($queryCurso,true);
		return $curso[0];
	}
}

