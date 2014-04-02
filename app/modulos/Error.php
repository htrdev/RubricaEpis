<?php

function shutdown() {
    $isError = false;

    if ($error = error_get_last()){
    switch($error['type']){
        case E_ERROR:
        case E_CORE_ERROR:
        case E_COMPILE_ERROR:
        case E_USER_ERROR:
            $isError = true;
            break;
        }
    }

    if ($isError){
       echo "ERROR : ".$error["message"]." , Archivo : ".$error["file"]." , Linea : ".$error["line"];//do whatever you need with it
    }
}

register_shutdown_function('shutdown');


class ExceptionApp extends Exception{
	public function __construct($message, $code = 0, Exception $previous = null) {
        $error = error_get_last();
        $mensaje = "ERROR : ".$error["message"]." , Archivo : ".$error["file"]." , Linea : ".$error["line"];
        parent::__construct($mensaje, $code, $previous);
    }
}

function definirExcepcion($ex){
	if($ex instanceof PDOException){
		return $ex;
	}else{
		$exApp = new ExceptionApp();
		return $exApp;
	}
}