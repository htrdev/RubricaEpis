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

interfaz.cuadroConfirmacionBorrar = function(){

  var cuadroMensaje = bootbox.dialog("<h4 class='lighter smaller'>¿Esta seguro que desea borrar este elemento?</h4><hr>"
                        , [{
                        "label" : "Guardar <i class='icon-ok'></i>",
                        "class" : "btn-small btn-success",
                        "callback": function() {
                          callback();
                        }
                        }, {
                        "label" : "Cancelar",
                        "class" : "btn-small btn-danger",
                        "callback": function() {
                          //Example.show("uh oh, look out!");
                        }
                        }]);
}

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

