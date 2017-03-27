<?php
include_once $_SERVER['DOCUMENT_ROOT']."/sistema/class/Permisos.class.php";
include_once $_SERVER['DOCUMENT_ROOT']."/sistema/api/v1/base.api.php";
$uid = $_POST['uid'];
$pid = $_POST['pid'];
$type = $_POST['type']; //1-set, 0-deny
if(!isset($_POST['uid'], $_POST['pid'], $_POST['type'])){
  Response::noDataResponse();
}
Response::$data->result = Permisos::Deny($uid, $pid, true);
Response::showResult();
?>
