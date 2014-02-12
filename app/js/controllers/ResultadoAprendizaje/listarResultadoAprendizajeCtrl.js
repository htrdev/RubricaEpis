'use strict';

rubricaApp.controller('listarResultadoAprendizajeCtrl',
	function listarResultadoAprendizajeCtrl($scope)
	{
		$scope.Interfaz = {
			EstaResultadoAprendizaje : false,

			MostrarMisResultadoAprendizaje : function(){
				$scope.Interfaz.EstaResultadoAprendizaje = true;
			},

			MostrarResultadoAprendizaje : function(){
				$scope.Interfaz.EstaResultadoAprendizaje = false;
			}
		};
	});