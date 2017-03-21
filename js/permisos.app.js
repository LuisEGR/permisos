var permisos = angular.module('permisos', ['ngMaterial','ngSanitize', 'utilDirectives']);
permisos.service("APIPermisos", [ '$q','$http',function($q, $http){
  var self = this;
  this.API_URL = "/dev/sistema/permisos/api"
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

}]);
