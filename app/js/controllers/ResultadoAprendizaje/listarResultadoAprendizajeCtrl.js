'use strict';

rubricaApp.controller('listarResultadoAprendizajeCtrl',
	function listarResultadoAprendizajeCtrl($scope,$location)
	{
		$scope.Interfaz = {
			EstaResultadoAprendizaje : false,

			MostrarMisResultadoAprendizaje : function(){
				$scope.Interfaz.EstaResultadoAprendizaje = true;
			},

			MostrarResultadoAprendizaje : function(){
				$scope.Interfaz.EstaResultadoAprendizaje = false;
			},
			redireccionarNuevo : function(){
				$location.path('/resultadoAprendizaje/nuevo');
			}
		};
	});