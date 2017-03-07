var appPermisos = angular.module('Permisos', ['ngNotify']);
appPermisos.controller('controllerPermisos',[ '$scope', '$http', '$filter','ngNotify', function($scope, $http, $filter, ngNotify){
  $scope.selecteds = [];
  $scope.cat_permisos = [];
  $scope.permisos = {
    lista: [],
    ids: []
  }
  // $scope.usersSelected = 0;
  $scope.actual = {};
  $scope.usuarios_permitidos = [];
  $scope.usuariosPermitidosMostrar = [];
  $scope.usersSelectedList =[];
  $scope.filtros = {};
  $scope.check_all = false;
  $scope.nuevoPermisoDescription = "";
  $scope.generatedKeys = [];
  $scope.users_bkp = [];
  ngNotify.config({
      theme: 'pure',
      position: 'top',
      duration: 3000,
      type: 'info',
      sticky: false,
      button: true,
      html: false
  });
  $http.get("http://104.130.47.10/sistema/modalidades/api/getAllUsers.php").then(function(response) {
      $scope.usersLoaded = response.data;
      $scope.users_bkp = response.data;
  });
  function actualizarCatalogoPermisos(){
    $http.get("http://104.130.47.10/sistema/api/v1/getListadoPermisos.php").then(function(response) {
      $scope.cat_permisos = response.data.result;
    });
  }

  $scope.$watch('permisos.lista', function(v){
    if(v){
      console.dir(v);
      $scope.permisos.ids.length = 0;
      angular.forEach(v, function(u){
        $scope.permisos.ids.push(u.permiso_id);
      })
      $scope.permisos.listIds = $scope.permisos.ids.join(',');
      actualizarUsuariosPermitidos();
    }
  });

  $scope.setActual = function(p){
    $scope.actual = p;
    actualizarUsuariosPermitidos();
  }
  function actualizarUsuariosPermitidos(){
    $scope.usuariosPermitidosMostrar.length = 0;
    $http.get("http://104.130.47.10/sistema/api/v1/getUsuariosPermitidos.php?ps="+$scope.permisos.listIds).then(function(response) {
      $scope.usuarios_permitidos = response.data.result;
      $scope.usuariosPermitidosMostrar = procesarUsuarios();
      console.log($scope.usuariosPermitidosMostrar);
    });
  }
  // actualizarUsuariosPermitidos();
  actualizarCatalogoPermisos();

  $scope.agregarUsuario = function(index){
    var usuarios = $filter('filter')($scope.usersLoaded, $scope.searchText);
    if(usuarios[index].added === true) usuarios[index].added = false;
    else usuarios[index].added = true;
    actualzarListaSelected();
  }

  $scope.agregarUsuario2 = function(index){
    var usuarios = $filter('filter')($scope.usuariosPermitidosMostrar, $scope.searchText2);
    if(usuarios[index].added === true) usuarios[index].added = false;
    else usuarios[index].added = true;
    actualzarListaSelected();
  }

  var selected = false;
  $scope.checkAll = function(){
    var copiaUsers = angular.copy($scope.usersLoaded);
    var usuarios = $filter('filter')(copiaUsers, $scope.searchText);
    if(selected == false){
      angular.forEach(usuarios, function(v,k){
        angular.forEach($scope.usersLoaded, function(val,key){
          if(v.usu_id == val.usu_id)
            $scope.usersLoaded[key].added = true;
        });
      });
      selected = true;
    }else{
      angular.forEach(usuarios, function(v,k){
        angular.forEach(usuarios, function(v,k){
          angular.forEach($scope.usersLoaded, function(val,key){
            if(v.usu_id == val.usu_id)
              $scope.usersLoaded[key].added = false;
          });
        });
        // $scope.usersLoaded[k].added = false;
      });
      selected = false;
    }
    actualzarListaSelected();
  }



  $scope.agregarPermiso = function(){
    $("#btn-generar").attr('disabled', 'disabled');
    console.log("Agregando..."+$scope.nuevoPermisoDescription);
    $http.get('/sistema/api/v1/generatePermissionKey.php?d='+encodeURI($scope.nuevoPermisoDescription)).then(function(response) {
      $("#btn-generar").prop("disabled", false);
      var dum = {
        description: $scope.nuevoPermisoDescription,
        key: response.data.result,
        time: (new Date()).getTime()
      }
      console.dir(dum);
      $scope.generatedKeys.push(dum);
      actualizarCatalogoPermisos();
    });
  }

  $scope.denyAcceso = function(){
    // console.dir($scope.usersSelectedList);
    var ids = "permission_deny.php?ids=" + extraerIdsSelected() + "&prs=" + $scope.permisos.listIds;
    $http.get("http://104.130.47.10/sistema/api/v1/"+ids).then(function(response) {
      // console.log(response.data);
      // ngNotify.set('Acceso denegado a '+response.data.result+' usuarios!','success');
        if(response.data.errno == 0){
            $.toast({
              heading: 'Listo!',
              text: 'Has denegado '+response.data.result.permisos+' accesos a '+response.data.result.usuarios+' usuario(s) !',
              icon: 'success',
              loader: false,
              bgColor: '#3498db',
              textColor: 'white'
          });
        }else{
          $.toast({
            heading: 'Error!',
            text: response.data.error,
            icon: 'error',
            loader: false,
            bgColor: '#e74c3c',
            textColor: 'white'
          });
        }
      actualizarUsuariosPermitidos();
      // actualzarListaSelected();
      // angular.copy($scope.users_bkp, $scope.usersLoaded);
      limpiarSeleccion();
      // $scope.usersLoaded = $scope.users_bkp;
      // $scope.usersSelectedList.length = 0;
      // $scope.usersSelected = 0;
    });
  }
  $scope.allowAcceso = function(){
    var ids = "permission_allow.php?ids=" + extraerIdsSelected() + "&prs=" + $scope.permisos.listIds;
    $http.get("http://104.130.47.10/sistema/api/v1/"+ids).then(function(response) {
      if(response.data.errno == 0){
        $.toast({
          heading: 'Listo!',
          text: 'Has concedido '+response.data.result.permisos+' accesos a '+response.data.result.usuarios+' usuario(s) !',
          // text: 'Acceso concedido a '+response.data.result+' usuario(s)!',
          icon: 'success',
          loader: false,
          bgColor: '#1abc9c',
          textColor: 'white'
        });
      }else{
        $.toast({
          heading: 'Error!',
          text: response.data.error,
          icon: 'error',
          loader: false,
          bgColor: '#e74c3c',
          textColor: 'white'
        });
      }
      actualizarUsuariosPermitidos();
      limpiarSeleccion();
    });
    // console.dir(ids);
  }

  function limpiarSeleccion(){
    $scope.usersSelectedList.length = 0;
    var copiaUsers = angular.copy($scope.usersLoaded);
    var usuarios = $filter('filter')(copiaUsers, $scope.searchText);
    angular.forEach(usuarios, function(v,k){
      angular.forEach(usuarios, function(v,k){
        angular.forEach($scope.usersLoaded, function(val,key){
          if(v.usu_id == val.usu_id)
            $scope.usersLoaded[key].added = false;
        });
      });
    });
  }




  function extraerIdsSelected(){
    var ids = [];
    angular.forEach($scope.usersSelectedList, function(v,k){
      ids.push(v.usu_id);
    });
    return ids.toString();
  }

  function serializeObj(obj) {
    var result = [];
    for (var property in obj)
        result.push(encodeURIComponent(property) + "=" + encodeURIComponent(obj[property]));
    return result.join("&");
  }

  function procesarUsuarios(){
    var dum = [];
    angular.forEach($scope.usuarios_permitidos, function(v2,k2){
      angular.forEach($scope.usersLoaded, function(v,k){
        if(v.usu_id == v2.user_id){
          v2.usu_id = v.usu_id;
          v2.usu_nom = v.usu_nom;
          v2.usu_pat = v.usu_pat;
          dum.push(v2);
        }
      });
    });
    return dum;
  }

  actualzarListaSelected = function(){
    $scope.usersSelectedList.length = 0;
    angular.forEach($scope.usersLoaded, function(v,k){
      if(v.added === true) $scope.usersSelectedList.push(v);
    });
    // $scope.usersSelected = $scope.usersSelectedList.length;
  }

}]);


function add(){
  $("#modalAddPermiso").modal();
}
