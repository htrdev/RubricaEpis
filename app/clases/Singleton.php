<?php

abstract class Singleton{
	
	private static $objetos;

	protected function __construct()
	{

	}

	public static function obtenerObjeto()
	{
		$clase = get_called_class();

        if (!isset(self::$objetos[$clase])) {
            self::$objetos[$clase] = new $clase;
        }
        return self::$objetos[$clase];
	}
}