var htrdev = angular.module('htrdev',[]);

htrdev.factory('Paginacion',function($filter){
	var factory = {};

	factory.callBackBuscar = function(busqueda,paginacion){
		paginacion.datosConFiltro = $filter('filter')(paginacion.datos,busqueda);
	    paginacion.totalRegistros = paginacion.datosConFiltro.length;
	    paginacion.paginaActual = 1;
	    factory.cambioPagina(paginacion.paginaActual,paginacion);
	};

	factory.cambioPagina = function(page,paginacion){
		var inicio = paginacion.nroRegistrosPorPagina*(page-1);
		var indiceFinal = paginacion.nroRegistrosPorPagina*page;
		paginacion.datosParaMostrar = [];
		if(paginacion.datosConFiltro.length===0){
		}else{
			for(var i=inicio;i<indiceFinal;i++){
				if(i==paginacion.totalRegistros-1){
					paginacion.datosParaMostrar.push(paginacion.datosConFiltro[i]);
					break;							
				}
				paginacion.datosParaMostrar.push(paginacion.datosConFiltro[i]);
			}
		}
		
	};

	return factory;
});
