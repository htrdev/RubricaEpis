<?php

header('Content-type: application/json');

require_once('Conexion.php');

class Alumno{

	private $conexion;

	public function __construct(){
		$this->conexion = ConexionFactory::obtenerConexion('sqlserver','192.168.1.38','sa','123cuatro');
	}

	public function listarAlumnoPorCursoSemestre(){

		$semestre = $_POST['txtSemestre'];
		$curso = $_POST['txtCurso'];
		$query = "select cu.DesCurso, p.NomPer, s.Semestre from carga as c
		inner join PERSONA as p on p.CodPer = c.codper
		inner join curso as cu on cu.idcurso = c.idcurso
		inner join SEMESTRE as s on s.IdSem = c.idsem 
		where c.idsem ='".$semestre."' and c.idcurso ='".$curso."' and p.CodEstamento=10";
		$resultado = $this->conexion->realizarConsulta($query);
		$resultadoJson = $this->conexion->convertirJson($resultado);
		return $resultadoJson;
	}

}

$objetoRA = new Alumno();
echo $objetoRA->listarAlumnoPorCursoSemestre();
