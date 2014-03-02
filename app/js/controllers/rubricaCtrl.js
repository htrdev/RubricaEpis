'use strict';

rubricaApp.controller('nuevoRubricaCtrl',
	function nuevoRubricaCtrl($scope,Rubrica)
	{
		$scope.itemsSeleccionados = {
			cursoSeleccionado : {
				idcurso : 0,
				DesCurso : "",
				CodCurso : "",
				CicloCurso : ""
			}
		};
		
		$scope.loader = {
			estadoLoader : true
		};

		$scope.modeloRubrica = {
			idCurso : 0,
			idSemestre : 0,
			fechaInicio : "",
			fechaFinal : "",
			docentes :[],
			calificacionRubrica : "",
			criteriosEvaluacion : [],
			tipoModeloRubrica : "",
		};

		$scope.obtenerInformacionNuevaRubrica = function(){
			Rubrica.obtenerInformacionNuevaRubrica()
				.success(function(data){
					$scope.semestre = data.semestre;
					$scope.modeloRubrica.idSemestre = $scope.semestre[0].IdSem;
					$scope.resultadosAprendizaje = data.resultadosAprendizaje.resultadosAprendizaje;
					$scope.docentes = data.docentes;
					$scope.cursos = data.cursos;
					$scope.loader.estadoLoader = false;
				});
		};

		

		$scope.Formulario = {
			EstaCuestionario : false,
			AgregarDocente : function(docente){
				if(docente.estaSeleccionado)
				{
					$scope.modeloRubrica.docentes.push(docente.CodPer);
				}
				else{
					$scope.modeloRubrica.docentes.splice($scope.modeloRubrica.docentes.indexOf(docente),1);
				}	
			},
			callBackCboCurso : function(cursoSeleccionado){
				$scope.modeloRubrica.idCurso = cursoSeleccionado.idcurso;
				console.log(cursoSeleccionado);
			},

			AgregarCriterioSeleccionado : function(criterio){
				if(criterio.estaSeleccionado)
				{
					$scope.modeloRubrica.criteriosEvaluacion.push(criterio);
				}
				else{
					$scope.modeloRubrica.criteriosEvaluacion.splice($scope.modeloRubrica.criteriosEvaluacion.indexOf(criterio),1);
				}
			},

			MostrarCuestionario : function(){
				$scope.Formulario.EstaCuestionario = true;
				console.log($scope.modeloRubrica);

			},

			OcultarCuestionario : function(){
				$scope.Formulario.EstaCuestionario = false;
			},
			cargarComponentes : function(){
				$.fn.datepicker.dates['es'] = {
	                days: ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo"],
	                daysShort: ["Dom", "Lun", "Mar", "Mié", "Jue", "Vie", "Sáb", "Dom"],
	                daysMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa", "Do"],
	                months: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
	                monthsShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"]
	        		};
			},
			Guardar : function(){
				console.log($scope.modeloRubrica);
				Rubrica.agregarModeloRubrica($scope.modeloRubrica)
					.success(function(data){
						console.log(data);
					});
			}
		}

		//METODOS
		$scope.obtenerInformacionNuevaRubrica();
		$scope.Formulario.cargarComponentes();
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

