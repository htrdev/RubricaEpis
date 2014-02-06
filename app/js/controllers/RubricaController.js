'use strict';


rubricaApp.controller('RubricaController',
	function CrearRubricaController($scope)
	{
		$scope.semestre = [
			{
				nombre: '2013-EXT'
			},
			{
				nombre: '2013-II'
			},
			{
				nombre: '2013-II'
			}
		];

		$scope.docentes = [

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
		
		];

		$scope.cursos = [{codigo:'SI-561',nombre:'Diseño y Arquitectura de Software',ciclo:'V'}
						,{codigo:'SI-562',nombre:'Sistemas Operativos I',ciclo:'V'}
						,{codigo:'SI-563',nombre:'Diseño de Base de Datos',ciclo:'V'}
						,{codigo:'SI-564',nombre:'Programacion Lineal',ciclo:'V'}
						,{codigo:'SI-565',nombre:'Programacion III',ciclo:'V'}
						,{codigo:'SI-566',nombre:'Ingenieria Economica de Software',ciclo:'V'}
						,{codigo:'SI-661',nombre:'Aplicaciones Moviles',ciclo:'VI'}
						,{codigo:'SI-662',nombre:'Arquitectura del Computador',ciclo:'VI'}
						,{codigo:'SI-663',nombre:'Gestion de Base de Datos',ciclo:'VI'}
						,{codigo:'SI-664',nombre:'Ingenieria de Software',ciclo:'VI'}
						,{codigo:'SI-665',nombre:'Sistemas Operativos II',ciclo:'VI'}
						,{codigo:'SI-666',nombre:'Gestion de la calidad de Software',ciclo:'VI'}];

		$scope.EstaCuestionario = false;

		$scope.MostrarCuestionario = function(){
			$scope.EstaCuestionario = true;
		};

		$scope.OcultarCuestionario = function(){
			$scope.EstaCuestionario = false;
		};



		$scope.criterios = [];

		$scope.resultadosAprendizaje = [
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
		];

		$scope.Interfaz =	{
			AgregarCriterioSeleccionado : function(criterio){
				if(criterio.estaSeleccionado)
				{
					$scope.criterios.push(criterio);
				}
				else{
					$scope.criterios.splice($scope.criterios.indexOf(criterio),1);
				}
			}
		}
	});