'use strict';

rubricaApp.factory('ResultadoAprendizaje',function($http){

	var urlBase = 'http://rubricaepis:8080/app/modulos/';
	var dataFactory = {};

	dataFactory.listarResultadoAprendizaje = function(){
		return $http.post(
				    urlBase+'ResultadoAprendizaje.php', 
				    {metodo: 'listarResultadoAprendizaje'}
				 );
	};

	dataFactory.agregarResultadoAprendizaje = function(presultadoAprendizaje){
		return $http.post(
				    urlBase+'ResultadoAprendizaje.php', 
				    {metodo: 'agregarResultadoAprendizaje',resultadoAprendizaje: presultadoAprendizaje}
				 );
	};

	return dataFactory;
});