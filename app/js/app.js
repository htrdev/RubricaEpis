'use strict';

var rubricaApp = angular.module('rubricaApp', ['ngSanitize','ngRoute','ui.sortable']);
var urlServidor = "http://rubricaepis:8080/app/";

rubricaApp.config(['$routeProvider',
  function($routeProvider) {
    $routeProvider.
      when('/CrearRubrica', {
        templateUrl: urlServidor+'vistas/Rubricas/CrearRubrica.html',
        controller: 'CrearRubricaController'
      }).
      when('/MisRubricas',{
        templateUrl: urlServidor+'vistas/Rubricas/MisRubricas.html',
        controller: 'MisRubricasController'
      }).
      when('/MisRubricas/:idRubrica/ListarEstadoRubrica',{
        templateUrl: urlServidor+'vistas/Rubricas/ListarEstadoRubrica.html',
        controller: 'ListarEstadoRubricaController'
      }).
      when('/ResultadosAprendizaje/Crear',{
        templateUrl: urlServidor+'vistas/ResultadoAprendizaje/CrearResultadoAprendizaje.html'

      }).
      when('/ResultadosAprendizaje',{
        templateUrl: urlServidor+'vistas/ResultadoAprendizaje/ListarResultadoAprendizaje.html',
        controller : 'ListarResultadoAprendizajeController'
      }).
      otherwise({
        redirectTo: '/',
        //templateUrl: urlServidor+'vistas/Usuario/Login.html'
      });
  }]);

//DIRECTIVA PARA EL CHZN-SELECT Y EL NG-REPEAT
//REVISA SI RENDERIZA TODO Y LUEGO EJECUTA
/*rubricaApp.directive("complete", function($timeout){
  return {
    restrict: "A",
    link: function($scope, element){
      $timeout(function(){
        $('.chzn-select').chosen();
      }, 0)
    }
  }
});*/

rubricaApp.directive("chosenCiclos", function(){
  var linker = function(scope,element,attr){
     scope.$watch('ciclos',function(){
        element.trigger('liszt:updated');
      })
     element.chosen({width:'80%'});
  };

  return {
    restrict : 'A',
    link : linker
  }
});

rubricaApp.directive("chosenCursos", function(){
  var linker = function(scope,element,attr){
      scope.$watch('cursos',function(){
        element.trigger('liszt:updated');
      })
      element.chosen({width:'80%'});
  };

  return {
    restrict : 'A',
    link : linker
  }
});

rubricaApp.directive("chosenDocentes", function(){
  var linker = function(scope,element,attr){
      scope.$watch('docentes',function(){
        element.trigger('liszt:updated');
        
      })
      element.chosen({width:'80%'});
  };

  return {
    restrict : 'A',
    link : linker
  }
});

rubricaApp.directive("chosenResultados", function(){
  var linker = function(scope,element,attr){
      scope.$watch('resultadosAprendizaje',function(){
        element.trigger('liszt:updated');
      })
      element.chosen({width:'100%'});
  };

  return {
    restrict : 'A',
    link : linker
  }
});

rubricaApp.directive("tabla", function(){
  return function(scope,element,attr){
    

    scope.$watch(scope.rubricasCreadas,function(value){
          dataTable.fnClearTable();
          dataTable.fnAddData(scope.rubricasCreadas[0]);
          console.log(scope.rubricasCreadas[0]);
      })
    var dataTable = element.dataTable( {
        "aoColumns": [
            "Semestre", "Curso","Califica", "FechaInicio", "FechaFinal"
        ]
         } );
  }

});


