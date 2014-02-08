<?php

header('Content-type: application/json');

require_once('Conexion.php');

class ResultadoAprendizaje{

	private $conexion;

	public function __construct(){
		$this->conexion = ConexionFactory::obtenerConexion('mysql','192.168.1.35','htrdev','12345');
	}


	public function listarResultadoAprendizaje(){

		$query1 = "SELECT  r.idResultadoAprendizaje, r.definicionResultadoAprendizaje  FROM resultadoaprendizaje as r";
		$resultado1 = $this->conexion->realizarConsulta($query1);

		$query2 = "SELECT  c.idCriterioEvaluacion,c.descripcionCriterioEvaluacion,c.ResultadoAprendizaje_idResultadoAprendizaje   FROM criterioevaluacion as c";
		$resultado2 = $this->conexion->realizarConsulta($query2);

		$f=0;
		$c=0;

		$obj1[]= "";
	

		foreach($resultado1 as $key1){

				foreach($resultado2 as $key2){
    			
    			 if($key1['idResultadoAprendizaje']==$key2['ResultadoAprendizaje_idResultadoAprendizaje'])
    			 { 			 	
    			 		$obj1[$f++]= $key2['descripcionCriterioEvaluacion'];
    			 		//$obj2[$c]= $key1['definicionResultadoAprendizaje'];	
    			 } 
    			 else
    			 {
 			 	
    			 }

    			 /*

    			 if($key1['idResultadoAprendizaje']==$key2['ResultadoAprendizaje_idResultadoAprendizaje'])
    			 {
    			 	
    			 	if($f==0){
    			 		$obj[$f][$c]= $key1['definicionResultadoAprendizaje'];
    			 		$obj[$f][++$c]= $key2['descripcionCriterioEvaluacion'];
    			 	}
    			 	else{
    			 		$obj[$f][++$c]= $key2['descripcionCriterioEvaluacion'];
    			 	}
    			 	
    			 	$f++;
    			 }
    			 else
    			 {
    			 		$f=0;
    			 		$c=0;
    			 }

    			 */
    		} 		 
		}




		$a = array('Criterios'=>$obj1);
		$resultadoJson = $this->conexion->convertirJson($a);
		return $resultadoJson;
				
	}


	public function agregarResultadoAprendizaje(){
		$definicion = $_POST['txtDefinicion'];
		$titulo = $_POST['txtTitulo'];
		$query = "INSERT INTO ResultadoAprendizaje(definicionResultadoAprendizaje,tituloResultadoAprendizaje) VALUES('".$definicion."','".$titulo."')";
		$resultado = $this->conexion->realizarConsulta($query);
		
	}

	public function modificarResultadoAprendizaje(){

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
		$resultado = $this->conexion->realizarConsulta($query);
		$resultadoJson = $this->conexion->convertirJson($resultado);
		return $resultadoJson;	
	}

}


$objeto = new ResultadoAprendizaje();
echo $objeto->listarResultadoAprendizaje();