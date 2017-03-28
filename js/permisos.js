var app = angular.module('puestosApp', ["xeditable"]);

app.run(function(editableOptions) {
  editableOptions.theme = 'bs3'; // bootstrap3 theme. Can be also 'bs2', 'default'
});

app.controller('PuestoCntroller', function($scope, $http){

	$scope.miembros = [];
	$scope.formData = {};
	$scope.catGrupos = [];
	$scope.catPags = [];
	
	$scope.pages = 0;
	$scope.noPage = 0;
	$scope.nameSearch = '';
	
	$scope.groups = [];
	$scope.pags = [];
	
	$scope.getDataAddPermiso = function(){
	
			$http({
			  method: 'GET',
			  url: '../api/index.php?url=getDataAddPermiso'
		   }).then(function (response){
				console.log(response.data);
				$scope.catGrupos = response.data.catGrupos;
				$scope.catPags = response.data.catPags;		
				
				console.log($scope.catGrupos);
				//console.log($scope.catClaves);
				
		   },function (error){

		   });
	}
	
   $scope.submitAddPermiso = function( formValid ){
   //console.log('form valid?: ', formValid);
   
	if(formValid)
		{
			$('#btnSubmitAddPermiso').attr('disabled',true);
			$http({
			  method: 'POST',
			  url: '../api/index.php?url=addPermiso',
			  data: $scope.formData
		   }).then(function (response){
				console.log(response);
				$scope.formData = {};
				load( $scope.noPage , $scope.nameSearch );
				//load(1);
				
				$('#modalAddPermiso').modal('toggle');
				alert('Se guardo exitosamente.');
				$('#btnSubmitAddPermiso').attr('disabled',false);
				
		   },function (error){
				console.log(error);
		   });
		}
   }

  $scope.loadGroups = function() {
    return $scope.groups.length ? null : $http.get('../api/index.php?url=getGroupsPermisos').success(function(data) {
      $scope.groups = data.groups;
    });
  };

  $scope.$watch('user.group', function(newVal, oldVal) {
    if (newVal !== oldVal) {
      var selected = $filter('filter')($scope.groups, {id: $scope.user.group});
      $scope.user.groupName = selected.length ? selected[0].text : null;
    }
  });
	
	
	$scope.loadPags = function( row ) { console.log(row);
    return $scope.pags.length ? null : $http.get('../api/index.php?url=getPagsPermisos').success(function(data) {
      $scope.pags = data.pags;
	  
	  console.log($scope.pags);
	  
    });
  };

  $scope.$watch('user.pag', function(newVal, oldVal) {
    if (newVal !== oldVal) {
      var selected = $filter('filter')($scope.pags, {id: $scope.user.pag});
      $scope.user.pagName = selected.length ? selected[0].text : null;
    }
  });
	
	//Cargar primera pagina de registros
	load(1);
   
   $scope.load= function( page, nameSearch ){
		load( page, nameSearch );
   }


	$scope.updateDetalle = function(row) {
		console.log('updateUser');
		$scope.formData = row;
		console.log($scope.formData);
		console.log($scope.formData.permiso_detalles);
		return $http.post('../api/index.php?url=updateDetallesPermiso', $scope.formData);
	};
	
	$scope.updateGroup = function(row) {
		//console.log('updateGroup');
		$scope.formData = row;
		var id = $scope.formData.group;
		
		angular.forEach($scope.groups, function(value, key) {
			if( id == value.id_grupo )
				row.groupName = value.grupo;
		});
		
		$http.post('../api/index.php?url=updateGrupoPermiso', $scope.formData);
		return 1;
	};

	$scope.updatePagina = function(row) {
		console.log('updatePagina');
		$scope.formData = row;
		var id_pagina = $scope.formData.id_pagina;
		
		$http({
			  method: 'GET',
			  url: '../api/index.php?url=getGroupPage&id_pagina='+id_pagina
		   }).then(function (response){
				var id = $scope.formData.id_pagina;
				row.groupName = response.data.grupoPage
;
				angular.forEach($scope.pags, function(value, key) {
					if( id == value.id_pagina )
						row.pagina = value.pagina;
					});
				
				$http.post('../api/index.php?url=updatePaginaPermiso', $scope.formData);
				
		   },function (error){

		   });
		
		
		
		return 1;
	};
	
function load( page, nameSearch ){

		$scope.noPage = page;
		
		if( page > 0 ){   
			$http({
			  method: 'GET',
			  url: '../api/index.php?url=getCatPermisos&page='+page+'&n='+nameSearch
		   }).then(function (response){
				$scope.miembros = [];
				$scope.pages = [];
				
				
				
				$scope.miembros = response.data.miembros.registros;
				//console.log(response.data.miembros.registros.registros);
				
				var page = parseInt(response.data.miembros.page);
				var adjacents = parseInt(response.data.miembros.adjacents);
				var tpages = parseInt(response.data.miembros.noPages);
				
				//console.log(tpages);
				
				pages = getPage( page, adjacents, tpages );
				$scope.pages = pages;
				
		   },function (error){

		   });
	   }
}
   
   
      function getPage( page, adjacents, tpages ){
   
		var pages = [];
		var pmin = ( page > adjacents) ? ( parseInt(page) - parseInt(adjacents)) : 1;
		var pmax = ( page < ( tpages - adjacents ) ) ? ( parseInt(page) + parseInt(adjacents) ) : parseInt(tpages);
		
		//console.log('page: '+ page+', adjacents: '+adjacents+', tpages: '+tpages+', pmin: '+pmin+',pmax: '+ pmax);
		
		var prevlabel = "< Anterior";
		var nextlabel = "Siguiente >";	

		// previous label
		if( page == 1)
			pages.push({label: prevlabel, page:-1});
		else if( page == 2 )
			pages.push({label: prevlabel, page:1});
		else
			pages.push({label: prevlabel, page: (page-1) });

		// first label
		if( page > ( adjacents + 1 ) )
			pages.push({label: 1, page: 1 });
		// interval
		if( page > ( adjacents + 2 ) )
			pages.push({label: '...', page: -2 });

		// pages
		for ( i = pmin; i <= pmax; i++) { 
			if( i == page )
				pages.push({label: i, page:0});
			else if( i == 1 )
				pages.push({label: i, page:1});
			else
				pages.push({label: i, page:i});
		}
		
		// interval
		if( page < ( tpages - adjacents - 1 ) )
			pages.push({label: '...', page:-2});

			
		// last
		if( page < ( parseInt(tpages) - parseInt(adjacents) ) )
			pages.push({label: tpages, page: tpages});

		// next
		if( page < tpages )
			pages.push( {label: nextlabel, page: ( page + 1 ) } );
		else
			pages.push( {label: nextlabel, page: -1 } );
		
		//console.log(pages);
		
		return pages;
   }
     
	$scope.classPage= function( type ){
		var classess = 'btn_paginador';
	
		if( type == 0 )
			classess += ' active';
		else if( type == -1 )
			classess += ' disabled';
		else if( type == -2 )
			classess += '';
	
		return classess;
	}
   
   
});