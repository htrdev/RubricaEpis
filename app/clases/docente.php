<?php

header('Content-type: application/json');

require_once('Conexion.php');

class Docente{

	private $conexion;

	public function __construct(){
		$this->conexion = ConexionFactory::obtenerConexion('sqlserver','192.168.1.38','sa','123cuatro');
	}

	public function listarDocenteActivo(){

		
		$query = "select  p.NomPer, p.ApepPer, p.ApemPer, s.Semestre from carga as c
		inner join PERSONA as p on p.CodPer = c.codper
		inner join curso as cu on cu.idcurso = c.idcurso
		inner join SEMESTRE as s on s.IdSem = c.idsem where p.CodEstamento =1 and s.Activo='1'";
		$resultado = $this->conexion->realizarConsulta($query);
		$resultadoJson = $this->conexion->convertirJson($resultado);
		return $resultadoJson;
	}

	public function listarCursosDocente(){

		$docente = $_POST['txtDocente'];
		$query = "select  cu.DesCurso, p.NomPer, p.ApepPer, p.ApemPer from carga as c
		inner join PERSONA as p on p.CodPer = c.codper
		inner join curso as cu on cu.idcurso = c.idcurso
		inner join SEMESTRE as s on s.IdSem = c.idsem where p.NomPer='".$docente."' and s.Activo=1";
		$resultado = $this->conexion->realizarConsulta($query);
		$resultadoJson = $this->conexion->convertirJson($resultado);
		return $resultadoJson;
	}


}

