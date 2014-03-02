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
      template : "<button class='btn btn-prev' ng-click='action()'><span ng-transclude> </span><i class='icon-arrow-left'></i></button>",
     };
};

interfaz.btnSiguiente = function() {
    return {
      restrict : "E",
      transclude : true,
      scope : {
        action : "&"
      },
      template : "<button class='btn btn-primary btn-next' ng-click='action()'><span ng-transclude> </span><i class='icon-arrow-right'></i></button>",
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
  var cuadroMensaje = function(callback){
                        bootbox.dialog("<h4 class='lighter smaller'>¿Esta seguro que desea borrar este elemento?</h4><hr>"
                        , [{
                        "label" : "Si <i class='icon-ok'></i>",
                        "class" : "btn-small btn-success",
                        "callback": function() {
                          callback();
                        }
                        }, {
                        "label" : "No",
                        "class" : "btn-small btn-danger",
                        "callback": function() {
                          //Example.show("uh oh, look out!");
                        }
                        }]);
                      };
  return {
    restrict : 'E',
    scope : {
      action : "&"
    },
    template : "<a class='blue' cuadro-confirmacion-borrar><i class='icon-zoom-in bigger-130' ng-click='action'></i></a>"
  }
};

interfaz.pantallaLoading = function(){
    return {
            restrict : "E",
            transclude : true,
            scope : {
              loader : '='
            },

            template : "<div class='row-fluid animate' ng-if='loader.estadoLoader' style='text-align:center;padding-top:1em;font-style:italic'><h4><span ng-transclude></span><br><br><img src='assets/css/images/loader.gif' style='width:6em;height:.5em'></h4></div>"
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
rubricaApp.directive("fecha",interfaz.fecha);

rubricaApp.directive("cmbChosen", function(){
  var linker = function(scope,element,attrs){
     scope.$watch(attrs.elementos,function(){
        element.trigger('liszt:updated');
      });
     element.chosen({width:'90%'});
  };
  return {
    restrict : 'A',
    link : linker
  }
});