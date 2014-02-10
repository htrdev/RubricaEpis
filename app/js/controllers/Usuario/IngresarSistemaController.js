'use strict';

rubricaApp.controller('IngresarSistemaController',
	function IngresarSistemaController($scope,$rootScope,$location,Usuario)
	{
		$scope.ingresarSistema = function(){
			Usuario.autenticarUsuario($scope.usuario)
				.success(function(usuario){
					Usuario.establecerUsuario(usuario);
					$rootScope.Interfaz.cargarCredencialesUsuario(usuario);
				}).
				error(function(data,status){
					console.log(status);
				});

		};

		$scope.Interfaz =	{
			cambiarNombreLogin : function(nombreUsuario){
				$scope.nombreUsuario = nombreUsuario;
			}			
		};

		
});