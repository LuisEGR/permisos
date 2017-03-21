<?php
error_reporting(E_ALL & ~E_NOTICE);
define(ROOT_DIR, $_SERVER['DOCUMENT_ROOT']);
define(BOOLEANO, 0);
define(REDIRECT, 1);
define(JSON, 2);
include_once ROOT_DIR."/sistema/api/v1/conexion.php";
include_once ROOT_DIR."sistema/class/Usuarios.class.php";

// session_start();
////// Clase para registrar el log de la edicion de permisos en todo momento
if (!class_exists('Logger')) {
  class Logger
  {
    static private $dbc;
    public static function init($conexion)
    {
      self::$dbc = $conexion;
      self::$dbc->select_db('sistemas');
    }

    public static function log($idUser,$id_perm,$action,$idUserMod){
      self::$dbc->select_db('sistemas');
      $stmt = self::$dbc->prepare("INSERT INTO permisos_log(permiso_id, user_id, action, user_modified) VALUES (?,?,?,?)");
      $stmt->bind_param("iisi", $id_perm, $idUser, $action, $idUserMod);
      // echo $stmt->error;
      // var_
      // echo $dbc->error;
      $stmt->execute();
      // return 1;
      if($stmt->errno == 0) return 1;
    }
    // public static function publicLog()
  }

}


Logger::init($dbc);
///End logger class

class Permisos
{
  static private $dbc;

  public static function setConection($conexion)
  {
    self::$dbc = $conexion;
    self::$dbc->select_db('sistemas');
  }

  public static function init($conexion)
  {
    self::$dbc = $conexion;
  }

  public static function getUserID()
  {
    @session_start();
    if(isset($_SESSION['portal_usuario_id']))
      return $_SESSION['portal_usuario_id'];
    if(isset($_SESSION['MM_UserID']))
      return $_SESSION['MM_UserID'];

  }


  public static function getPermisos()
  {
      self::$dbc->select_db('sistemas');
      $query = "SELECT permiso_id, permiso_key, permiso_detalles FROM permisos_cat";
      $result = self::$dbc->query($query);
      $arrayResult = array();
      while($row = $result->fetch_assoc()) {
        $arrayResult[] = $row;
      }
      return $arrayResult;
  }

  public static function getUsuariosPermitidos($perm_key){
    self::$dbc->select_db('sistemas');
    $id_perm = self::getPermisoID($perm_key);
    $query = "SELECT user_id, allow FROM permisos_user WHERE permiso_id = ".$id_perm;
    // $result = self::$dbc->query($query);
    $arrayResult = DBO::getArray($query);
    // while($row = $result->fetch_assoc()) {
      // $arrayResult[] = $row;
    // }
    return $arrayResult;
  }
  public static function getUsuariosPermitidosArray($perm_ids){
    self::$dbc->select_db('sistemas');
    // $id_perm = self::getPermisoID($perm_key);
    $query = "SELECT user_id, permiso_id, allow FROM permisos_user WHERE permiso_id in(".$perm_ids.") ORDER BY permiso_id DESC ";
    // echo $query;
    $arrayResult = DBO::getArray($query);
    return $arrayResult;
  }

  //Permisos::getPermisoID('key') - returns permisos_cat.permiso_id
  public static function getPermisoID($perm_key)
  {
      self::$dbc->select_db('sistemas');
      $query = "SELECT permiso_id FROM permisos_cat WHERE permiso_key = '".$perm_key."'  ";
      $result = self::$dbc->query($query);
      // echo self::$dbc->error;
      $row = $result->fetch_object();
      if($row == null) return null;
      return intVal($row->permiso_id);
  }

  //Permisos::isAllowed(id_user, 'key') - returns 1/0
  public static function isAllowed($idUser, $perm_key)
  {
    self::$dbc->select_db('sistemas');
    $id_perm = self::getPermisoID($perm_key);
    $query = "SELECT * FROM permisos_user WHERE user_id = ".$idUser." AND permiso_id =".$id_perm;
    $result = self::$dbc->query($query);
    if($result == null){return 0;}//si no está registrada una relación entre el usuario y el permisos
    $row = $result->fetch_object();
    if($row == null){return 0;}//si no está registrada una relación entre el usuario y el permisos
    return $row->allow & 1;// para retornar valor boleano
  }
  //$TypeReturn: Boolean, Redirect, JSON
  public static function check($perm_key, $typeReturn = BOOLEANO){
    $u = self::getUserID();
    if($typeReturn == BOOLEANO){
      return self::isAllowed($u, $perm_key);
    }
    if($typeReturn == REDIRECT){
      if(!self::isAllowed($u, $perm_key)){
        include_once ROOT_DIR."/sistema/403.html";
        die();
      }
    }
    if($typeReturn == JSON){
      if(!self::isAllowed($u, $perm_key)){
        $data = new stdClass;
        $data->errno = 403;
        $data->error = "Acceso Denegado";
        $data->result = null;
        header('Content-Type:application/json');
        echo json_encode($data);
        die();
      }
    }

  }


  //Permisos::addAcceso(id_user, 'key', optional:1/0) - returns 1/0
  public static function addAcceso($idUser, $perm_key, $is_id = false, $allow = 0){
    self::$dbc->select_db('sistemas');
    $res = new stdClass();
    $id_perm = $perm_key;
    if(!$is_id)
      $id_perm = self::getPermisoID($perm_key);
    $id_rel = "U".$idUser."P".$id_perm;
    $stmt = self::$dbc->prepare("INSERT INTO permisos_user(id,user_id, permiso_id, allow) VALUES (?,?,?,?)");
    $stmt->bind_param("siii", $id_rel,$idUser, $id_perm, $allow);
    $res->status = $stmt->execute();
    // echo $stmt->errno;
    if($stmt->errno == 1062) return 0;//Entrada duplicada
    if($stmt->errno == 0) {
      Logger::log(self::getUserID(),$id_perm,'add',$idUser);
      return 1;
    }
  }

  //Permisos::addPermiso('detalles') - returns permisos_cat.permiso_key
  public static function addPermiso($detalles)
  {
    self::$dbc->select_db('sistemas');
    $res = new stdClass();
    $key = self::generarKey();
    $stmt = self::$dbc->prepare("INSERT INTO permisos_cat(permiso_key, permiso_detalles) VALUES (?,?)");
    $stmt->bind_param("ss", $key, $detalles);
    $res->status = $stmt->execute();
    if($stmt->affected_rows == 0){
      return false;
    }
    return $key;
  }

  //Permisos::Allow(iduser, 'key') - returns 1/0
  public static function Allow($idUser, $perm_key, $is_id = false){
    self::$dbc->select_db('sistemas');
    $id_perm = $perm_key;
    if(!$is_id)
      $id_perm = self::getPermisoID($perm_key);
    $query = "UPDATE permisos_user SET allow=1,last_modification=NOW() WHERE user_id = ".$idUser." AND permiso_id=".$id_perm;
    self::$dbc->query($query);
    $affected = self::$dbc->affected_rows;
    Logger::log(self::getUserID(),$id_perm,'allow',$idUser);
    return $affected;
  }

  //Permisos::Deny(iduser, 'key') - returns 1/0
  public static function Deny($idUser, $perm_key, $is_id = false){
    self::$dbc->select_db('sistemas');
    $id_perm = $perm_key;
    if(!$is_id)
      $id_perm = self::getPermisoID($perm_key);
    $query = "UPDATE permisos_user SET allow=0,last_modification=NOW() WHERE user_id = ".$idUser." AND permiso_id=".$id_perm;
    self::$dbc->query($query);
    // $idUser, $id_perm, $action, $idUserMod
    // echo $idUser;
    $affected = self::$dbc->affected_rows;
    Logger::log(self::getUserID(),$id_perm,'deny',$idUser);
    return $affected;
  }


  private static function generarKey()
  {
    return md5(microtime().rand());
  }



  //// Obtener el log de los permisos que se han asignado o denegado respecto a un usuario ////
  public static function getLogUser($uid, $start = 0, $end = 50){
    $query = "SELECT id_log,UNIX_TIMESTAMP(time)as _time, action, user_modified FROM permisos_log WHERE user_id = $uid LIMIT $start, $end";
    return DBO::getArray($query);
  }

  //// Obtener el log de los permisos que se han asignado o denegado de parte de un usuario ////
  public static function getLogUserAdmin($uid, $start = 0, $end = 50){
    $query = "SELECT id_log,UNIX_TIMESTAMP(time)as _time, action, user_id FROM permisos_log WHERE user_modified = $uid LIMIT $start, $end";
    return DBO::getArray($query);
  }


  //// Obtener el log de los permisos que se han asignado o denegado en general ////
  public static function getLog($start = 0, $end = 50){
    $query = "SELECT id_log,UNIX_TIMESTAMP(time)as _time, action, user_modified FROM permisos_log LIMIT $start, $end";
    return DBO::getArray($query);
  }

  //// Obtener los usuarios registrados y los accesos que tiene cada uno ////
  public static function getPermisosUsuarios(){
    // $query = "SELEC"
    $users = array();
    $usuarios = Usuarios::getAllUsers(true, true);
    foreach ($usuarios as $key => $usuario) {
      $obj = new stdClass();
      $obj->id =  $usuario;
      $obj->nombre = Usuarios::getNombreUsuario($usuario);
      $users[] = $obj;
    }

    return $users;
  }



  //Permisos::isAllowed(id_user, 'key') - returns 1/0
  public static function isKeyActive($api_key)
  {
    self::$dbc->select_db('accesos');
    $apk = DBO::s($api_key);
    $query = "SELECT * FROM public_api_keys WHERE api_key =  $apk";
    return DBO::get($query)->active;
  }

  public static function checkApiKey($api_key){
    $u = self::getUserID();
    if($typeReturn == JSON){
      if(!self::isKeyActive($api_key)){
        $data = new stdClass;
        $data->errno = 403;
        $data->error = "Acceso Denegado";
        $data->result = null;
        header('Content-Type:application/json');
        echo json_encode($data);
        die();
      }
    }
  }

  public static function contarPermisosUsuario($uid){
    DBO::select_db('sistemas');
    $total = DBO::getNumber("SELECT * FROM permisos_user WHERE allow = 1 AND user_id = $uid");
    return $total?$total:0;
  }


  public static function getAccesos(){
    DBO::select_db('directorio');
    $usuarios = DBO::getArray('SELECT user_id, CONCAT(u.nombre," ", u.apaterno) as usuario_name FROM directorio.miembros u WHERE active = 1 AND
     user_id IS NOT NULL ORDER BY user_id');
    foreach ($usuarios as $key => $usuario) {
      $usuarios[$key]['total_permisos'] = self::contarPermisosUsuario($usuario['user_id']);
      $puesto = Usuarios::getGruposPuesto($usuario['user_id']);
      $usuarios[$key]['grupo'] = $puesto->proyecto;
      $usuarios[$key]['subgrupo'] = $puesto->clave;
    }
    return $usuarios;
  }


  public static function getAllAccess(){
    DBO::select_db('sistemas');
    $q = "SELECT p.user_id, p.permiso_id, c.id_pagina, c.id_grupo FROM permisos_user p, permisos_cat c
    WHERE
    p.permiso_id = c.permiso_id AND
    p.allow = 1
    ORDER BY id_pagina, id_grupo ASC";
    return DBO::getArray($q);
  }







}
Permisos::init($dbc);//Inicializar y enlazar mysqli object
 ?>
