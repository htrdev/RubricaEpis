<?php

header('Content-type: application/json');

require_once('Conexion.php');

class Curso{

	private $conexion;

	public function __construct(){
		$this->conexion = ConexionFactory::obtenerConexion('sqlserver','192.168.1.38','sa','123cuatro');
	}

	public function listarCursoActivoSemestre(){

		
		$query = "select  cu.DesCurso, s.Semestre from carga as c
		inner join PERSONA as p on p.CodPer = c.codper
		inner join curso as cu on cu.idcurso = c.idcurso
		inner join SEMESTRE as s on s.IdSem = c.idsem where s.Activo='1'";
		$resultado = $this->conexion->realizarConsulta($query);
		$resultadoJson = $this->conexion->convertirJson($resultado);
		return $resultadoJson;
	}

	public function listarCursosDocente(){

		$docente = $_GET['txtDocente'];
		$query = "select  cu.idcurso,cu.DesCurso, p.NomPer, p.ApepPer, p.ApemPer,cu.CicloCurso from carga as c
		inner join PERSONA as p on p.CodPer = c.codper
		inner join curso as cu on cu.idcurso = c.idcurso
		inner join SEMESTRE as s on s.IdSem = c.idsem where p.CodPer='".$docente."' and s.Activo=1";
		$resultado = $this->conexion->realizarConsulta($query);
		$resultadoJson = $this->conexion->convertirJson($resultado);
		return $resultadoJson;
	}

	public function agregarCurso(){
	}
	public function modificarCurso(){
	}
}

