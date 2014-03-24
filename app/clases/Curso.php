<?php

header('Content-type: application/json');

require_once('Conexion.php');

class Curso extends Singleton{

	private $conexion;

	public function __construct(){
		$this->conexion = ConexionFactory::obtenerConexion('sqlserver','192.168.1.38','sa','123cuatro');
	}

	public function listarCursosDocente(){
		$idDocente = $this->conexion->obtenerVariableSesion('CodPer');
		$query = "select  cu.idcurso,cu.DesCurso, cu.CodCurso,cu.CicloCurso from carga as c
		inner join PERSONA as p on p.CodPer = c.codper
		inner join curso as cu on cu.idcurso = c.idcurso
		inner join SEMESTRE as s on s.IdSem = c.idsem where p.CodPer='".$idDocente."' and s.Activo=1";
		$resultado = $this->conexion->realizarConsulta($query,true);
		return $resultado;
	}

	public function listarCursoPorId($idCurso){
		$queryCurso = 
		"SELECT  
			DesCurso
			,CicloCurso 
		FROM curso 
		WHERE idcurso = '".$idCurso."'";
		$curso = $this->conexion->realizarConsulta($queryCurso,true);
		return $curso[0];
	}
}

