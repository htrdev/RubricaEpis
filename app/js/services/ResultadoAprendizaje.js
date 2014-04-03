'use strict';

rubricaApp.factory('ResultadoAprendizaje',function($http,rutasApp){

	var dataFactory = {};

	dataFactory.obtenerResultadosAprendizaje = function(){
		return $http.post(
				    rutasApp.rutaApi+'ResultadoAprendizaje.php', 
				    {metodo: 'obtenerResultadosAprendizaje'}
				 );
	};

	dataFactory.agregarResultadoAprendizaje = function(presultadoAprendizaje){
		return $http.post(
				    rutasApp.rutaApi+'ResultadoAprendizaje.php', 
				    {metodo: 'agregarResultadoAprendizajeDocente',resultadoAprendizaje: presultadoAprendizaje}
				 );
	};

	return dataFactory;
});