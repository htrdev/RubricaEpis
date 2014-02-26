'use strict';

//DIRECTIVAS REUTILIZABLES

var interfaz = {};

interfaz.btnGuardar = function() {
    return {
      restrict : "E",
      scope : {
        action : "&"
      },
      template : "<div style='text-align:right'><button class='btn btn-success btn-next' ng-click='action()'>Guardar <i class='icon-ok'></i></button></div>",
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
      scope : {
        loader : '='
      },
      template : "<div class='row-fluid loader' ng-if='loader' style='text-align:center;padding-top:1em;font-style:italic'><h4>Cargando Informacion ...<br><br><img src='assets/css/images/loader.gif' style='width:6em;height:1em'></h4></div>"
    }
}

interfaz.gridVacio = function(){
  return {
    restrict : "E",
    transclude : true,
    scope : {
      array : "="
    },
    template : "<div ng-if='!array.length' style='text-align:center;width:100%;font-style:italic' ng-transclude></div>"
  }
}

rubricaApp.directive("linkBorrarItem",interfaz.linkBorrarItem);
rubricaApp.directive("btnAgregar",interfaz.btnGuardar);
rubricaApp.directive("pantallaLoading",interfaz.pantallaLoading);
rubricaApp.directive("gridVacio",interfaz.gridVacio);


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