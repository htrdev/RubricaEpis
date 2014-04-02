<?php

//VARIABLES GLOBALES
define('rutaApp',$_SERVER["DOCUMENT_ROOT"]);

//AGREGAR ARCHIVOS

require_once rutaApp.'/app/modulos/Error.php';
require_once rutaApp.'/app/clases/Singleton.php';
require_once rutaApp.'/app/clases/Conexion.php';
require_once rutaApp.'/app/clases/Master.php';

//HANDLER ERRORES

