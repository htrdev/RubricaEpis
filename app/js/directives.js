'use strict';

var interfaz = {};

interfaz.btnAgregar = function() {
    return {
      restrict : "E",
      scope : {
        action : "&"
      },
      template : "<button class='btn btn-success btn-next' ng-click='action()'>Guardar<i class='icon-ok'></i></button"
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

rubricaApp.directive("btnAgregar", function(){
  return {
      restrict : "E",
      scope : {
        action : "&"
      },
      template : "<div style='text-align:right'><button class='btn btn-success btn-next' ng-click='action()'>Guardar<i class='icon-ok'></i></button></div>"
    }
});

rubricaApp.directive("linkBorrarItem",interfaz.linkBorrarItem);

