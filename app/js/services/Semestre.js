'use strict';

rubricaApp.factory('Semestre',function($http){

	var urlBase = 'http://rubricaepis:8080/app/modulos/';
	var dataFactory = {};

	dataFactory.listarSemestre = function(){
		return $http.post(
				    urlBase+'Semestre.php', 
				    {metodo: 'listarSemestre'}
				 );
	};

	dataFactory.listarSemestreActivo  = function(){
			return $http.post(
				    urlBase+'Semestre.php', 
				    {metodo: 'listarSemestreActivo'}
				 );
		};

	return dataFactory;
	
});