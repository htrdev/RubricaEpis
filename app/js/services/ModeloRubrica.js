'use strict';

rubricaApp.factory('ModeloRubrica',function($http){

	var urlBase = 'http://rubricaepis:8080/app/modulos/';
	var dataFactory = {};

	dataFactory.listarRubricasPorPersona = function(){
		return $http.post(
				    urlBase+'ModeloRubrica.php', 
				    {metodo: 'listarRubricasPorPersona'}
				 );
	};

	return dataFactory;
});