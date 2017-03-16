var app = angular.module('logsApp', []);
app.controller('LogsController', function($scope, $http){
	$scope.logsData = [];
	$scope.pages = 0;
	$scope.nameSearch = '';
	
	//console.log(pages);
	
	$http({
      method: 'GET',
      url: '../../../api/v1/permisos/getLogs.php'
   }).then(function (response){
		//console.log(response);
		$scope.logsData = response.data;
		//console.log($scope.logsData.noRegistros);
		
		var page = $scope.logsData.page;
		var adjacents = $scope.logsData.adjacents;
		var tpages = $scope.logsData.noRegistros;
		pages = getPage( page, adjacents, tpages );
		$scope.pages = pages;
		
   },function (error){

   });

   
   $scope.load= function( page ){
	   if( page > 0 ){   
			$http({
			  method: 'GET',
			  url: '../../../api/v1/permisos/getLogs.php?page='+page+'&n='+$scope.nameSearch
		   }).then(function (response){
				$scope.logsData = [];
				$scope.pages = [];		  
				
				//console.log(response);
				$scope.logsData = response.data;
				//console.log($scope.logsData.noRegistros);
				
				var page = parseInt($scope.logsData.page);
				var adjacents = parseInt($scope.logsData.adjacents);
				var tpages = parseInt($scope.logsData.noRegistros);
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
			classess += ' activePage';
		else if( type == -1 )
			classess += ' disabled';
		else if( type == -2 )
			classess += '';
	
		return classess;
	}
   
});