'use strict';

rubricaApp.factory('Docente',function($http){

	var urlBase = 'http://rubricaepis:8080/app/modulos/';
	var dataFactory = {};

	dataFactory.listarDocenteActivo = function(){
		return $http.post(
				    urlBase+'Docente.php', 
				    {metodo: 'listarDocenteActivo'}
				 );
	};

	return dataFactory;
});