<?php

class Semestre extends Master{

	public function listarSemestre(){
		return $this->conexionSqlServer->realizarConsulta("SELECT * FROM SEMESTRE",true);
	}

	public function listarSemestrePorId($idSemestre){
		$querySemestre = "SELECT Semestre  FROM SEMESTRE  WHERE IdSem = '".$idSemestre."'";
		$semestre = $this->conexionSqlServer->realizarConsulta($querySemestre,true);
		return $semestre[0];
	}

	public function listarSemestreActivo(){
		$resultado = $this->conexionSqlServer->realizarConsulta("SELECT * FROM SEMESTRE WHERE Activo = '1'",true);
		return $resultado;
	}
}

?>