'use strict';

rubricaApp.factory('ResultadoAprendizaje',function($http){

	var urlBase = 'http://rubricaepis:8080/app/modulos/';
	var dataFactory = {};

	dataFactory.listarResultadoAprendizaje = function(){
		return $http({
				    url: urlBase+'ResultadoAprendizaje.php', 
				    method: "GET",
				    params: {metodo: 'listarResultadoAprendizaje'}
				 }).success(function(data){
					}).
				  error(function(data, status, headers, config) {

				  });
	};

	return dataFactory;
});