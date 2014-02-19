'use strict';

rubricaApp.controller('nuevoRubricaCtrl',
	function nuevoRubricaCtrl($scope,Semestre,ResultadoAprendizaje,Docente,Curso)
	{
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
					debugger;
				});
		};

		function listarResultadoAprendizaje(){
			ResultadoAprendizaje.listarResultadoAprendizaje()
				.success(function(resultadosAprendizaje){
					$scope.resultadosAprendizaje = resultadosAprendizaje;
					debugger;
				});
		};

		function listarDocenteActivo(){
			Docente.listarDocenteActivo()
				.success(function(docentes){
					$scope.docentes = docentes;
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