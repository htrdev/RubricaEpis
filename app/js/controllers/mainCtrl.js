'use strict';
rubricaApp.controller('mainCtrl',
	function mainCtrl($scope,$rootScope,$location,Usuario)
	{
		$rootScope.Interfaz =	{
			
		};
		
		$scope.usuario = {
			usuario : {
						usuario:"aaaa",
						estado : false
					},
			cargarInformacionUsuario : function(usuario){
				$scope.usuario = usuario;
				$location.path('/');
			},	

			cambiarNombreLogin : function(nombreUsuario){
				$scope.nombreUsuario = nombreUsuario;
			},

			ingresarSistema : function(){
				Usuario.ingresarSistema($scope.usuario.credenciales)
				.success(function(usuario){
					Usuario.establecerUsuario(usuario);
					$scope.usuario.cargarInformacionUsuario(usuario);
				}).
				error(function(data,status){
					console.log(status);
				})
			},

			verificarEstadoUsuario : function(){
				Usuario.verificarEstadoUsuario()
				.success(function(usuario){
					Usuario.establecerUsuario(usuario);
					if(usuario.estado){
						$scope.usuario.cargarInformacionUsuario(usuario);
					}
					else{
						$location.path('/IngresarSistema');
					}
				})
			},

			/*salirSistema : function(){
				Usuario.
			}*/
		};

		$scope.usuario.verificarEstadoUsuario();
	});