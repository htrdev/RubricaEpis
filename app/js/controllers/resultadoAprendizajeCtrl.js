'use strict';

// rubricaApp.controller('nuevoResultadoAprendizajeCtrl',
// 	function nuevoResultadoAprendizajeCtrl($scope,ResultadoAprendizaje)
// 	{
// 		$scope.resultadoAprendizaje = {
// 			codigoResultadoAprendizaje : "",
// 			tituloResultadoAprendizaje : "",
// 			definicionResultadoAprendizaje : "",
// 			criteriosEvaluacion : []
// 		}; 

// 		$scope.Interfaz = {
// 			agregarResultadoAprendizaje : function(){
// 				ResultadoAprendizaje.agregarResultadoAprendizaje($scope.resultadoAprendizaje)
// 				.success(function(){
// 					alert("agregado");
// 				});
// 			},

// 			MostrarResultadoAprendizaje : function(){
// 				$scope.Interfaz.EstaResultadoAprendizaje = false;
// 			},

// 			agregarCriterioEvaluacion : function(){

// 			},

// 			editarCriterioEvaluacion : function(criterio){
// 				$scope.resultadoAprendizaje.criteriosEvaluacion.indexOf(criterio);

// 			},

// 			llamarDialogBoxNuevoCriterio : function(){
// 				llamarDialogBox(function(){
// 					var descripcion = $("#criteriosEvaluacion").val();
// 					$scope.resultadoAprendizaje.criteriosEvaluacion.push({descripcionCriterioEvaluacion : descripcion});
// 					$scope.$apply();
// 				});
// 			},

// 			llamarDialogBoxEditarCriterio : function(criterio){
// 				llamarDialogBox(function(){
// 					var descripcion = $("#criteriosEvaluacion").val();
// 					var index = $scope.resultadoAprendizaje.criteriosEvaluacion.indexOf(criterio);
// 					$scope.resultadoAprendizaje.criteriosEvaluacion[index].descripcionCriterioEvaluacion = descripcion;
// 					console.log($scope.resultadoAprendizaje.criteriosEvaluacion);
// 					$scope.$apply();
// 				});
// 				$("#criteriosEvaluacion").val(criterio.descripcionCriterioEvaluacion);
// 			}
// 		};

// 		var llamarDialogBox = function(callback){
// 			bootbox.dialog("<h4 class='lighter smaller'>Descripción</h4><hr><textarea id='criteriosEvaluacion' style='width:95%;min-height:100px'></textarea>"
// 				, [{
// 				"label" : "Guardar <i class='icon-ok'></i>",
// 				"class" : "btn-small btn-success' ng-click='agregarCriterioEvaluacion()'",
// 				"callback": function() {
// 					callback();
// 				}
// 				}, {
// 				"label" : "Cancelar",
// 				"class" : "btn-small btn-danger",
// 				"callback": function() {
// 					//Example.show("uh oh, look out!");
// 				}
// 				}]);
// 		};

// 	});


rubricaApp.controller('misResultadosAprendizajeCtrl',
	function misResultadosAprendizajeCtrl($scope,$location,ResultadoAprendizaje,$filter,Paginacion)
	{
		$scope.loader = {
			estadoLoader : true,
		};
		$scope.txtBusqueda = "";
		$scope.resultadosAprendizaje = [];
		$scope.resultadosAprendizajeDocente = [];
		$scope.Formulario = {
			paginacionResultadosAprendizajeDocente : {
				totalRegistros : 1,
				paginaActual : 1,
				nroRegistrosPorPagina : 10,
				datosConFiltro : [],
				datos : [],
				datosParaMostrar : [],
				callBackBuscar : function(busqueda){
					Paginacion.callBackBuscar(busqueda,$scope.Formulario.paginacionResultadosAprendizajeDocente);
				},
				cambioPagina : function(page){
					Paginacion.cambioPagina(page,$scope.Formulario.paginacionResultadosAprendizajeDocente);
				}
			},
			paginacionResultadosAprendizaje : {
				totalRegistros : 1,
				paginaActual : 1,
				nroRegistrosPorPagina : 10,
				datosConFiltro : [],
				datos : [],
				datosParaMostrar : [],
				callBackBuscar : function(busqueda){
					Paginacion.callBackBuscar(busqueda,$scope.Formulario.paginacionResultadosAprendizaje);
				},
				cambioPagina : function(page){
					Paginacion.cambioPagina(page,$scope.Formulario.paginacionResultadosAprendizaje);
				}
			}
		}

		$scope.obtenerResultadosAprendizaje = function(){
			ResultadoAprendizaje.obtenerResultadosAprendizaje()
				.success(function(data){
					$scope.Formulario.paginacionResultadosAprendizaje.datos = data.resultadosAprendizaje;
					$scope.Formulario.paginacionResultadosAprendizajeDocente.datos = data.resultadosAprendizajeDocente;
					$scope.Formulario.paginacionResultadosAprendizajeDocente.callBackBuscar("");
					$scope.Formulario.paginacionResultadosAprendizaje.callBackBuscar("");
					console.log($scope.Formulario.paginacionResultadosAprendizajeDocente);
					$scope.loader = false;
				});
		}

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

		//METODOS

		$scope.obtenerResultadosAprendizaje();
		
	});


rubricaApp.controller('nuevoResultadoAprendizajeCtrl',
	function nuevoResultadoAprendizajeCtrl($scope,$timeout,ResultadoAprendizaje,$location)
	{
		$scope.loader = {
			estadoLoader : false,
			mensajeGuardar : "Guardando el Resultado de Aprendizaje ...",
			estadoGuardar : false,
			mensajeGuardado : "Resultado de Aprendizaje Guardado!",
			estadoFormulario : true
		};

		$scope.guardar = false;
		$scope.showFormulario = true;

		$scope.resultadoAprendizaje = {
			codigoResultadoAprendizaje : "",
			tituloResultadoAprendizaje : "",
			definicionResultadoAprendizaje : "",
			criteriosEvaluacion : []
		};

		$scope.agregarResultadoAprendizaje = function(){
			$scope.loader.estadoLoader = true;
			$scope.loader.estadoFormulario = false;
			ResultadoAprendizaje.agregarResultadoAprendizaje($scope.resultadoAprendizaje)
				.success(function(data){
				$scope.loader.estadoLoader = false;
				if(data){
					$scope.loader.estadoGuardar = true;
				}
				
			});
		};

		$scope.callBackGuardar = function(){
			$location.path('/resultadoAprendizaje');
		}

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

		$scope.Interfaz = {
			mensajeGuardar : {
				texto : "Guardar ",
				clase : ""
			}
		};

	});