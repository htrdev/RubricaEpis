'use strict';

/* Filters */

rubricaApp.filter('alumnos',function(){
	return function(alumnos){
		var listaAlumnos ="<ul>";
		alumnos.forEach(function(alumno){
			listaAlumnos += "<li>"+alumno.personaCalificada+"</li>"
		});
		listaAlumnos += "</ul>"
		return listaAlumnos;
	};
});

rubricaApp.filter('estado',function(){
	return function(estado){
		var html="";
		if(estado=="Completado"){
			html +="<span class='label label-success arrowed-in arrowed-in-right'>Completado</span>";
		}
		else{
			html +="<span class='label label-important arrowed-right arrowed-in'>Pendiente</span>";
		}
		return html;
	};
});

rubricaApp.filter('fecha',function(){
	return function(pfecha){
		if(!pfecha){
			pfecha = "No Completado";
		}
		return pfecha;
	};
});

rubricaApp.filter('nota',function(){
	return function(puntaje){
		var resultado = (puntaje*20)/100;
		return puntaje+" / "+resultado.toFixed(2);
	};
})
