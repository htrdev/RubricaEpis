'use strict';

rubricaApp.factory('Docente',function($http){

	var urlBase = 'http://rubricaepis:8080/app/modulos/';
	var dataFactory = {};

	dataFactory.listarDocenteActivo = function(){
		return $http({
				    url: urlBase+'Docente.php', 
				    method: "GET",
				    params: {metodo: 'listarDocenteActivo'}
				 }).success(function(data){
					}).
				  error(function(data, status, headers, config) {

				  });
	};

	return dataFactory;
});