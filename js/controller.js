var app = angular.module('MyFirstApp', []);
app.controller('FirstController', function($scope, $http){
	$scope.personas = [];
	
	$http({
      method: 'GET',
	  //http://104.130.47.10/sistema/api/v1/getListadoPermisos.php
      url: '../../api/v1/getListadoPermisos.php'
   }).then(function (response){
		//console.log(response);
		$scope.personas = response.data.result;
		//console.log($scope.personas);
		t_s();
   },function (error){

   });
   
  	$http({
      method: 'GET',
	  //http://104.130.47.10/sistema/api/v1/permisos/getPermisosUsuario.php
      url: '../../api/v1/permisos/getPermisosUsuario.php'
   }).then(function (response){
		//console.log(response);
		$scope.dataUser = response.data;
		//console.log($scope.dataUser);
		//t_s();
   },function (error){

   }); 
       
   
   $scope.getClassPermission= function(permissionValue){
     if(permissionValue==1)
            return "btn-allow"
     else
         return "btn-deny";
    }
  
   $scope.changeState= function( e, state, permision_id, user_id ){
	 
	 if($(e.currentTarget).hasClass("btn-allow"))
		return allowPermission( e, permision_id, user_id );
     else
		return denyPermission( e, permision_id, user_id );
    }
	
	
	function allowPermission( e, permision_id, user_id ){
	
	
		 	swal({
		title: "Confirmacion",
		text: "¿Esta seguro que desea cambiar el estado del permiso?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Cambiar',
		cancelButtonText: "Cancelar",
		closeOnConfirm: false,
		closeOnCancel: true
	},
	function(isConfirm){
    if (isConfirm){
		showDeny( e );
		console.log('Allow: User => '+user_id + ', Permission => ' + permision_id);
		sendDenyPermission( permision_id, user_id );
      swal("Cambiado", "El permiso cambio correctamente", "success");
    } else {
      //swal("Cancelled", "Your imaginary file is safe :)", "error");
    }
	});
	
	
	
	return 1;
}

function showDeny( e ){
	 $(e.currentTarget).removeClass( "btn-allow" );
	 $(e.currentTarget).addClass( "btn-deny" );
}

function showAllow( e ){
	$(e.currentTarget).addClass( "btn-allow" );
	$(e.currentTarget).removeClass( "btn-deny" );
}

function sendAllowPermission( permision_id, user_id ){
	console.log('Allow: User => '+user_id + ', Permission => ' + permision_id);
	
	$http({
		  method: 'POST',
		  url: '../../api/v1/permission_allow.php?ids='+user_id+'&prs='+permision_id,
		  data: {					
		  }
	   }).then(function (response){
			console.log(response);
			//$scope.personas.push($scope.newPersona);
			//$scope.newPersona = {};
	   },function (error){
			console.log(error);
	   });
}

function denyPermission( e, permision_id, user_id ){
	//console.log('Deny: User => '+user_id + ', Permission => ' + permision_id);
	
			 	swal({
		title: "Confirmacion",
		text: "¿Esta seguro que desea cambiar el estado del permiso?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Cambiar',
		cancelButtonText: "Cancelar",
		closeOnConfirm: false,
		closeOnCancel: true
	},
	function(isConfirm){
    if (isConfirm){
		showAllow( e );
		console.log('Deny: User => '+user_id + ', Permission => ' + permision_id);
		sendAllowPermission( permision_id, user_id );
        swal("Cambiado", "El permiso cambio correctamente", "success");
    } else {
      //swal("Cancelled", "Your imaginary file is safe :)", "error");
    }
	});
	
	
	
	return 0;
}

function sendDenyPermission( permision_id, user_id ){
	//console.log('Deny: User => '+user_id + ', Permission => ' + permision_id);
	
		$http({
		  method: 'POST',
		  url: '../../api/v1/permission_deny.php?ids='+user_id+'&prs='+permision_id,
		  data: {					
		  }
	   }).then(function (response){
			console.log(response);
			//$scope.personas.push($scope.newPersona);
			//$scope.newPersona = {};
	   },function (error){
			console.log(error);
	   });
	
}

function ajax( url, datos ){

/*$http({
		  method: 'POST',
		  url: 'api.php?url=crearPersona',
		  data: {
					nombre: $scope.newPersona.nombre,
					sexo: $scope.newPersona.sexo
					//userId: 1
		  }
	   }).then(function (response){
			console.log(response);
			$scope.personas.push($scope.newPersona);
			$scope.newPersona = {};
	   },function (error){
			console.log(error);
	   });*/
}
	
	
	
});

