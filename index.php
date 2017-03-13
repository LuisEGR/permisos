<!DOCTYPE html>
<html ng-app="MyFirstApp">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>jQuery Datatables</title>

<link href="http://getbootstrap.com/dist/css/bootstrap.css" rel="stylesheet"/>

<link href="https://cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css" rel="stylesheet"/>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/fixedcolumns/3.2.2/js/dataTables.fixedColumns.min.js"></script>
<link href="https://cdn.datatables.net/fixedcolumns/3.2.2/css/fixedColumns.dataTables.min.css" rel="stylesheet"/>
<link href="css/style.css" rel="stylesheet"/>
  <script src="js/sweetalert-dev.js"></script>
  <link rel="stylesheet" href="css/sweetalert.css">

    <script src="js/angular.js"></script>
	<script src="js/controller.js"></script>
	
	<script>
$(document).ready(function() {
   
} );

function t_s()
{
	//$('#example').hide();
	setTimeout(
  function() 
  {
    tabla()
	//$('#example').show()
	$('#loading').hide();
  }, 2000);
	
}

function tabla(){
	 var table = $('#example').DataTable( {
        scrollY:        "700px",
        scrollX:        true,
        scrollCollapse: true,
        paging:         true,
        fixedColumns:   {
            leftColumns: 2//Le indico que deje fijas solo las 2 primeras columnas
        }
    } );
	//$('body').hide().show(0);
	//$('.dataTables_info'.css('margin-top', ': 100px');
	//$('.dataTables_info'.css('dataTables_paginate', ': 100px')
	$('.paginate_button').eq(2).click()
	$('.paginate_button').eq(1).click()
}
	</script>
	
</head>
<body ng-controller="FirstController">

<h1>Administrador de Permisos</h1>

<br><br><br>

<div style='text-align: center;'>
<img id='loading' src = 'images/loading.gif'; style=''>
</div>
<table id="example" class="table-bordered table-striped ">
  <thead>
    <tr>
      <th rowspan="2">Id</th>
      <th rowspan="2">
        <div style="width:200px!Important;">
          Nombre
        </div>
      </th>
      
    </tr>
    <tr>
        <th ng-repeat="p in personas">{{p.permiso_detalles}} - {{p.permiso_id}}</th>

	  
    </tr>
  </thead>
  <tbody>
  
	<tr ng-repeat="du in dataUser">
		<td>{{du.userid}}</td>
		<td>{{du.nombre}}</td>
		<td ng-repeat="d in du.permissionUser ">
			<a class="btn pull-right" ng-class="getClassPermission(d.val)" ng-click="changeState( $event, d.val, d.permision_id, du.userid);"></a>
		</td>
	</tr>
  
    
  </tbody>
</table>
     
</body>
</html>