'use strict';

rubricaApp.factory('Usuario',function($http){
	var usuario = {usuario : "",estado : false};
	var urlBase = 'http://rubricaepis:8080/app/modulos/';
	var dataFactory = {};

	dataFactory.verificarEstadoUsuario = function(){
			return $http.post(
				    urlBase+'Usuario.php', 
				    {metodo: 'verificarUsuario'}
				 	);
		};

	dataFactory.ingresarSistema = function(pusuario){
			return $http.post(
				    urlBase+'Usuario.php', 
				    {metodo: 'ingresarSistema',usuario:pusuario}
				 );
		};

	dataFactory.salirSistema = function(pusuario){
			return $http.post(
				    urlBase+'Usuario.php', 
				    {metodo: 'salirSistema'}
				 );
		};

	dataFactory.establecerUsuario = function(pusuario){
		usuario = pusuario;
	};	

	dataFactory.estaLogeado = function(){
		return usuario.estado;
	}

	return dataFactory;
});

