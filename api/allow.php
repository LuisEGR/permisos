<?php
include_once $_SERVER['DOCUMENT_ROOT']."/sistema/class/Permisos.class.php"
include_once $_SERVER['DOCUMENT_ROOT']."/sistema/api/v1/base.api.php";
$uid = $_POST['uid'];
$pid = $_POST['pid'];//1-set, 0-deny
if(!isset($_POST['uid'], $_POST['pid']){
  Response::noDataResponse();
}
Response::$data->result = Permisos::Allow($uid, $pid, true);
Response::showResult();
?>
