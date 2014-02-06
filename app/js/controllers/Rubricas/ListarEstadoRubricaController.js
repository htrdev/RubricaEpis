'use strict';


rubricaApp.controller('ListarEstadoRubricaController',
	function ListarEstadoRubricaController($scope,$location,$routeParams)
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