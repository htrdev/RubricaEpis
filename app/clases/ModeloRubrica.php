<?php

header('Content-type: application/json');

require_once('Conexion.php');

class ModeloRubrica{

	private $conexion;

	public function __construct(){
		$this->conexion = ConexionFactory::obtenerConexion('mysql');
	}

	public function agregarModeloRubrica(){

	}

	public function listarModeloRubricaPorDocente(){

		$query = "SELECT * FROM modelorubrica";
		$resultado = $this->conexion->realizarConsulta($query);
		$a = array('modelos'=>$resultado);

		$resultadoJson = $this->conexion->convertirJson($a);
		return $resultadoJson;
	}

}

$objetoModeloRubrica = new ModeloRubrica();
echo $objetoModeloRubrica->listarModeloRubricaPorDocente();