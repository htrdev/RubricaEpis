'use strict';

rubricaApp.factory('Rubrica',function($http){

	var urlBase = 'http://rubricaepis:8080/app/modulos/';
	var dataFactory = {};

	dataFactory.agregarModeloRubrica = function(pmodelorubrica){
		return $http.post(
				    urlBase+'Rubrica.php', 
				    {metodo: 'agregarModeloRubrica'
				    ,modelorubrica: pmodelorubrica}
				 );
	};


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

	dataFactory.obtenerResultadoRubricaPorRubricaAsignada = function(pidModeloRubrica){
		return $http.post(
				    urlBase+'ResultadoRubrica.php', 
				    {metodo: 'listarResultadoRubricaPorcionRubricaAsignada'
				    ,idModeloRubrica : pidModeloRubrica}
				 );
	};

	dataFactory.obtenerResultadoRubricaPorRubricaCreada = function(pidModeloRubrica){
		return $http.post(
				    urlBase+'ResultadoRubrica.php', 
				    {metodo: 'listarResultadoRubricaPorIDModeloRubrica'
				    ,idModeloRubrica : pidModeloRubrica}
				 );
	};

	dataFactory.obtenerResultadoRubricaPorId = function(pidResultadoRubrica){
		return $http.post(
				urlBase+'ResultadoRubrica.php',
				{metodo: 'resultadoRubricaPorID'
				,idResultadoRubrica:pidResultadoRubrica}
			);
	};

	dataFactory.obtenerAlumnosPorCurso = function(pidCurso){
		return $http.post(
				urlBase+'Rubrica.php',
				{metodo: 'obtenerAlumnosPorCurso'
				,idCurso:pidCurso}
			);
	};

	return dataFactory;
	
});