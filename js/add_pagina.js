var app = angular.module('addPuestoApp', []);
app.controller('AddPuestoCntroller', function($scope, $http){
	$scope.formData = {};
	$scope.catGrupos = [];
	$scope.catPags = [];
	
	
	$http({
      method: 'GET',
      url: '../../../api/index.php?url=getDataAddPermiso'
   }).then(function (response){
		console.log(response.data);
		$scope.catGrupos = response.data.catGrupos;
		$scope.catPags = response.data.catPags;		
		
		console.log($scope.catGrupos);
		//console.log($scope.catClaves);
		
   },function (error){

   });
     
	
   $scope.submitForm = function( formValid ){
   //console.log('form valid?: ', formValid);
   
	if(formValid)
		{
			$('#btnSubmit').attr('disabled',true);
			$http({
			  method: 'POST',
			  url: '../../../api/index.php?url=addPagina',
			  data: $scope.formData
		   }).then(function (response){
				console.log(response);
				$scope.formData = {};
				
				alert('Se guardo exitosamente.');
				$('#btnSubmit').attr('disabled',false);
				
		   },function (error){
				console.log(error);
		   });
		}
   }
   
});
