var permisos = angular.module('permisos', ['ngMaterial','ngSanitize', 'utilDirectives']);
permisos.service("APIPermisos", [ '$q','$http',function($q, $http){
  var self = this;
  this.API_URL = "/dev/sistema/permisos/api";

  this.getPermisos = function(){
    return $q(function(resolve, reject){
        $http.get(self.API_URL + "/getPermisos.php").then(function(res){
          resolve(res.data.result);
        });
    });
  }

  this.getUsers = function(){
    return $q(function(resolve, reject){
        $http.get(self.API_URL + "/getUsers.php").then(function(res){
          resolve(res.data.result);
        });
    });
  }

  this.getAccesos = function(){
    return $q(function(resolve, reject){
        $http.get(self.API_URL + "/getAccess.php").then(function(res){
          resolve(res.data);
        });
    });
  }

  this.allow = function(uid, pid){
    return $q(function(resolve, reject){
      $http.get("/sistema/api/v1/permission_allow.php?ids="+uid+"&prs="+pid ).then(function(res){
        resolve(res.data);
      });
    });
  }

  this.deny = function(uid, pid){
    return $q(function(resolve, reject){
      $http.get("/sistema/api/v1/permission_deny.php?ids="+uid+"&prs="+pid).then(function(res){
        resolve(res.data);
      });
    });
  }





}]);
permisos.directive('avisarAlTerminar', function() {
  return function(scope, element, attrs) {
    if (scope.$last){
      console.info("all rendered!");
    }
  };
})
