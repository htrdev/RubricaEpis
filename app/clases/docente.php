<?php

header('Content-type: application/json');

require_once('Conexion.php');
require_once('Singleton.php');

class Docente extends Singleton{

	private $conexion;

	protected function __construct(){
		$this->conexion = ConexionFactory::obtenerConexion('sqlserver');
	}

	public function listarDocenteActivo(){
		$query = "select distinct p.CodPer, p.NomPer, p.ApepPer, p.ApemPer, s.Semestre from carga as c
		inner join PERSONA as p on p.CodPer = c.codper
		inner join curso as cu on cu.idcurso = c.idcurso
		inner join SEMESTRE as s on s.IdSem = c.idsem where p.CodEstamento =1 and s.Activo='1'";
		$resultado = $this->conexion->realizarConsulta($query,true);
		return $resultado;
	}
}

