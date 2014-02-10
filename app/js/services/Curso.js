'use strict';

rubricaApp.factory('Curso',function($http){

	var urlBase = 'http://rubricaepis:8080/app/modulos/';
	var dataFactory = {};

	dataFactory.listarDocenteActivo = function(){
		return $http.post(
				    urlBase+'Curso.php', 
				    {metodo: 'listarDocenteActivo'}
				 );
	};

	return dataFactory;
});