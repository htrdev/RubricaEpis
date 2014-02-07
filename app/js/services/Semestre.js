'use strict';

rubricaApp.factory('Semestre',function($http){

	var urlBase = 'http://rubricaepis:8080/app/modulos/';
	var dataFactory = {};

	dataFactory.listarSemestre = function(){
		return $http({
				    url: urlBase+'Semestre.php', 
				    method: "GET",
				    params: {metodo: 'listarSemestre'}
				 }).success(function(data){
						
					}).
				  error(function(data, status, headers, config) {

				  });
	};

	dataFactory.listarSemestreActivo  = function(){
			return $http({
				    url: urlBase+'Semestre.php', 
				    method: "GET",
				    params: {metodo: 'listarSemestreActivo'}
				 }).success(function(data){
					}).
				  error(function(data, status, headers, config) {
				  });
		};

	return dataFactory;
	
});