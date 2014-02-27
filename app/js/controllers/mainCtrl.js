'use strict';
rubricaApp.controller('mainCtrl',
	function mainCtrl($scope,$rootScope,$location,Usuario)
	{
		$scope.loader = true;
		
		$scope.usuario = {
			usuario : {
						usuario:"aaaa",
						estado : false
					},
			credenciales :{
				email : "",
				password : ""
			},
			cargarInformacionUsuario : function(usuario){
				$scope.usuario.usuario = usuario;
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
						$scope.loader = false;
					}
					else{
						$location.path('/login');
						$scope.loader = false;
					}
				})
			},
			salirSistema : function(){
				Usuario.salirSistema()
				.success(function(usuario){
					Usuario.establecerUsuario(usuario);
					$scope.usuario.cargarInformacionUsuario(usuario);
					$scope.usuario.credenciales.email = "";
					$scope.usuario.credenciales.password ="";
					$location.path('/login');
					
				});
			}
		};

		$scope.usuario.verificarEstadoUsuario();
	});