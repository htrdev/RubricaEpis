'use strict';

rubricaApp.controller('crearRubricaCtrl',
	function crearRubricaCtrl($scope,Semestre,ResultadoAprendizaje,Docente,Curso)
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
			calificacionRubrica : 'Alumno',
			criteriosEvaluacion : [1,2,3,4],
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
				});
		};

		function listarCursosDocente(){
			Curso.listarCursosDocente()
				.success(function(cursos){
					$scope.cursos = cursos;
				});
		};

		/*$scope.docentes = [

			{nombre:'IBARRA MONTECINOS, MARIELLA ROSARIO'},
			{nombre:'ALE NIETO, TITO FERNANDO'},
			{nombre:'PAREDES VIGNOLA, MARTHA JUDITH'},
			{nombre:'CHAIÑA CONDORI, HENRY WILSON'},
			{nombre:'SISA YATACO, HAYDEE RAQUEL'},
			{nombre:'LANCHIPA VALENCIA, ENRIQUE FELIX'},
			{nombre:'FERNANDEZ VIZCARRA, LUIS ALFREDO'},
			{nombre:'MARTINEZ SALAMANCA, MARCIA HILDA'},
			{nombre:'HUAYTA CURO, JENNY GABRIELA'},
			{nombre:'MARTINEZ PEÑALOZA, MINELLY YSABEL'},
			{nombre:'PAJUELO BELTRAN, CARLOS ALBERTO'},
			{nombre:'POVEA CONDORI, ABEL'},
			{nombre:'RUIZ CANCINO, CARLOS ALBERTO'},
			{nombre:'OSCO MAMANI, ERBERT FRANCISCO'},
			{nombre:'VALCARCEL ALVARADO, RICARDO EDUARDO'},
			{nombre:'RODRIGUEZ MARCA, ELARD RICARDO'},
			{nombre:'TEJERINA RIVERA, JESUS RAUL'},
			{nombre:'CENTELLA VILDOSO, SILVIA MARLENE'},
			{nombre:'CAPIA TICONA, MARCELINA MARIA'},
			{nombre:'AGUILAR ORTIZ, MANUEL CHRISTIAN'},
			{nombre:'VEGA BERNAL, LILIANA MERCEDES MILAGROS'},
			{nombre:'ALCANTARA MARTINEZ, HUGO MARTIN'},
			{nombre:'ALANOCA LLANOS, RODOLFO MARIANO'},
			{nombre:'LIENDO HUABLOCHE, ROBERTO MAURICIO'},
			{nombre:'ROJAS MORALES, IVAN CESAR'},
			{nombre:'ALCA GOMEZ, JAVIER'}
		
		];*/

		

		



		$scope.criterios = [];

		/*$scope.resultadosAprendizaje = [
			{
				nombre : "1a. Aplicacion de Ciencias",
				criterios : [{descripcion:"Entiende e interpreta fenomenos naturales aplicando las leyes fundamentales que los gobiernan"},
							{descripcion: "Aplica modelos matematicos en la solucion de problemas"},
							{descripcion: "Aplica conocimientos y tecnicas matematicas para analizar, modelar y simular soluciones de TI"},
							{descripcion: "Aplica conocimientos de Ciencias e Ingenieria para presentar una solucion algoritmica factible para resolver su problema"},
							]

			}
			,{
				nombre : "2b. Experimentacion y Pruebas",
				criterios : [{descripcion:"Determina las pruebas y experimientos a realizar tomando en cuenta los estandares de calidad requerimientos"},
							{descripcion: "identifica y relaciona las variables de los Sistemas de software e informacion y los mide o estima con la precision requerida"}]
			}
		];*/

		$scope.Interfaz =	{
			AgregarCriterioSeleccionado : function(criterio){
				if(criterio.estaSeleccionado)
				{
					$scope.criterios.push(criterio);
				}
				else{
					$scope.criterios.splice($scope.criterios.indexOf(criterio),1);
				}
			},

			MostrarCuestionario : function(){
				$scope.Interfaz.EstaCuestionario = true;
				console.log($scope.resultadosAprendizaje);
			},

			OcultarCuestionario : function(){
				$scope.Interfaz.EstaCuestionario = false;
			},

			EstaCuestionario : false
		}



	});