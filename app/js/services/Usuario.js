'use strict';

rubricaApp.factory('Usuario',function($http){
	return	{
		listarUsuarios : function(){
			$http.get('http://rubricaepis:8080/app/clases/Usuario.php').success(function(data){
				
				console.log(data);
			});
		}
	}
});