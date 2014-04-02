<?php

class Master extends Singleton{

	protected $conexionSqlServer;

	protected function __construct(){
		$this->conexionSqlServer = ConexionFactory::obtenerConexion('sqlserver');
	}

}
