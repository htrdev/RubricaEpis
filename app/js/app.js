'use strict';

var rubricaApp = angular.module('rubricaApp', ['ngSanitize','ngRoute','ui.bootstrap','ngAnimate','ui.sortable','htrdev']);

rubricaApp.constant('rutasApp',{
  rutaVistas : 'http://rubricaepis:8080/app/vistas/',
  rutaApi : 'http://rubricaepis:8080/app/modulos/'
});

// URL:
//  =========================
//  para visualizar el sitio debes escribir en la url la siguiente dirección
  
// http://epis.upt.edu.pe/rubrica/

// BD:
// ========================
// Servidor: epis.upt.edu.pe
// BD: rubricaepis
// Usuario: urubrica
// Password: rubrica%789.

// FTP:
//  ========================
// Servidor: epis.upt.edu.pe
// Usuario: urubrica
// Password: Rubric741%
// Index of /rubrica
// epis.upt.edu.pe

rubricaApp.config(function($routeProvider,rutasApp){
    $routeProvider.
      when('/rubricas/nuevo', {
        templateUrl: rutasApp.rutaVistas +'rubrica/nuevo.html',
        controller: 'nuevoRubricaCtrl',
      }).
      when('/rubricas',{
        templateUrl: rutasApp.rutaVistas +'rubrica/index.html',
        controller: 'misRubricasCtrl',
      }).
      when('/rubricas/reporte/:idModeloRubrica',{
        templateUrl: rutasApp.rutaVistas +'rubrica/reporte.html',
        controller: 'reporteRubricaCtrl',
      }).
      when('/rubricas/completar/:idResultadoRubrica',{
        templateUrl: rutasApp.rutaVistas +'rubrica/completar.html',
        controller: 'completarRubricaCtrl'
      }).
      when('/rubricas/asignadas/:idRubricaAsignada',{
        templateUrl: rutasApp.rutaVistas +'rubrica/verRubricasAsignadas.html',
        controller: 'verRubricasAsignadasCtrl',
      }).
      when('/rubricas/misrubricas/:idRubricaCreada',{
        templateUrl: rutasApp.rutaVistas +'rubrica/verRubricasCreadas.html',
        controller: 'verRubricasCreadasCtrl',
      }).
      when('/resultadoAprendizaje/nuevo',{
        templateUrl: rutasApp.rutaVistas +'resultadoAprendizaje/nuevo.html',
        controller:'nuevoResultadoAprendizajeCtrl'
      }).
      when('/resultadoAprendizaje',{
        templateUrl: rutasApp.rutaVistas +'resultadoAprendizaje/index.html',
        controller : 'misResultadosAprendizajeCtrl',
      }).
      when('/',{
        templateUrl: rutasApp.rutaVistas +'bienvenida.html',
      }).
      otherwise({
        redirectTo: '/login',
        templateUrl: rutasApp.rutaVistas +'usuario/login.html',
      });
  });

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