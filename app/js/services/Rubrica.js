'use strict';

rubricaApp.factory('Rubrica',function($http){

	var urlBase = 'http://rubricaepis:8080/app/modulos/';
	var dataFactory = {};

	dataFactory.obtenerInformacionNuevaRubrica = function(){
		return $http.post(
				    urlBase+'Rubrica.php', 
				    {metodo: 'obtenerInformacionNuevaRubrica'}
				 );
	};

	dataFactory.obtenerRubricasPorPersona = function(){
		return $http.post(
				    urlBase+'Rubrica.php', 
				    {metodo: 'obtenerRubricasPorPersona'}
				 );
	};

	return dataFactory;
	
});