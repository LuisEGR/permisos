<?php
try {
	$usuario = 'root';
	$contrasena = '';
    $db = new PDO('mysql:host=localhost;dbname=sistemas', $usuario, $contrasena);
	$db->exec("SET CHARACTER SET utf8");
} catch (PDOException $e) {
    print "¡Error!: " . $e->getMessage() . "<br/>";
    die();
}
?>