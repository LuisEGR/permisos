permisos.controller("permisosController",  ['$scope','$rootScope','$http','$interval', '$mdDialog','$timeout','$filter', function($scope,$rootScope, $http, $interval,$mdDialog,$timeout,$filter){
  console.log("hey!");
  $scope.asd  = "asdasdasd";
  $scope.intervalDisplacement;
  $scope.posicionActual = 0;
  $scope.desplazar = function(dir){
    var $users = $("#usuarios-cont-movible");
    var $asignaciones = $("#permisos_asignados");
    var totalDesplazable = 150;
    if(dir == 0){//izq
        $scope.intervalDisplacement = $interval(function(){
          if($scope.posicionActual > 20){
            $users.animate({left: "+=20",}, 100, function(){ $scope.posicionActual -= 20; });
            $asignaciones.animate({left: "+=20",}, 100, function(){ });
            console.log("Desplazando usuarios a la izquierda");
          }else{
            $interval.cancel(  $scope.intervalDisplacement );
          }
        }, 100);
    }else{//der
      $scope.intervalDisplacement = $interval(function(){
        if($scope.posicionActual < totalDesplazable){
          console.log("Desplazando a la derecha");
          $users.animate({left: "-=20",}, 100, function(){ $scope.posicionActual += 20; });
          $asignaciones.animate({left: "-=20",}, 100, function(){});
        }else{
          $interval.cancel(  $scope.intervalDisplacement );
        }
      }, 100);
    }
  }
  $scope.detenerDesplazamiento = function(){
    $interval.cancel(  $scope.intervalDisplacement);
  }

}]);
