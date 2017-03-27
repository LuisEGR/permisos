<?php
include_once $_SERVER['DOCUMENT_ROOT']."/sistema/class/Permisos.class.php";
include_once $_SERVER['DOCUMENT_ROOT']."/sistema/api/v1/base.api.php";
$data = json_decode(file_get_contents('php://input'));
if( !isset($data->uid, $data->pid) ){
  Response::noDataResponse();
}
Response::$data->result = Permisos::Deny($uid, $pid, true);
Response::showResult();
?>
