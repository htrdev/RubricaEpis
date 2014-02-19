'use strict';
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
