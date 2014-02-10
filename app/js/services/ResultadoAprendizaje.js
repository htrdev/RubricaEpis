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

	return dataFactory;
});