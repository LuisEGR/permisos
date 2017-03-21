<?php
  include_once $_SERVER['DOCUMENT_ROOT']."/sistema/class/Permisos.class.php";
  echo Permisos::getAllAccess();
?>
