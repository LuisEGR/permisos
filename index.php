<?php
include_once $_SERVER['DOCUMENT_ROOT']."/menu/Menu.class.php";
Menu::start("Administración de Permisos", 'menu_Admin');
include_once '/templates/index.template.html';
Menu::end();
?>
