'use strict';

var rubricaApp = angular.module('rubricaApp', ['ngSanitize','ngRoute','ui.sortable','ngCookies']);
var urlServidor = "http://rubricaepis:8080/app/";

rubricaApp.config(['$routeProvider','$locationProvider',
  function($routeProvider) {
    $routeProvider.
      when('/CrearRubrica', {
        templateUrl: urlServidor+'vistas/Rubricas/CrearRubrica.html',
        controller: 'crearRubricaCtrl',
      }).
      when('/MisRubricas',{
        templateUrl: urlServidor+'vistas/Rubricas/MisRubricas.html',
        controller: 'misRubricasCtrl',
      }).
      when('/MisRubricas/:idRubrica/ListarEstadoRubrica',{
        templateUrl: urlServidor+'vistas/Rubricas/ListarEstadoRubrica.html',
        controller: 'listarEstadoRubricaCtrl',
      }).
      when('/ResultadosAprendizaje/Crear',{
        templateUrl: urlServidor+'vistas/ResultadoAprendizaje/CrearResultadoAprendizaje.html',

      }).
      when('/ResultadosAprendizaje',{
        templateUrl: urlServidor+'vistas/ResultadoAprendizaje/ListarResultadoAprendizaje.html',
        controller : 'listarResultadoAprendizajeCtrl',
      }).
      when('/',{
        templateUrl: urlServidor+'vistas/bienvenida.html',
      }).
      otherwise({
        redirectTo: '/IngresarSistema',
        templateUrl: urlServidor+'vistas/Usuario/Login.html',
      });
  }]);

rubricaApp.config(function ($httpProvider) {
    $httpProvider.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=utf-8';
    $httpProvider.defaults.transformRequest = function(data){
        if (data === undefined) {
            return data;
        }
        return $.param(data);
    }
});

rubricaApp.run(['$rootScope', '$location', 'Usuario', function ($rootScope, $location, Usuario) {

    $rootScope.$on('$routeChangeStart', function () {
        if (!Usuario.estaLogeado()) {
            console.log('DENY');
            event.preventDefault();
            $location.path('/IngresarSistema');
        }
        else {
            console.log('ALLOW');
        }
    });


}]);


var verificarEstadoUsuario = function(Usuario){
    if (!Usuario.estaLogeado()) {
        return false;
    }
    else {
        return true;
    }
}

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



