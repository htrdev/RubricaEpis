'use strict';

rubricaApp.controller('ListarResultadoAprendizajeController',
	function CrearRubricaController($scope)
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