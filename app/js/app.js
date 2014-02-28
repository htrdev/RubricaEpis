'use strict';

var rubricaApp = angular.module('rubricaApp', ['ngSanitize','ngRoute','ui.sortable','ngAnimate','ui.bootstrap.pagination']);
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
        controller: 'misRubricasCtrl',
      }).
      when('/rubricas/:idRubrica/completar',{
        templateUrl: urlServidor+'vistas/rubrica/ListarEstadoRubrica.html',
        controller: 'listarEstadoRubricaCtrl',
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