'use strict';

rubricaApp.factory('Rubrica',function($http,rutasApp){

	var dataFactory = {};

	dataFactory.agregarModeloRubrica = function(pmodelorubrica){
		return $http.post(
				    rutasApp.rutaApi+'Rubrica.php', 
				    {metodo: 'agregarModeloRubrica'
				    ,modelorubrica: pmodelorubrica}
				 );
	};


	dataFactory.obtenerInformacionNuevaRubrica = function(){
		return $http.post(
				    rutasApp.rutaApi+'Rubrica.php', 
				    {metodo: 'obtenerInformacionNuevaRubrica'}
				 );
	};

	dataFactory.obtenerRubricasPorPersona = function(pSemestreSeleccionado){
		return $http.post(
				    rutasApp.rutaApi+'Rubrica.php', 
				    {metodo: 'obtenerRubricasPorPersona'
					,semestreSeleccionado : pSemestreSeleccionado}
				 );
	};

	dataFactory.obtenerResultadoRubricaPorRubricaAsignada = function(pidModeloRubrica){
		return $http.post(
				    rutasApp.rutaApi+'ResultadoRubrica.php', 
				    {metodo: 'listarResultadoRubricaPorcionRubricaAsignada'
				    ,idModeloRubrica : pidModeloRubrica}
				 );
	};

	dataFactory.obtenerResultadoRubricaPorRubricaCreada = function(pidModeloRubrica){
		return $http.post(
				    rutasApp.rutaApi+'ResultadoRubrica.php', 
				    {metodo: 'listarResultadoRubricaPorIDModeloRubrica'
				    ,idModeloRubrica : pidModeloRubrica}
				 );
	};

	dataFactory.obtenerResultadoRubricaPorId = function(pidResultadoRubrica){
		return $http.post(
				rutasApp.rutaApi+'ResultadoRubrica.php',
				{metodo: 'obtenerResultadoRubricaPorID'
				,idResultadoRubrica:pidResultadoRubrica}
			);
	};

	dataFactory.obtenerAlumnosPorCurso = function(pidCurso){
		return $http.post(
				rutasApp.rutaApi+'Rubrica.php',
				{metodo: 'obtenerAlumnosPorCurso'
				,idCurso:pidCurso}
			);
	};

	dataFactory.completarResultadoRubrica = function(pResultadoRubrica){
		return $http.post(
				rutasApp.rutaApi+'ResultadoRubrica.php',
				{metodo: 'completarResultadoRubrica'
				,resultadoRubrica:pResultadoRubrica}
			);
	};

	

	return dataFactory;
	
});