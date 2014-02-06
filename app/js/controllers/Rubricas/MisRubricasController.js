'use strict';


rubricaApp.controller('MisRubricasController',
	function MisRubricasController($scope,Usuario)
	{
		$scope.rubricasCreadas = [
		{id:1,semestre:"2013-EXT",curso:"Sistemas Operativos I",califica:"Alumnos",fechaInicio:"12-12-12",fechaFinal:"15-12-12"},
		{id:2,semestre:"2013-EXT",curso:"Programacion III",califica:"Alumnos",fechaInicio:"12-12-12",fechaFinal:"17-12-12"},
		];

		$scope.rubricasAsignadas = [
		{id:3,semestre:"2013-EXT",curso:"Diseño y Arquitectura de Software",califica:"Alumnos",autor:"MARTINEZ PEÑALOZA, MINELLY YSABEL",fechaFinal:"15-12-12"},
		{id:1,semestre:"2013-EXT",curso:"Sistemas Operativos I",califica:"Alumnos",autor:"LANCHIPA VALENCIA, ENRIQUE FELIX",fechaFinal:"15-12-12"},
		{id:5,semestre:"2013-EXT",curso:"Diseño de Base de Datos",califica:"Alumnos",autor:"CHAIÑA CONDORI, HENRY WILSON",fechaFinal:"15-12-12"},
		{id:4,semestre:"2013-EXT",curso:"Programacion Lineal",califica:"Alumnos",autor:"SISA YATACO, HAYDEE RAQUEL",fechaFinal:"15-12-12"},
		{id:2,semestre:"2013-EXT",curso:"Programacion III",califica:"Alumnos",autor:"LANCHIPA VALENCIA, ENRIQUE FELIX",fechaFinal:"15-12-12"},
		];

		$scope.EstaRubricasCreadas = true;

		$scope.Interfaz =	{
			OcultarRubricasAsignadas : function(){
				$scope.EstaRubricasCreadas = true;
				Usuario.listarUsuarios();
			},

			MostrarRubricasAsignadas : function(){
				$scope.EstaRubricasCreadas = false;
				Usuario.listarUsuarios();
			},
			alert1 : function(){
				alert("Aqui deberia mandarme al formulario similar al Crear Rubrica pero listo para editar esta Rubrica");
			},
			alert2 : function(){
				alert("Aqui me mostrara otro grid donde me mostrara todas las veces que he llenado esta rubrica pero en diferentes alumnos")
			},
			alert3 : function(){
				alert("Aqui me mostrara el formulario para llenar esta Rubrica hacia determinado alumno");
			}
		}

		Usuario.listarUsuarios();

		
	});