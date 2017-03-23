<?php
include_once $_SERVER['DOCUMENT_ROOT']."/sistema/api/v1/conexion.php";
include_once $_SERVER['DOCUMENT_ROOT']."/sistema/api/v1/base.api.php";
include_once "Paginacion.class.php";

class Permiso{

var $db;

function __construct() {
       $this->db = 'sistemas';
   }

public function add( $datos ){
	//$datos['observaciones'] = isset($datos['observaciones']) ? $datos['observaciones'] : 'NULL';
	$sql = "INSERT INTO permisos_cat (id_grupo, id_pagina, permiso_key, permiso_detalles, descripcion, fecha_agregado)
			VALUES ('".$datos['id_grupo']."',
			'".$datos['id_pagina']."',
			'".$datos['permiso_key']."',
			'".$datos['item']."',
			'', CURRENT_TIMESTAMP);";
//echo $sql;
	DBO::select_db($this->db);
	$a = DBO::insert($sql);
}

public function updateDetalle( $datos ){
	$sql = "UPDATE permisos_cat SET permiso_detalles = '".html_entity_decode($datos['permiso_detalles'])."' WHERE permiso_id = '".$datos['permiso_id']."';";
	DBO::select_db($this->db);
	$a = DBO::doUpdate($sql);
}

public function updateKey( $datos ){
	$sql = "UPDATE permisos_cat SET permiso_key = '".html_entity_decode($datos['permiso_key'])."' WHERE permiso_id = '".$datos['permiso_id']."';";
	DBO::select_db($this->db);
	$a = DBO::doUpdate($sql);
}

public function updateGroup( $datos ){
	$sql = "UPDATE permisos_cat SET id_grupo = '".$datos['group']."' WHERE permiso_id = ".$datos['permiso_id'].";";
	DBO::select_db($this->db);
	$a = DBO::doUpdate($sql);
}

public function updatePagina( $datos ){
	$sql = "UPDATE permisos_cat SET id_pagina = '".$datos['id_pagina']."' WHERE permiso_id = ".$datos['permiso_id'].";";
	DBO::select_db($this->db);
	$a = DBO::doUpdate($sql);
}

public function listGroups(){
  $sql = "SELECT * FROM permisos_grupo";
  DBO::select_db($this->db);
  return DBO::getArray($sql);
}

public function listPags( $data ){
  $id_group = isset($data['id_group']) ? $data['id_group'] : '';

  $sql = "SELECT * FROM permisos_pagina WHERE id_grupo = '".$id_group."';";
  DBO::select_db($this->db);
  return DBO::getArray($sql);
}

public function listCatPuestos( $datos ){

$n = isset( $datos['n'] ) ? $datos['n'] : '';
if( isset( $datos['n'] ) )
		$n = $datos['n'] == 'undefined'  ? '' : $datos['n'];

   $sql = "SELECT pc.*, pg.id_grupo as 'group', pg.grupo as groupName, pp.pagina as pagina
FROM permisos_cat pc
LEFT JOIN permisos_grupo pg ON pg.id_grupo = pc.id_grupo
LEFT JOIN permisos_pagina pp ON pp.id_pagina = pc.id_pagina
WHERE pg.grupo LIKE '%".$n."%' OR permiso_detalles LIKE '%".$n."%'
ORDER BY id_grupo, fecha_agregado DESC
";
  $db = 'sistemas';
  $page = isset( $datos['page'] ) ? $datos['page'] : 1;

  return Response::$data->result = Paginacion::getPaginacion( $sql, $db, $page, 3, 100 );

}



}
