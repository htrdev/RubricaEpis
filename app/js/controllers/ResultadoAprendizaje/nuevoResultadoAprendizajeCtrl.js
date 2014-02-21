'use strict';

rubricaApp.controller('nuevoResultadoAprendizajeCtrl',
	function nuevoResultadoAprendizajeCtrl($scope,ResultadoAprendizaje)
	{
		
		$scope.resultadoAprendizaje = {
			codigoResultadoAprendizaje : "",
			tituloResultadoAprendizaje : "",
			definicionResultadoAprendizaje : "",
			criteriosEvaluacion : []
		};

		$scope.agregarResultadoAprendizaje = function(){
			ResultadoAprendizaje.agregarResultadoAprendizaje($scope.resultadoAprendizaje)
				.success(function(){
					alert("agregado");
			});
		};

		$scope.callBackBorrarCriterio = function(criterio){
			var index = $scope.resultadoAprendizaje.criteriosEvaluacion.indexOf(criterio);
			$scope.resultadoAprendizaje.criteriosEvaluacion.splice($scope.resultadoAprendizaje.criteriosEvaluacion.indexOf(criterio),1);
			console.log($scope.resultadoAprendizaje.criteriosEvaluacion);
		};

		$scope.llamarDialogBoxNuevoCriterio = function(){
				llamarDialogBox(function(){
					var descripcion = $("#criteriosEvaluacion").val();
					$scope.resultadoAprendizaje.criteriosEvaluacion.push({descripcionCriterioEvaluacion : descripcion});
					$scope.$apply();
				});
			};

		$scope.llamarDialogBoxEditarCriterio = function(criterio){
				llamarDialogBox(function(){
					var descripcion = $("#criteriosEvaluacion").val();
					var index = $scope.resultadoAprendizaje.criteriosEvaluacion.indexOf(criterio);
					$scope.resultadoAprendizaje.criteriosEvaluacion[index].descripcionCriterioEvaluacion = descripcion;
					console.log($scope.resultadoAprendizaje.criteriosEvaluacion);
					$scope.$apply();
				});
				$("#criteriosEvaluacion").val(criterio.descripcionCriterioEvaluacion);
			};

		var llamarDialogBox = function(callback){
			bootbox.dialog("<h4 class='lighter smaller'>Descripción</h4><hr><textarea id='criteriosEvaluacion' style='width:95%;min-height:100px'></textarea>"
				, [{
				"label" : "Guardar <i class='icon-ok'></i>",
				"class" : "btn-small btn-success",
				"callback": function() {
					callback();
				}
				}, {
				"label" : "Cancelar",
				"class" : "btn-small btn-danger",
				"callback": function() {
					//Example.show("uh oh, look out!");
				}
				}]);
		};

	});