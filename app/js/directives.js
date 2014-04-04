'use strict';

//DIRECTIVAS REUTILIZABLES

var interfaz = {};

interfaz.btnGuardar = function() {
    return {
      restrict : "E",
      transclude : true,
      scope : {
        action : "&"
      },
      template : "<button class='btn btn-success' ng-click='action()'><span ng-transclude> </span><i class='icon-ok'></i></button>",
     };
};

interfaz.btnAtras = function() {
    return {
      restrict : "E",
      transclude : true,
      scope : {
        action : "&"
      },
      template : "<button style='float:right' class='btn btn-prev' ng-click='action()'></span><i class='icon-arrow-left'><span style='margin-left:5px' ng-transclude></i></button>",
     };
};

interfaz.btnSiguiente = function() {
    return {
      restrict : "E",
      transclude : true,
      scope : {
        action : "&"
      },
      template : "<button style='float:right' class='btn btn-info btn-next' ng-click='action()'><span ng-transclude style='margin-right:5px'> </span><i class='icon-arrow-right'></i></button>",
     };
};

interfaz.grupoBotones = function() {
    return {
      restrict : "E",
      transclude : true,
      scope : {
        action : "&"
      },
      template : "<br><div class='row-fluid' style='text-align:right;margin-top:2em;margin-right:2em' ng-transclude></div>"
     };
};

interfaz.linkBorrarItem = function(){

  return {
    restrict : 'E',
    scope : {
      action : "&"
    },
    template : "<a class='blue' cuadro-confirmacion-borrar><i class='icon-remove bigger-130 red' ng-click='action'></i></a>"
  }
};

interfaz.pantallaLoading = function(){
    return {
            restrict : "E",
            transclude : true,
            scope : {
              loader : '='
            },

            template : "<div class='row-fluid' ng-if='loader.estadoLoader' style='text-align:center;padding-top:1em;font-style:italic'><h4><span ng-transclude></span><br><br><img src='assets/css/images/loader.gif' style='width:6em;height:.5em'></h4></div>"
          };
  
};

interfaz.pantallaGuardarLoading = function(){
    return {
            restrict : "E",
            transclude : true,
            scope : {
              loader : '='
            },

            template : "<div class='row-fluid' ng-if='loader.estadoGuardando' style='text-align:center;padding-top:1em;font-style:italic'><h4><span ng-transclude></span><br><br><img src='assets/css/images/loader.gif' style='width:6em;height:.5em'></h4></div>"
          };
  
};

interfaz.pantallaGuardarExitoso = function(){
  return {
          restrict : "E",
          transclude : true,
          scope : {
            loader : '=',
            action : '&'
          },
          template : "<div class='row-fluid' ng-if='loader.estadoGuardar' style='text-align:center;padding-top:1em;font-style:italic'><h4><span ng-transclude></span><br><br><button class='btn btn-success' ng-click='action()'>Aceptar <i class='icon-ok'></i></button></h4></div>"
        };
};

interfaz.pantallaLoadingShow = function(){
    return {
      restrict : "E",
      transclude : true,
      scope : {
        loader : '='
      },
      template : "<div class='row-fluid loader' ng-show='loader.estado' style='text-align:center;padding-top:1em;font-style:italic'><h4><span ng-transclude></span><br><br><img src='assets/css/images/loader.gif' style='width:6em;height:.5em'></h4></div>"
    }
};

interfaz.gridVacio = function(){
  return {
    restrict : "E",
    transclude : true,
    scope : {
      array : "="
    },
    template : "<div ng-if='!array.length' style='text-align:center;width:100%;font-style:italic' ng-transclude></div>"
  }
};

interfaz.fecha = function(){
  return {
    restrict: 'A',
    link : function(scope,element,attrs){
      element.datepicker({
        format : 'dd/mm/yyyy',
        language: "es"
      });
    }
  }
}

rubricaApp.directive("linkBorrarItem",interfaz.linkBorrarItem);
rubricaApp.directive("btnGuardar",interfaz.btnGuardar);
rubricaApp.directive("pantallaLoading",interfaz.pantallaLoading);
rubricaApp.directive("gridVacio",interfaz.gridVacio);
rubricaApp.directive("btnAtras",interfaz.btnAtras);
rubricaApp.directive("btnSiguiente",interfaz.btnSiguiente);
rubricaApp.directive("grupoBotones",interfaz.grupoBotones);
rubricaApp.directive("pantallaLoadingShow",interfaz.pantallaLoadingShow);
rubricaApp.directive("pantallaGuardarExitoso",interfaz.pantallaGuardarExitoso);
rubricaApp.directive("pantallaGuardarLoading",interfaz.pantallaGuardarLoading);
rubricaApp.directive("fecha",interfaz.fecha);

rubricaApp.directive("cmbChosen", function(){
  var linker = function(scope,element,attrs){
     scope.$watch(attrs.elementos,function(){
        element.trigger('liszt:updated');
      });
     scope.$watch(attrs.ngModel,function(){
        element.trigger('liszt:updated');
     })
     element.chosen({width:'100%'});
  };
  return {
    restrict : 'A',
    link : linker
  }
});

rubricaApp.directive('dxChart',function(){
    return {
      restrict:'A',
      link : function(scope,element,attrs){
        scope.$watch(attrs.data,function(newValue,oldValue){
            $(element).dxChart({
            dataSource: newValue,
            commonSeriesSettings: {
                argumentField: "resultadoAprendizaje"
            },
            series: [
                { valueField: "reporte1", name: "Reporte" }
                // { valueField: "americas", name: "Americas" },
                // { valueField: "africa", name: "Africa" }
            ],
            argumentAxis:{
                grid:{
                    visible: true
                }
            },
            tooltip:{
                enabled: true
            },
            title: "Reporte Resumen Resultados Rubrica : "+attrs.titulo,
            legend: {
                verticalAlignment: "bottom",
                horizontalAlignment: "center"
            },
            commonPaneSettings: {
                border:{
                    visible: true,
                    right: false
                }       
            }
          });
        });
      }
    }
});

rubricaApp.directive('chart', function () {
    var baseWidth = 600;
    var baseHeight = 400;

    return {
      restrict: 'E',
      template: '<canvas></canvas>',
      scope: {
        chartObject: "=value"
      },
      link: function (scope, element, attrs) {
        var canvas  = element.find('canvas')[0],
            context = canvas.getContext('2d'),
            chart;

        var options = {
          type:   attrs.type   || "Line",
          width:  attrs.width  || baseWidth,
          height: attrs.height || baseHeight
        };
        canvas.width = options.width;
        canvas.height = options.height;
        chart = new Chart(context);

        scope.$watch(function(){ return element.attr('type'); }, function(value){
          if(!value) return;
          options.type = value;
          var chartType = options.type;
          chart[chartType](scope.chartObject.data, scope.chartObject.options);
        });

        //Update when charts data changes
        scope.$watch(function() { return scope.chartObject; }, function(value) {
          if(!value) return;
          var chartType = options.type;
          chart[chartType](scope.chartObject.data, scope.chartObject.options);
        });
      }
    }
  });