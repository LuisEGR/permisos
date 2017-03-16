<?php
include_once "../conexion.php";
$dbc->select_db("sistemas");

//Obtenemos el numero de la pagina
$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
$per_page = 50; //Son el numero de registros por pagina
$offset = ($page - 1) * $per_page;
//Recibe el nombre o id del usuario a buscar
$nombreSearch = (isset($_REQUEST['n']) && !empty($_REQUEST['n']))?$_REQUEST['n']:'';
$nombreSearch = limpiarEntrada($nombreSearch); 
$filters = getFilters($nombreSearch); //Crea el filtro para buscar al usuario

$noRecords = getNumRecords( $dbc, $filters ); //Numero total de registros del query
$noPages = ceil($noRecords/$per_page); //Numero de paginas asociadas al query
$adjacents  = 3; //Paginas adjacentes a la pagina activa
$logs = getLogs( $dbc, $offset, $per_page, $filters ); //Obtiene los registros del query

echo reponseJson( $logs, $page, $noPages, $adjacents );


// ----------------------        FUNCIONES			--------------------------

function getNumRecords( $db, $filters ){
	$result = $db->prepare("SELECT *, (SELECT permisos_cat.permiso_detalles FROM permisos_cat WHERE permisos_cat.permiso_id=l.permiso_id) AS permiso
							FROM permisos_log l
							INNER JOIN hovahlt.usuario u ON u.usu_id = l.user_id
							INNER JOIN hovahlt.usuario um ON um.usu_id = l.user_modified $filters");
	$result->execute();

	return  $result->rowCount();
}

function getLogs( $db, $offset, $per_page, $filters ){
	$sth = $db->prepare("SELECT l.*, (SELECT permisos_cat.permiso_detalles FROM permisos_cat WHERE permisos_cat.permiso_id=l.permiso_id) AS permiso,
							CONCAT(u.usu_nom, ' ', u.usu_pat) AS user,
							CONCAT(um.usu_nom, ' ', um.usu_pat) AS username_modified
							FROM permisos_log l
							INNER JOIN hovahlt.usuario u ON u.usu_id = l.user_id
							INNER JOIN hovahlt.usuario um ON um.usu_id = l.user_modified
							$filters							
							ORDER BY l.time DESC LIMIT $offset,$per_page;");
	
	$sth->execute();
	$result = $sth->fetchALL(PDO::FETCH_ASSOC);
	return $result;	
}

function reponseJson( $logs, $page, $noPages, $adjacents ){

	$data = array(
					'noRegistros' => $noPages,
					'page' => $page,
					'adjacents' => $adjacents,
					'registros' => $logs
				);

	header('Content-Type: application/json');
				
	echo json_encode($data);
}

function limpiarEntrada($data){
	if (get_magic_quotes_gpc()) {  
		//Quitamos las barras de un string con comillas escapadas  
		//Aunque actualmente se desaconseja su uso, muchos servidores tienen activada la extensión magic_quotes_gpc.   
		//Cuando esta extensión está activada, PHP añade automáticamente caracteres de escape (\) delante de las comillas que se escriban en un campo de formulario.   
		$data = trim(stripslashes($data));  
	}  

	//eliminamos etiquetas html y php  
	$data = strip_tags($data);  
	//Conviertimos todos los caracteres aplicables a entidades HTML  
	$data = htmlentities($data);  
	$entrada = trim($data);  

	return $entrada;  
}

function getFilters( $nombreSearch ){
	return ( $nombreSearch != '' ) ? "WHERE CONCAT(u.usu_nom, ' ', u.usu_pat, ' ', u.usu_mat) LIKE '%$nombreSearch%'  OR  
											CONCAT(um.usu_nom, ' ', um.usu_pat, ' ', um.usu_mat) LIKE '%$nombreSearch%' OR 
											user_id = '$nombreSearch' OR
											user_modified = '$nombreSearch'
											" : '';
}

?>