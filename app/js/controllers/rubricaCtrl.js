'use strict';

rubricaApp.controller('nuevoRubricaCtrl',
	function nuevoRubricaCtrl($scope,Semestre,ResultadoAprendizaje,Docente,Curso)
	{
		$scope.loader = true;
		$scope.semestre;
		$scope.resultadosAprendizaje;
		$scope.docentes;
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

		listarSemestreActivo();
		listarResultadoAprendizaje();
		listarDocenteActivo();
		listarCursosDocente();

		function listarSemestreActivo(){
			Semestre.listarSemestreActivo()
				.success(function(semestre){
					$scope.semestre = semestre;
				});
		};

		function listarResultadoAprendizaje(){
			ResultadoAprendizaje.listarResultadoAprendizaje()
				.success(function(resultadosAprendizaje){
					$scope.resultadosAprendizaje = resultadosAprendizaje;
				});
		};

		function listarDocenteActivo(){
			Docente.listarDocenteActivo()
				.success(function(docentes){
					$scope.docentes = docentes;
					$scope.loader = false;
				});
		};

		function listarCursosDocente(){
			Curso.listarCursosDocente()
				.success(function(cursos){
					$scope.cursos = cursos;
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
	});


rubricaApp.controller('listarEstadoRubricaCtrl',
	function listarEstadoRubricaCtrl($scope,$location,$routeParams)
	{
		//el campo evaluado debe ser un array
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
	function misRubricasCtrl($scope,$location,Usuario,ModeloRubrica)
	{
		
		$scope.misRubricas = [];
		$scope.rubricasAsignadas = [];
		$scope.loader = true;

		var listarMisRubricas = function(){
			ModeloRubrica.listarRubricasPorPersona()
				.success(function(data){
					$scope.misRubricas = data.misRubricas;
					$scope.rubricasAsignadas = data.rubricasAsignadas;
					$scope.loader = false;
				});

		};

		listarMisRubricas();

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

	});