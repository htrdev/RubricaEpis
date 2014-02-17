<?php

header('Content-type: application/json');

require_once('Conexion.php');

class ResultadoAprendizaje{

	private $conexion;

	public function __construct(){
		$this->conexion = ConexionFactory::obtenerConexion('mysql','localhost','htrdev','12345');
	}

	public function listarCriterioAprendizaje($idResultadoAprendizaje){
		$query = "SELECT  c.idCriterioEvaluacion,c.descripcionCriterioEvaluacion,c.ResultadoAprendizaje_idResultadoAprendizaje 
					FROM criterioevaluacion as c WHERE c.ResultadoAprendizaje_idResultadoAprendizaje = '".$idResultadoAprendizaje."'";
		return $this->conexion->realizarConsulta($query,true);
	}

	public function listarResultadoAprendizaje(){

		$query = "SELECT  r.idResultadoAprendizaje, r.codigoResultadoAprendizaje , r.tituloResultadoAprendizaje  FROM resultadoaprendizaje as r";
		$resultadosAprendizaje = $this->conexion->realizarConsulta($query,true);
		$resultado = array();
		$contadorResultado = 0;
		foreach($resultadosAprendizaje as $resultadoAprendizaje){
			$idResultadoAprendizaje = $resultadoAprendizaje["idResultadoAprendizaje"];
			$criteriosAprendizaje = $this->listarCriterioAprendizaje($idResultadoAprendizaje);
			$resultado[$contadorResultado] = 
				array("tituloResultadoAprendizaje"=>$resultadoAprendizaje["tituloResultadoAprendizaje"],
					"codigoResultadoAprendizaje"=>$resultadoAprendizaje["codigoResultadoAprendizaje"],
					"criteriosEvaluacion"=>$criteriosAprendizaje); 
			$contadorResultado++;
		}
		$resultadoJson = $this->conexion->convertirJson($resultado);
		return $resultadoJson;
	}

	public function agregarResultadoAprendizaje($resultadoAprendizaje){
		$codigo = $resultadoaprendizaje['codigoResultadoAprendizaje'];
		$titulo = $tituloresultadoaprendizaje['tituloResultadoAprendizaje'];
		$definicion = $definicionresultadoaprendizaje['definicionResultadoAprendizaje'];

		$query1="INSERT INTO ResultadoAprendizaje(definicionResultadoAprendizaje, tituloResultadoAprendizaje, codigoResultadoAprendizaje)
		VALUES('".$resultadoAprendizaje["definicionResultadoAprendizaje"]."','".$resultadoAprendizaje["tituloResultadoAprendizaje"]."',
			'".$resultadoAprendizaje["codigoResultadoAprendizaje"]."')";

		$criteriosEvaluacion = $resultadoaprendizaje['codigoResultadoAprendizaje'];
		if(!empty($criteriosEvaluacion)){

			foreach ($criteriosEvaluacion as $criterioevaluacion) {

				$criterioevaluacion["descripcionCriterioEvaluacion"];
				$query2="INSERT INTO criterioevaluacion(descripcionCriterioEvaluacion, ResultadoAprendizaje_idResultadoAprendizaje)
				VALUES('".$criterioevaluacion["descripcionCriterioEvaluacion"]."','".$criterioevaluacion["ResultadoAprendizaje_idResultadoAprendizaje"]."')"
			}			
			

		}




		myarray =array(array('nombre'=>'deivi'),array('nombre'=>'abc'));
		foreach(myarray as numero){
			echo numero;
		}

		



		$resultado = $this->conexion->realizarConsulta($query,false);
		$resultadoJson = $this->conexion->convertirJson($resultado);
		return $resultadoJson;
	}

	public function modificarResultadoAprendizaje($CriterioEvaluacion){

		$query = "update ResultadoAprendizaje set definicionResultadoAprendizaje='".$CriterioEvaluacion["definicionResultadoAprendizaje"]."', tituloResultadoAprendizaje='".$CriterioEvaluacion["tituloResultadoAprendizaje"]."', codigoResultadoAprendizaje='".$CriterioEvaluacion["codigoResultadoAprendizaje"]."'
		 where idResultadoAprendizaje='".$CriterioEvaluacion["idResultadoAprendizaje"]."'";
		$resultado = $this->conexion->realizarConsulta($query,false);
		$resultadoJson = $this->conexion->convertirJson($resultado);
		return $resultadoJson;	

	}
}

class ResultadoAprendizajeDocente extends ResultadoAprendizaje{
	private $conexion;

	public function __construct(){
		$this->conexion = ConexionFactory::obtenerConexion('mysql','localhost','htrdev','12345');
	}

	public function agregarResultadoAprendizajeDocente(){

	}

	public function modificarResultadoAprendizajeDocente(){
		
	}

	public function ResultadoAprendizajePorDocente(){
		$docente = $_POST['txtDocente'];
		$query = "select d.ResultadoAprendizaje_idResultadoAprendizaje, c.definicionResultadoAprendizaje, c.tituloResultadoAprendizaje from   resultadoaprendizaje as c inner join resultadoaprendizajedocente as d on d.ResultadoAprendizaje_idResultadoAprendizaje = c.idResultadoAprendizaje where d.Docente_Persona_idPersona ='".$docente."'";
		$resultado = $this->conexion->realizarConsulta($query,true);
		$resultadoJson = $this->conexion->convertirJson($resultado);
		return $resultadoJson;	
	}

}
		
		/*agregar
		$CriterioEvaluacion = array(
		"definicionResultadoAprendizaje"=>"abc",
		"tituloResultadoAprendizaje"=>"abc",
		"codigoResultadoAprendizaje"=>"1e")

		*/


		/*modificar*/
		/*$CriterioEvaluacion = array(
		"definicionResultadoAprendizaje"=>"abc",
		"tituloResultadoAprendizaje"=>"abc",
		"codigoResultadoAprendizaje"=>"1e",
		"idResultadoAprendizaje"=>"1");	
		$objetoModeloRubrica = new ResultadoAprendizaje();
		echo $objetoModeloRubrica->modificarResultadoAprendizaje($CriterioEvaluacion);*/
