'use strict';

rubricaApp.factory('Usuario',function($http,rutasApp){
	var usuario = {usuario : "",estado : false};
	var dataFactory = {};

	dataFactory.verificarEstadoUsuario = function(){
			return $http.post(
				    rutasApp.rutaApi+'Usuario.php', 
				    {metodo: 'verificarUsuario'}
				 	);
		};

	dataFactory.ingresarSistema = function(pusuario){
			return $http.post(
				    rutasApp.rutaApi+'Usuario.php', 
				    {metodo: 'ingresarSistema',usuario:pusuario}
				 );
		};

	dataFactory.salirSistema = function(pusuario){
			return $http.post(
				    rutasApp.rutaApi+'Usuario.php', 
				    {metodo: 'salirSistema'}
				 );
		};

	dataFactory.establecerUsuario = function(pusuario){
		usuario = pusuario;
	};	

	dataFactory.obtenerUsuario = function(){
		return usuario;
	}

	return dataFactory;
});

