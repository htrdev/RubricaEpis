<?php

header('Content-type: application/json');
require_once('Conexion.php');

class ModeloRubrica{

	private $conexionMysql;
	private $conexionSqlServer;

	public function __construct(){
		$this->conexionMysql = ConexionFactory::obtenerConexion('mysql','192.168.1.35','htrdev','12345');
		$this->conexionSqlServer = ConexionFactory::obtenerConexion('sqlserver','192.168.1.38','sa','123cuatro');
	}

	public function listarRubricasPorPersona(){
		//echo $this->conexion->obtenerVariableSesion("CodPer");
		echo $this->conexionMysql->obtenerVariableSesion("CodPer");
	}

}

$objeto = new ModeloRubrica();
echo  $objeto->listarRubricasPorPersona();
 






