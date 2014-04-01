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

		$scope.grupoAlumnos = [];

		$scope.modeloRubrica = {
			idCurso : 0,
			idSemestre : 0,
			fechaInicio : "",
			fechaFinal : "",
			docentes :[],
			alumnos : [],
			calificacionRubrica : "Alumnos",
			resultadosAprendizaje : [],
			tipoModeloRubrica : "Curso",
		};

		$scope.obtenerInformacionNuevaRubrica = function(){
			Rubrica.obtenerInformacionNuevaRubrica()
				.success(function(data){
					console.log(data);
					$scope.semestre = data.semestre;
					$scope.modeloRubrica.idSemestre = $scope.semestre[0].idSem;
					$scope.resultadosAprendizaje = data.resultadosAprendizaje.resultadosAprendizaje;
					$scope.docentes = data.docentes;
					$scope.cursos = data.cursos;
					$scope.loader.estadoLoader = false;
				});
		};

		$scope.obtenerAlumnosPorCurso = function(){
			Rubrica.obtenerAlumnosPorCurso($scope.modeloRubrica.idCurso)
				.success(function(data){
					data.forEach(function(alumno){
						$scope.modeloRubrica.alumnos.push([alumno["CodPer"]]);
					});
					console.log($scope.modeloRubrica);
				});
		}

		$scope.sortableOptions = {
		    connectWith: ".app-container"
		  };

		$scope.Formulario = {
			EstaCuestionario : false,
			resultadosAprendizajeSeleccionados : [],
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
				$scope.obtenerAlumnosPorCurso();
			},

			AgregarCriterioSeleccionado : function(resultadoAprendizaje,criterio){
				if(criterio.estaSeleccionado)
				{
					$scope.Formulario.AgregarResultadoAprendizajeALista(resultadoAprendizaje,criterio);
					console.log($scope.modeloRubrica.resultadosAprendizaje);
				}
				else{
					$scope.Formulario.QuitarResultadoAprendizajeLista(resultadoAprendizaje,criterio);
					console.log($scope.modeloRubrica.resultadosAprendizaje);
				}
			},

			QuitarResultadoAprendizajeLista : function(resultadoAprendizaje,criterio){
				var nombreRa = resultadoAprendizaje.codigoResultadoAprendizaje+' '+resultadoAprendizaje.tituloResultadoAprendizaje;
				var resultado = $scope.Formulario.RevisarExistenciaResultadoAprendizajeEnLista(nombreRa);
				if($scope.modeloRubrica.resultadosAprendizaje[resultado].criteriosEvaluacion.length === 1){
					$scope.modeloRubrica.resultadosAprendizaje.splice($scope.modeloRubrica.resultadosAprendizaje[resultado], 1);
				}
				else{
					$scope.modeloRubrica.resultadosAprendizaje[resultado].criteriosEvaluacion.splice($scope.modeloRubrica.resultadosAprendizaje[resultado].criteriosEvaluacion.indexOf(criterio),1);
				}
			},

			AgregarResultadoAprendizajeALista : function(resultadoAprendizaje,criterio){
				var nombreRa = resultadoAprendizaje.codigoResultadoAprendizaje+' '+resultadoAprendizaje.tituloResultadoAprendizaje;
				var resultado = $scope.Formulario.RevisarExistenciaResultadoAprendizajeEnLista(nombreRa);
				if(resultado===false){
					var ra = { nombreResultadoAprendizaje : nombreRa,criteriosEvaluacion : [] };
					ra.criteriosEvaluacion.push(criterio);
					$scope.modeloRubrica.resultadosAprendizaje.push(ra);
				}
				else{
					$scope.modeloRubrica.resultadosAprendizaje[resultado].criteriosEvaluacion.push(criterio);
				}
				
			},

			RevisarExistenciaResultadoAprendizajeEnLista : function(nombreRa){
				var resultado = false;
				$scope.modeloRubrica.resultadosAprendizaje.forEach(function(ra,index,array){
					if(ra.nombreResultadoAprendizaje == nombreRa){
						resultado = index;
					}
				});
				return resultado;
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

		
		$scope.EstaRubricasCreadas = false;

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
	function misRubricasCtrl($scope,$location,Rubrica,Paginacion)
	{
		$scope.semestreSeleccionado = null;
		$scope.currentPage = 1;
		$scope.asd = 50;
		$scope.misRubricas = [];
		$scope.rubricasAsignadas = [];
		$scope.loader = {
			estadoLoader : true
		};

		$scope.obtenerRubricasPorPersona = function(semestre){
			$scope.loader.estadoLoader=true;
			Rubrica.obtenerRubricasPorPersona(semestre)
				.success(function(data){
					$scope.Formulario.paginacionMisRubricas.datos = data.misRubricas;
					$scope.Formulario.paginacionRubricasAsignadas.datos = data.rubricasAsignadas;
					if(!$scope.Formulario.semestres){
						$scope.Formulario.semestres = data.semestres;
						$scope.Formulario.seleccionarSemestreActivo($scope.Formulario.semestres);
					}
					$scope.Formulario.paginacionRubricasAsignadas.callBackBuscar("");
					$scope.Formulario.paginacionMisRubricas.callBackBuscar("");
					$scope.loader.estadoLoader = false;
				});

		};



		$scope.EstaRubricasCreadas = false;

		$scope.Formulario = {
			paginacionMisRubricas : {
				totalRegistros : 1,
				paginaActual : 1,
				nroRegistrosPorPagina : 10,
				datosConFiltro : [],
				datos : [],
				datosParaMostrar : [],
				callBackBuscar : function(busqueda){
					Paginacion.callBackBuscar(busqueda,$scope.Formulario.paginacionMisRubricas);
				},
				cambioPagina : function(page){
					Paginacion.cambioPagina(page,$scope.Formulario.paginacionMisRubricas);
				}
			},
			paginacionRubricasAsignadas : {
				totalRegistros : 1,
				paginaActual : 1,
				nroRegistrosPorPagina : 10,
				datosConFiltro : [],
				datos : [],
				datosParaMostrar : [],
				callBackBuscar : function(busqueda){
					Paginacion.callBackBuscar(busqueda,$scope.Formulario.paginacionRubricasAsignadas);
				},
				cambioPagina : function(page){
					Paginacion.cambioPagina(page,$scope.Formulario.paginacionRubricasAsignadas);
				}
			},
			seleccionarSemestreActivo : function(semestres){
				var cantidadSemestres = semestres.length;
				for(var i=0;i<cantidadSemestres;i++){
					if(semestres[i].Activo=="1"){
						$scope.semestreSeleccionado = semestres[i];
						break;
					}
				}
			},
			callBackCboSemestre : function(semestre){
				$scope.semestreSeleccionado = semestre;
				$scope.obtenerRubricasPorPersona(semestre);
			}

		}

		$scope.Interfaz =	{
			OcultarRubricasAsignadas : function(){
				$scope.EstaRubricasCreadas = true;
			},

			MostrarRubricasAsignadas : function(){
				$scope.EstaRubricasCreadas = false;
			},
			redireccionarNuevo : function(){
				$location.path('/rubricas/nuevo');
			}
		}

		//EJECUCION DE METODOS
		$scope.obtenerRubricasPorPersona();
	});

rubricaApp.controller('verRubricasAsignadasCtrl',
	function verRubricasAsignadasCtrl($scope,Rubrica,$routeParams,$window){
		$scope.resultadoRubricaPorRubricaAsignada = [];
		$scope.idRubricaAsignada = $routeParams.idRubricaAsignada;
		$scope.loader = {
			estadoLoader : true
		};

		$scope.obtenerResultadoRubricaPorRubricaAsignada = function(){
			console.log($routeParams.idRubricaAsignada);
				Rubrica.obtenerResultadoRubricaPorRubricaAsignada($routeParams.idRubricaAsignada)
				.success(function(data){
					$scope.resultadosRubricaPorRubricaAsignada = data;
					$scope.loader.estadoLoader = false;
				});
		};

		$scope.volver = function(){
			$window.history.back();
		};

		$scope.obtenerResultadoRubricaPorRubricaAsignada();
	});

rubricaApp.controller('verRubricasCreadasCtrl',
	function verRubricasCreadasCtrl($scope,Rubrica,$routeParams,$window){
		$scope.resultadoRubricaPorRubricaCreada = [];
		$scope.idRubricaCreada = $routeParams.idRubricaCreada;
		$scope.loader = {
			estadoLoader : true
		};
		$scope.obtenerResultadoRubricaPorRubricaCreada = function(){
			console.log($routeParams.idRubricaAsignada);
				Rubrica.obtenerResultadoRubricaPorRubricaCreada($routeParams.idRubricaCreada)
				.success(function(data){
					$scope.resultadoRubricaPorRubricaCreada = data;
					$scope.loader.estadoLoader = false;
				});
		};

		$scope.volver = function(){
			$window.history.back();
		};

		$scope.obtenerResultadoRubricaPorRubricaCreada();
	});

rubricaApp.controller('completarRubricaCtrl',
	function completarRubricaCtrl($scope,Rubrica,$routeParams,$location,$window){
		$scope.resultadoRubrica = {};
		$scope.resultadoRubricaCompleto = {};
		$scope.idResultadoRubrica = $routeParams.idResultadoRubrica;
		$scope.loader = {
			estadoLoader : true,
			mensajeGuardar : "Guardando la Rubrica ...",
			estadoGuardar : false,
			mensajeGuardado : "Rubrica Guardada!",
			estadoFormulario : true,
			estadoGuardando : false
		};

		$scope.obtenerResultadoRubricaPorId = function(){
			Rubrica.obtenerResultadoRubricaPorId($scope.idResultadoRubrica)
			.success(function(data){
				$scope.resultadoRubrica = data;
				$scope.resultadoRubrica.resultadosAprendizaje = $scope.agrupar($scope.resultadoRubrica.criteriosEvaluacion,"resultadoAprendizaje");
				$scope.loader.estadoLoader = false;
			});
		};


		$scope.completarCuestionario = function(){
			$scope.loader.estadoFormulario = false;
			$scope.loader.estadoGuardando = true;
			$scope.resultadoRubricaCompleto.idResultadoRubrica = $routeParams.idResultadoRubrica;
			$scope.resultadoRubricaCompleto.resultadosAprendizaje = $scope.resultadoRubrica.resultadosAprendizaje;
			Rubrica.completarResultadoRubrica($scope.resultadoRubricaCompleto)
			.success(function(data){
				$scope.loader.estadoGuardar = true;
				$scope.loader.estadoGuardando = false;
			});
		};

		$scope.agrupar = function(array,campo){
			var grupos = [];
			var index = null;
			for(var i=0;i<array.length;i++){
				var item = array[i];
				index = null;
				for(var j=0;j<grupos.length;j++){
					var a = grupos[j][0][campo];
					var b = item[campo];
					if(grupos[j][0][campo]==item[campo]){
						index = j;
						break;
					}
				}
				if(index==null){
					var grupoAux = [];
					grupoAux.push(item);
					grupos.push(grupoAux);
				}else{
					grupos[index].push(item);
				}
				console.log(grupos);
			}
			return grupos;
		};

		$scope.callBackGuardar = function(){
			$window.history.back();
		};

		$scope.calcularTotal = function(resultadoAprendizaje){
			var total=0;
			var nota=0;
			resultadoAprendizaje.forEach(function(criterio){
				if(!criterio.hasOwnProperty('calificacion')){
					return;
				}
				if(!isNaN(criterio.calificacion)){
					total += 1*criterio.calificacion;
				}
			});
			var resultado = total/resultadoAprendizaje.length;
			resultadoAprendizaje.total = resultado.toFixed(2);
			resultadoAprendizaje.nota = $scope.calcularNota(resultadoAprendizaje.total);
		};

		$scope.calcularNota = function(total){
			var resultado = (total*20)/100;
			return resultado.toFixed(2);
		};

		$scope.obtenerResultadoRubricaPorId();

});