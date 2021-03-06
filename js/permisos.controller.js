permisos.controller("permisosController",  ['$scope','$rootScope','$http','$interval', '$mdDialog','$timeout','$filter', 'APIPermisos', function($scope,$rootScope, $http, $interval,$mdDialog,$timeout,$filter, APIPermisos){
  // console.log("hey!");
  // $scope.asd  = "asdasdasd";
  $scope.intervalDisplacement;
  $scope.posicionActual = 0;
  $scope.usuariosFiltrados = [];
  $scope.colorsGoups = ["#03a9f4", "#009688", "#00bcd4", "#607d8b", "#3f51b5", "#03a9f4", "#009688", "#00bcd4", "#607d8b", "#3f51b5"];


  $scope.limiteInferior = 0;
  $scope.limiteSuperior = 20;
  $scope.desplazar2 = function(dir){
    var totalUsuarios = $scope.users.ids.length;
    if(dir == 0){//izq
      if($scope.limiteInferior >= 20){
        $scope.limiteInferior -= 20;
      }
    }else{//der
      if($scope.limiteInferior >= 0){
        $scope.limiteInferior += 20;
      }
    }
    console.log("LimiteInferior = ", $scope.limiteInferior);
    console.log("LimiteSuperior = ", $scope.limiteSuperior);
  }


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
    $("#permiso" + $(this).data("pid") ).css({'background': '#ffeb3b'});
    $("#user" + $(this).data("uid") ).css({'background': '#ffeb3b'});
  });

  $(document).on('mouseleave', ".indicador-acceso", function(){
    $("#permiso" + $(this).data('pid') ).css({'background': ''});
    $("#user" + $(this).data('uid') ).css({'background': ''});
  });


  (function initSelecter(){
    // console.log($("#permisos_asignados td"));
    $("#permisos_asignados td").each(function(el){
      // $(this).addEventLis
      // console.log($(this));
    });
  }());


  $scope.users = [];


  $scope.permisos = [];
  $scope.perids = [];


  $scope.accesosGlobal = [];
  APIPermisos.getAccesos().then(function(d){
    var accesos = d.split("|");
    angular.forEach(accesos, function(a){
      var uid = parseInt(a.split(',')[0]);
      var pid = parseInt(a.split(',')[1]);
      // if(angular.isUndefined(accesosGlobal[uid] )) accesosGlobal[ uid ] = [];
      // accesosGlobal[uid].push( pid );
      if(angular.isUndefined($scope.accesosGlobal[pid] )) $scope.accesosGlobal[ pid ] = [];
      $scope.accesosGlobal[pid].push( uid );
    });
    // console.log("accesos?: ", accesosGlobal);

    APIPermisos.getPermisos().then(function(d){
      // console.log("Permisos: ", d);
      $scope.permisos = d;
    });

    APIPermisos.getUsers().then(function(d){
      // console.log("Users?: ", d);
      $scope.users = d;
      angular.copy($scope.users, $scope.usuariosFiltrados);
    });
  });


  $scope.tieneAcceso = function(user, permiso){
    // if(angular.isUndefined(accesosGlobal[user])) return false;
    // return accesosGlobal[user].indexOf(permiso) !== -1;
    if(angular.isUndefined($scope.accesosGlobal[permiso])) return false;
    return $scope.accesosGlobal[permiso].indexOf(user) !== -1
  }

  $scope.toggleAccess = function(u,p){
    console.log(u, p);
    if($scope.tieneAcceso(u, p)){
      APIPermisos.deny(u,p).then(function(res){
        console.log(res);
        $("#p" + p + "u" + u).removeClass('has');
      })
    }else{
      APIPermisos.allow(u,p).then(function(res){
        console.log(res);
        $("#p" + p + "u" + u).addClass('has');

      })
    }
  }




  $scope.$watch('filtroUsuarios', function(n,o){
    if(o != n){
      var theLookingIDs = [];
      console.log("Filtrando  Usuarios:::", n, o);
      if(n !== ""){//borrar todos para optimizar la busqueda
        $scope.usuariosFiltrados.users_data.length = 0;
        $scope.usuariosFiltrados.users_data.ids = 0;
      }
      $scope.usuariosFiltrados.users_data = $scope.users.users_data.filter(function(u){
        var toSearchOn = u.nombre + u.nombre_sec + u.apaterno;
        return toSearchOn.toUpperCase().indexOf(n.toUpperCase()) !== -1;
      });
      theLookingIDs = $scope.usuariosFiltrados.users_data.map(function(u){
        return u.user_id;
      });
      $scope.usuariosFiltrados.ids = $scope.users.ids.filter(function(id){
        return theLookingIDs.contiene(id);
      });

      $("#usuarios-cont-movible").animate({left: "=0",}, 100, function(){ $scope.posicionActual = 0; });

    }
  });

}]);
