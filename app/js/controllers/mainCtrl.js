'use strict';

rubricaApp.controller('mainCtrl',
	function mainCtrl($scope,$rootScope,$location,Usuario)
	{
		$scope.usuario = {usuario:"aaaa",estado : false};

		$rootScope.Interfaz =	{
			cargarCredencialesUsuario : function(usuario){
				$scope.usuario = usuario;
				$location.path('/');
			}			
		};

		var verificarEstadoUsuario = function(){
			Usuario.verificarEstadoUsuario()
				.success(function(usuario){
					Usuario.establecerUsuario(usuario);
					console.log(usuario);
					if(usuario.estado){
						console.log("wtf");
						$rootScope.Interfaz.cargarCredencialesUsuario(usuario);
					}
					else{
						$location.path('/IngresarSistema');
					}
				});
		}
		verificarEstadoUsuario();
	});