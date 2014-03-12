'use strict';

var rubricaApp = angular.module('rubricaApp', ['ngSanitize','ngRoute','ui.sortable','ngAnimate']);
var urlServidor = "http://rubricaepis:8080/app/";

rubricaApp.config(['$routeProvider','$locationProvider',
  function($routeProvider) {
    $routeProvider.
      when('/rubricas/nuevo', {
        templateUrl: urlServidor+'vistas/rubrica/nuevo.html',
        controller: 'nuevoRubricaCtrl',
      }).
      when('/rubricas',{
        templateUrl: urlServidor+'vistas/rubrica/index.html',
        //templateUrl:urlServidor+'vistas/rubrica/completar.html',
        controller: 'misRubricasCtrl',
      }).
      when('/rubricas/completar/:idResultadoRubrica',{
        templateUrl: urlServidor+'vistas/rubrica/completar.html',
        controller: 'completarRubricaCtrl'
      }).
      when('/rubricas/asignadas/:idRubricaAsignada',{
        templateUrl: urlServidor+'vistas/rubrica/verRubricasAsignadas.html',
        controller: 'verRubricasAsignadasCtrl',
      }).
      when('/rubricas/misrubricas/:idRubricaCreada',{
        templateUrl: urlServidor+'vistas/rubrica/verRubricasCreadas.html',
        controller: 'verRubricasCreadasCtrl',
      }).
      when('/resultadoAprendizaje/nuevo',{
        templateUrl: urlServidor+'vistas/resultadoAprendizaje/nuevo.html',
        controller:'nuevoResultadoAprendizajeCtrl'
      }).
      when('/resultadoAprendizaje',{
        templateUrl: urlServidor+'vistas/resultadoAprendizaje/index.html',
        controller : 'misResultadosAprendizajeCtrl',
      }).
      when('/',{
        templateUrl: urlServidor+'vistas/bienvenida.html',
      }).
      otherwise({
        redirectTo: '/login',
        templateUrl: urlServidor+'vistas/usuario/login.html',
      });
  }]);

rubricaApp.config(function ($httpProvider) {
  $httpProvider.defaults.headers.post['Content-Type'] = 'application/json';

  /*
    $httpProvider.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=utf-8';
    $httpProvider.defaults.transformRequest = function(data){
        if (data === undefined) {
            return data;
        }
        return $.param(data);
    }*/
});

rubricaApp.run(['$rootScope', '$location', 'Usuario', function ($rootScope, $location, Usuario) {

    $rootScope.$on('$routeChangeStart', function () {
        if (!Usuario.obtenerUsuario().estado) {
            event.preventDefault();
            $location.path('/login');
        }
    });


}]);