'use strict';

rubricaApp.controller('nuevoRubricaCtrl',
	function nuevoRubricaCtrl($scope,Rubrica)
	{
		$scope.loader = {
			estadoLoader : true
		};
		$scope.rubrica = {
			idCurso : 1,
			idSemestre : 2,
			fechaInicio : "",
			fechaFinal : "",
			docentes : [1,2,3,4],
			calificacionRubrica : [],
			criteriosEvaluacion : [],
			tipoRubrica : 'Curso'
		};

		var obtenerInformacionNuevaRubrica = function(){
			Rubrica.obtenerInformacionNuevaRubrica()
				.success(function(data){
					$scope.semestre = data.semestre;
					$scope.resultadosAprendizaje = data.resultadosAprendizaje.resultadosAprendizaje;
					$scope.docentes = data.docentes;
					$scope.cursos = data.cursos;
					$scope.loader.estadoLoader = false;
				});
		};

		$scope.Interfaz =	{
			AgregarCriterioSeleccionado : function(criterio){
				if(criterio.estaSeleccionado)
				{
					$scope.rubrica.criteriosEvaluacion.push(criterio);
				}
				else{
					$scope.rubrica.criteriosEvaluacion.splice($scope.rubrica.criteriosEvaluacion.indexOf(criterio),1);
				}
			},

			MostrarCuestionario : function(){
				$scope.Interfaz.EstaCuestionario = true;
			},

			OcultarCuestionario : function(){
				$scope.Interfaz.EstaCuestionario = false;
			},

			EstaCuestionario : false
		}

		obtenerInformacionNuevaRubrica();
	});

rubricaApp.controller('listarEstadoRubricaCtrl',
	function listarEstadoRubricaCtrl($scope,$location,$routeParams)
	{

		$scope.rubricasCalificadas = [
		{id:1,fecha:"13-12-12",evaluado:"OCHOA LOMA, SCHARLY; AROCUTIPA SERRANO, DEIVI; CHURA MAMANI, BRISEIDA",promedio:"16",docente:"LANCHIPA VALENCIA, ENRIQUE FELIX"},
		{id:2,fecha:"14-12-12",evaluado:"LOMA ESPEZUA, HALAN",promedio:"13",docente:"CHAIÑA CONDORI, HENRY WILSON"},
		{id:3,fecha:"14-12-12",evaluado:"LOMA ESPEZUA, HALAN",promedio:"14",docente:"LANCHIPA VALENCIA, ENRIQUE FELIX"}
		];

		
		$scope.EstaRubricasCreadas = true;

		$scope.idRubrica = $routeParams.idRubrica;

		$scope.Interfaz =	{
			OcultarRubricasAsignadas : function(){
				$scope.EstaRubricasCreadas = true;
			},

			MostrarRubricasAsignadas : function(){
				$scope.EstaRubricasCreadas = false;
			},

			IrA : function(ruta){
				$location.path(ruta);
			}
		}


	});

rubricaApp.controller('misRubricasCtrl',
	function misRubricasCtrl($scope,$location,Rubrica)
	{
		$scope.currentPage = 1;
		$scope.asd = 50;
		$scope.misRubricas = [];
		$scope.rubricasAsignadas = [];
		$scope.loader = {
			estadoLoader : true
		};

		var obtenerRubricasPorPersona = function(){
			Rubrica.obtenerRubricasPorPersona()
				.success(function(data){
					$scope.misRubricas = data.misRubricas;
					$scope.rubricasAsignadas = data.rubricasAsignadas;
					$scope.loader.estadoLoader = false;
				});

		};

		$scope.EstaRubricasCreadas = true;

		$scope.Interfaz =	{
			OcultarRubricasAsignadas : function(){
				$scope.EstaRubricasCreadas = true;
			},

			MostrarRubricasAsignadas : function(){
				$scope.EstaRubricasCreadas = false;
			},
			alert1 : function(){
				alert("Aqui deberia mandarme al formulario similar al Crear Rubrica pero listo para editar esta Rubrica");
			},
			alert2 : function(){
				alert("Aqui me mostrara otro grid donde me mostrara todas las veces que he llenado esta rubrica pero en diferentes alumnos")
			},
			alert3 : function(){
				alert("Aqui me mostrara el formulario para llenar esta Rubrica hacia determinado alumno");
			},

			redireccionarNuevo : function(){
				$location.path('/rubricas/nuevo');
			}
		}

		//EJECUCION DE METODOS
		obtenerRubricasPorPersona();
	});

rubricaApp.controller('verRubricasAsignadasCtrl',
	function verRubricasAsignadasCtrl($scope,Rubrica,$routeParams){
		$scope.resultadoRubricaPorRubricaAsignada = [];
		$scope.idRubricaAsignada = $routeParams.idRubricaAsignada;

		$scope.obtenerResultadoRubricaPorRubricaAsignada = function(){
			console.log($routeParams.idRubricaAsignada);
				Rubrica.obtenerResultadoRubricaPorRubricaAsignada($routeParams.idRubricaAsignada)
				.success(function(data){
					$scope.resultadosRubricaPorRubricaAsignada = data;
					console.log($scope.resultadosRubricaPorRubricaAsignada);
				});
		};
		$scope.obtenerResultadoRubricaPorRubricaAsignada();
	});

rubricaApp.controller('verRubricasCreadasCtrl',
	function verRubricasCreadasCtrl($scope,Rubrica,$routeParams){
		$scope.resultadoRubricaPorRubricaCreada = [];
		$scope.idRubricaCreada = $routeParams.idRubricaCreada;

		$scope.obtenerResultadoRubricaPorRubricaCreada = function(){
			console.log($routeParams.idRubricaAsignada);
				Rubrica.obtenerResultadoRubricaPorRubricaCreada($routeParams.idRubricaCreada)
				.success(function(data){
					$scope.resultadoRubricaPorRubricaCreada = data;
				});
		};
		$scope.obtenerResultadoRubricaPorRubricaCreada();
	});

