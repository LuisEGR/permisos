permisos.controller("permisosController",  ['$scope','$rootScope','$http','$interval', '$mdDialog','$timeout','$filter', 'APIPermisos', function($scope,$rootScope, $http, $interval,$mdDialog,$timeout,$filter, APIPermisos){
  // console.log("hey!");
  // $scope.asd  = "asdasdasd";
  $scope.intervalDisplacement;
  $scope.posicionActual = 0;

  $scope.colorsGoups = ["#03a9f4", "#009688", "#00bcd4", "#607d8b", "#3f51b5"];

  $scope.desplazar = function(dir){
    var $users = $("#usuarios-cont-movible");
    var $asignaciones = $("#permisos_asignados");
    var totalDesplazable = $scope.users.ids.length * 15;
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

  $(document).on('mouseover', "#permisos_asignados td", function(ev){
    $(this).parent().css({'background-color': 'rgba(0,0,0,0.1)'});
    $("#totalp1").css({'background-color': 'rgba(0,0,0,0.1)'});
  });

  $(document).on('mouseleave', "#permisos_asignados td", function(ev){
    $(this).parent().css({'background-color': 'rgba(0,0,0,0)'});
    $("#totalp1").css({'background-color': 'rgba(0,0,0,0.1)'});
  });

  $(document).on('mouseover', ".indicador-acceso", function(){
    console.log($(this).data("pid"));
    $("#" + $(this).data("pid") ).css({'background': '#ffeb3b'});
    $("#" + $(this).data("uid") ).css({'background': '#ffeb3b'});
  });

  $(document).on('mouseleave', ".indicador-acceso", function(){
    $("#" + $(this).data('pid') ).css({'background': ''});
    $("#" + $(this).data('uid') ).css({'background': ''});
  });


  (function initSelecter(){
    console.log($("#permisos_asignados td"));
    $("#permisos_asignados td").each(function(el){
      // $(this).addEventLis
      // console.log($(this));
    });
  }());


  $scope.users = [];


  $scope.permisos = [];
  $scope.perids = [];


  var accesosGlobal = [];
  APIPermisos.getAccesos().then(function(d){
    var accesos = d.split("|");
    angular.forEach(accesos, function(a){
      var uid = parseInt(a.split(',')[0]);
      var pid = parseInt(a.split(',')[1]);
      if(angular.isUndefined(accesosGlobal[uid] )) accesosGlobal[ uid ] = [];
      accesosGlobal[uid].push( pid );
    });
    console.log("accesos?: ", accesosGlobal);

    APIPermisos.getPermisos().then(function(d){
      // console.log("Permisos: ", d);
      $scope.permisos = d;
    });

    APIPermisos.getUsers().then(function(d){
      // console.log("Users?: ", d);
      $scope.users = d;
    });
  });


  $scope.tieneAcceso = function(user, permiso){
    return accesosGlobal[user].indexOf(permiso) !== -1;
  }

}]);
