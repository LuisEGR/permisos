<?php
include "../classes/Permiso.class.php";
include "../classes/Grupo.class.php";
include "../classes/Pagina.class.php";
 
$request_body = file_get_contents('php://input');
$data = json_decode($request_body);
$a = (array) $data;
$_POST = array_merge( $_POST, $a);
 
 require_once("Rest.php");  
 class Api extends Rest {  
   private $_conn = NULL;  
   private $_metodo;  
   private $_argumentos;  
   public function __construct() {  
     parent::__construct();  
     //$this->conectarDB();  
   }  

   private function devolverError($id) {  
     $errores = array(  
       array('estado' => "error", "msg" => "petición no encontrada"),  
       array('estado' => "error", "msg" => "petición no aceptada"),  
       array('estado' => "error", "msg" => "petición sin contenido"),  
       array('estado' => "error", "msg" => "email o password incorrectos"),  
       array('estado' => "error", "msg" => "error borrando usuario"),  
       array('estado' => "error", "msg" => "error actualizando nombre de usuario"),  
       array('estado' => "error", "msg" => "error buscando usuario por email"),  
       array('estado' => "error", "msg" => "error creando usuario"),  
       array('estado' => "error", "msg" => "usuario ya existe")  
     );  
     return $errores[$id];  
   }  
   public function procesarLLamada() {  
     if (isset($_REQUEST['url'])) {  
       //si por ejemplo pasamos explode('/','////controller///method////args///') el resultado es un array con elem vacios;
       //Array ( [0] => [1] => [2] => [3] => [4] => controller [5] => [6] => [7] => method [8] => [9] => [10] => [11] => args [12] => [13] => [14] => )
       $url = explode('/', trim($_REQUEST['url']));  
       //con array_filter() filtramos elementos de un array pasando función callback, que es opcional.
       //si no le pasamos función callback, los elementos false o vacios del array serán borrados 
       //por lo tanto la entre la anterior función (explode) y esta eliminamos los '/' sobrantes de la URL
       $url = array_filter($url);  
       $this->_metodo = strtolower(array_shift($url));  
       $this->_argumentos = $url;  
       $func = $this->_metodo;  
       if ((int) method_exists($this, $func) > 0) {  
         if (count($this->_argumentos) > 0) {  
           call_user_func_array(array($this, $this->_metodo), $this->_argumentos);  
         } else {//si no lo llamamos sin argumentos, al metodo del controlador  
           call_user_func(array($this, $this->_metodo));  
         }  
       }  
       else  
         $this->mostrarRespuesta($this->convertirJson($this->devolverError(0)), 404);  
     }  
     $this->mostrarRespuesta($this->convertirJson($this->devolverError(0)), 404);  
   }  
   private function convertirJson($data) {  
     return json_encode($data);  
   }  
   
   private function checkMethod( $method ){
		 if ($_SERVER['REQUEST_METHOD'] != $method ) {  
		   $this->mostrarRespuesta($this->convertirJson($this->devolverError(1)), 405);  
		 }
   }

    private function addPermiso() {  
		$this->checkMethod( "POST" );
		
		$data = $this->datosPeticion;
		
		$permiso = new Permiso;
   
     if (1 /*isset($this->datosPeticion['nombre'], $this->datosPeticion['email'], $this->datosPeticion['pwd'])*/ ) {  
       //$nombre = $this->datosPeticion['nombre'];  
       //$pwd = $this->datosPeticion['pwd'];  
       //$email = $this->datosPeticion['email'];  
       
	   $permiso->add( $data );
	   
	   if ( 1 /*!$this->existeUsuario($email)*/) {  
           //$id = $this->_conn->lastInsertId();  
           $respuesta['estado'] = 'correcto';  
           $respuesta['msg'] = 'usuario creado correctamente';  
           $respuesta['data'] = $data;
           /*$respuesta['usuario']['nombre'] = $nombre;  
           $respuesta['usuario']['email'] = $email;  */
           $this->mostrarRespuesta($this->convertirJson($respuesta), 200);  
       }  
     } else {  
       $this->mostrarRespuesta($this->convertirJson($this->devolverError(7)), 400);  
     }  
   }

    private function addGrupo() {  
		$this->checkMethod( "POST" );
		
		$data = $this->datosPeticion;
		
		$grupo = new Grupo;
   
     if (1 /*isset($this->datosPeticion['nombre'], $this->datosPeticion['email'], $this->datosPeticion['pwd'])*/ ) {  
       //$nombre = $this->datosPeticion['nombre'];  
       //$pwd = $this->datosPeticion['pwd'];  
       //$email = $this->datosPeticion['email'];  
       
	   $grupo->add( $data );
	   
	   if ( 1 /*!$this->existeUsuario($email)*/) {  
           //$id = $this->_conn->lastInsertId();  
           $respuesta['estado'] = 'correcto';  
           $respuesta['msg'] = 'usuario creado correctamente';  
           //$respuesta['data'] = $data;
           /*$respuesta['usuario']['nombre'] = $nombre;  
           $respuesta['usuario']['email'] = $email;  */
           $this->mostrarRespuesta($this->convertirJson($respuesta), 200);  
       }  
     } else {  
       $this->mostrarRespuesta($this->convertirJson($this->devolverError(7)), 400);  
     }  
   }

    private function addPagina() {  
		$this->checkMethod( "POST" );
		
		$data = $this->datosPeticion;
		
		$pagina = new Pagina;
   
     if (1 /*isset($this->datosPeticion['nombre'], $this->datosPeticion['email'], $this->datosPeticion['pwd'])*/ ) {  
       //$nombre = $this->datosPeticion['nombre'];  
       //$pwd = $this->datosPeticion['pwd'];  
       //$email = $this->datosPeticion['email'];  
       
	   $pagina->add( $data );
	   
	   if ( 1 /*!$this->existeUsuario($email)*/) {  
           //$id = $this->_conn->lastInsertId();  
           $respuesta['estado'] = 'correcto';  
           $respuesta['msg'] = 'usuario creado correctamente';  
           //$respuesta['data'] = $data;
           /*$respuesta['usuario']['nombre'] = $nombre;  
           $respuesta['usuario']['email'] = $email;  */
           $this->mostrarRespuesta($this->convertirJson($respuesta), 200);  
       }  
     } else {  
       $this->mostrarRespuesta($this->convertirJson($this->devolverError(7)), 400);  
     }  
   }
   
   private function updateDetallesPermiso() {  
		$this->checkMethod( "POST" );
		
		$data = $this->datosPeticion;
		
		$permiso = new Permiso;
   
     if (1 /*isset($this->datosPeticion['nombre'], $this->datosPeticion['email'], $this->datosPeticion['pwd'])*/ ) {  
       //$nombre = $this->datosPeticion['nombre'];  
       //$pwd = $this->datosPeticion['pwd'];  
       //$email = $this->datosPeticion['email'];  
       
	   $permiso->updateDetalle( $data );
	   
	   if ( 1 /*!$this->existeUsuario($email)*/) {  
           //$id = $this->_conn->lastInsertId();  
           $respuesta['estado'] = 'correcto';  
           $respuesta['msg'] = 'usuario creado correctamente';  
		   $respuesta['error'] = 'error';  
           //$respuesta['data'] = $data;
           /*$respuesta['usuario']['nombre'] = $nombre;  
           $respuesta['usuario']['email'] = $email;  */
           $this->mostrarRespuesta($this->convertirJson($respuesta), 200);  
       }  
     } else {  
       $this->mostrarRespuesta($this->convertirJson($this->devolverError(7)), 400);  
     }  
   }
   
    private function updateGrupo() {  
		$this->checkMethod( "POST" );
		
		$data = $this->datosPeticion;
		
		$grupo = new Grupo;
   
     if (1 /*isset($this->datosPeticion['nombre'], $this->datosPeticion['email'], $this->datosPeticion['pwd'])*/ ) {  
       //$nombre = $this->datosPeticion['nombre'];  
       //$pwd = $this->datosPeticion['pwd'];  
       //$email = $this->datosPeticion['email'];  
       
	   $grupo->updateGrupo( $data );
	   
	   if ( 1 /*!$this->existeUsuario($email)*/) {  
           //$id = $this->_conn->lastInsertId();  
           $respuesta['estado'] = 'correcto';  
           $respuesta['msg'] = 'update creado correctamente';  
		   $respuesta['error'] = 'error';  
           //$respuesta['data'] = $data;
           /*$respuesta['usuario']['nombre'] = $nombre;  
           $respuesta['usuario']['email'] = $email;  */
           $this->mostrarRespuesta($this->convertirJson($respuesta), 200);  
       }  
     } else {  
       $this->mostrarRespuesta($this->convertirJson($this->devolverError(7)), 400);  
     }  
   }
   
   private function updateKeyPermiso() {  
		$this->checkMethod( "POST" );
		
		$data = $this->datosPeticion;
		
		$permiso = new Permiso;
   
     if (1 /*isset($this->datosPeticion['nombre'], $this->datosPeticion['email'], $this->datosPeticion['pwd'])*/ ) {  
       //$nombre = $this->datosPeticion['nombre'];  
       //$pwd = $this->datosPeticion['pwd'];  
       //$email = $this->datosPeticion['email'];  
       
	   $permiso->updateKey( $data );
	   
	   if ( 1 /*!$this->existeUsuario($email)*/) {  
           //$id = $this->_conn->lastInsertId();  
           $respuesta['estado'] = 'correcto';  
           $respuesta['msg'] = 'usuario creado correctamente';  
		   $respuesta['error'] = 'error';  
           //$respuesta['data'] = $data;
           /*$respuesta['usuario']['nombre'] = $nombre;  
           $respuesta['usuario']['email'] = $email;  */
           $this->mostrarRespuesta($this->convertirJson($respuesta), 200);  
       }  
     } else {  
       $this->mostrarRespuesta($this->convertirJson($this->devolverError(7)), 400);  
     }  
   }

   private function updateGrupoPermiso() {  
		$this->checkMethod( "POST" );
		
		$data = $this->datosPeticion;
		
		$permiso = new Permiso;
   
     if (1 /*isset($this->datosPeticion['nombre'], $this->datosPeticion['email'], $this->datosPeticion['pwd'])*/ ) {  
       //$nombre = $this->datosPeticion['nombre'];  
       //$pwd = $this->datosPeticion['pwd'];  
       //$email = $this->datosPeticion['email'];  
       
	   $permiso->updateGroup( $data );
	   
	   if ( 1 /*!$this->existeUsuario($email)*/) {  
           //$id = $this->_conn->lastInsertId();  
           $respuesta['estado'] = 'correcto';  
           $respuesta['msg'] = 'usuario creado correctamente';  
		   $respuesta['error'] = 'error';  
           //$respuesta['data'] = $data;
           /*$respuesta['usuario']['nombre'] = $nombre;  
           $respuesta['usuario']['email'] = $email;  */
           $this->mostrarRespuesta($this->convertirJson($respuesta), 200);  
       }  
     } else {  
       $this->mostrarRespuesta($this->convertirJson($this->devolverError(7)), 400);  
     }  
   }

   private function updatePaginaPermiso() {  
		$this->checkMethod( "POST" );
		
		$data = $this->datosPeticion;
		
		$permiso = new Permiso;
   
     if (1 /*isset($this->datosPeticion['nombre'], $this->datosPeticion['email'], $this->datosPeticion['pwd'])*/ ) {  
       //$nombre = $this->datosPeticion['nombre'];  
       //$pwd = $this->datosPeticion['pwd'];  
       //$email = $this->datosPeticion['email'];  
       
	   $permiso->updatePagina( $data );
	   
	   if ( 1 /*!$this->existeUsuario($email)*/) {  
           //$id = $this->_conn->lastInsertId();  
           $respuesta['estado'] = 'correcto';  
           $respuesta['msg'] = 'usuario creado correctamente';  
		   $respuesta['error'] = 'error';  
           //$respuesta['data'] = $data;
           /*$respuesta['usuario']['nombre'] = $nombre;  
           $respuesta['usuario']['email'] = $email;  */
           $this->mostrarRespuesta($this->convertirJson($respuesta), 200);  
       }  
     } else {  
       $this->mostrarRespuesta($this->convertirJson($this->devolverError(7)), 400);  
     }  
   }
     
   private function getGroupsPermisos(  ) {
		$this->checkMethod( "GET" );
		
		$permiso = new Permiso;
		
		$data = $this->datosPeticion;
   
     if (1 /*isset($this->datosPeticion['nombre'], $this->datosPeticion['email'], $this->datosPeticion['pwd'])*/ ) {  
       //$nombre = $this->datosPeticion['nombre'];  
       //$pwd = $this->datosPeticion['pwd'];  
       //$email = $this->datosPeticion['email'];  
       
	   $groups = $permiso->listGroups( $data );
	   
	   if ( 1 /*!$this->existeUsuario($email)*/) {  
           //$id = $this->_conn->lastInsertId();  
           $respuesta['estado'] = 'correcto';  
           $respuesta['msg'] = 'usuario creado correctamente';  
           $respuesta['groups'] = $groups;
           /*$respuesta['usuario']['nombre'] = $nombre;  
           $respuesta['usuario']['email'] = $email;  */
           $this->mostrarRespuesta($this->convertirJson($respuesta), 200);  
       }  
     } else {  
       $this->mostrarRespuesta($this->convertirJson($this->devolverError(7)), 400);  
     }  
   }

   private function getPagsPermisos(  ) {
		$this->checkMethod( "GET" );
		
		$permiso = new Permiso;
		
		$data = $this->datosPeticion;
   
     if (1 /*isset($this->datosPeticion['nombre'], $this->datosPeticion['email'], $this->datosPeticion['pwd'])*/ ) {  
       //$nombre = $this->datosPeticion['nombre'];  
       //$pwd = $this->datosPeticion['pwd'];  
       //$email = $this->datosPeticion['email'];  
       
	   $pags = $permiso->listPags( $data );
	   
	   if ( 1 /*!$this->existeUsuario($email)*/) {  
           //$id = $this->_conn->lastInsertId();  
           $respuesta['estado'] = 'correcto';  
           $respuesta['msg'] = 'usuario creado correctamente';  
           $respuesta['pags'] = $pags;
           /*$respuesta['usuario']['nombre'] = $nombre;  
           $respuesta['usuario']['email'] = $email;  */
           $this->mostrarRespuesta($this->convertirJson($respuesta), 200);  
       }  
     } else {  
       $this->mostrarRespuesta($this->convertirJson($this->devolverError(7)), 400);  
     }  
   }
   
   private function getCatPermisos(  ) {
		$this->checkMethod( "GET" );
		
		$permiso = new Permiso;
		
		$data = $this->datosPeticion;
   
     if (1 /*isset($this->datosPeticion['nombre'], $this->datosPeticion['email'], $this->datosPeticion['pwd'])*/ ) {  
       //$nombre = $this->datosPeticion['nombre'];  
       //$pwd = $this->datosPeticion['pwd'];  
       //$email = $this->datosPeticion['email'];  
       
	   $permisos = $permiso->listCatPuestos( $data );
	   
	   if ( 1 /*!$this->existeUsuario($email)*/) {  
           //$id = $this->_conn->lastInsertId();  
           $respuesta['estado'] = 'correcto';  
           $respuesta['msg'] = 'usuario creado correctamente';  
           $respuesta['miembros'] = $permisos;
           /*$respuesta['usuario']['nombre'] = $nombre;  
           $respuesta['usuario']['email'] = $email;  */
           $this->mostrarRespuesta($this->convertirJson($respuesta), 200);  
       }  
     } else {  
       $this->mostrarRespuesta($this->convertirJson($this->devolverError(7)), 400);  
     }  
   }

   private function getCatGrupos(  ) {
		$this->checkMethod( "GET" );
		
		$grupo = new Grupo;
		
		$data = $this->datosPeticion;
   
     if (1 /*isset($this->datosPeticion['nombre'], $this->datosPeticion['email'], $this->datosPeticion['pwd'])*/ ) {  
       //$nombre = $this->datosPeticion['nombre'];  
       //$pwd = $this->datosPeticion['pwd'];  
       //$email = $this->datosPeticion['email'];  
       
	   $grupos = $grupo->listCatGrupos( $data );
	   
	   if ( 1 /*!$this->existeUsuario($email)*/) {  
           //$id = $this->_conn->lastInsertId();  
           $respuesta['estado'] = 'correcto';  
           $respuesta['msg'] = 'usuario creado correctamente';  
           $respuesta['miembros'] = $grupos;
           /*$respuesta['usuario']['nombre'] = $nombre;  
           $respuesta['usuario']['email'] = $email;  */
           $this->mostrarRespuesta($this->convertirJson($respuesta), 200);  
       }  
     } else {  
       $this->mostrarRespuesta($this->convertirJson($this->devolverError(7)), 400);  
     }  
   }
   
    private function getPagesGroup() {
		$this->checkMethod( "GET" );
		
		$permiso = new Permiso;
		
		$data = $this->datosPeticion;
   
     if (1 /*isset($this->datosPeticion['nombre'], $this->datosPeticion['email'], $this->datosPeticion['pwd'])*/ ) {  
       //$nombre = $this->datosPeticion['nombre'];  
       //$pwd = $this->datosPeticion['pwd'];  
       //$email = $this->datosPeticion['email'];  
       
	   $catPags = $permiso->listPags( $data );
	   
	   if ( 1 /*!$this->existeUsuario($email)*/) {  
           //$id = $this->_conn->lastInsertId();  
           $respuesta['estado'] = 'correcto';  
           $respuesta['msg'] = 'paginas cargadas correctamente';
		   $respuesta['catPags'] = $catPags;		   
           /*$respuesta['usuario']['nombre'] = $nombre;  
           $respuesta['usuario']['email'] = $email;  */
           $this->mostrarRespuesta($this->convertirJson($respuesta), 200);  
       }  
     } else {  
       $this->mostrarRespuesta($this->convertirJson($this->devolverError(7)), 400);  
     }  
   }   
   
    private function getDataAddPermiso() {
		$this->checkMethod( "GET" );
		
		$permiso = new Permiso;
		
		$data = $this->datosPeticion;
   
     if (1 /*isset($this->datosPeticion['nombre'], $this->datosPeticion['email'], $this->datosPeticion['pwd'])*/ ) {  
       //$nombre = $this->datosPeticion['nombre'];  
       //$pwd = $this->datosPeticion['pwd'];  
       //$email = $this->datosPeticion['email'];  
       
	   $catGrupos = $permiso->listGroups();
	   $catPags = $permiso->listPags( $data );
	   
	   if ( 1 /*!$this->existeUsuario($email)*/) {  
           //$id = $this->_conn->lastInsertId();  
           $respuesta['estado'] = 'correcto';  
           $respuesta['msg'] = 'usuario creado correctamente';
           $respuesta['catGrupos'] = $catGrupos;
		   $respuesta['catPags'] = $catPags;		   
           /*$respuesta['usuario']['nombre'] = $nombre;  
           $respuesta['usuario']['email'] = $email;  */
           $this->mostrarRespuesta($this->convertirJson($respuesta), 200);  
       }  
     } else {  
       $this->mostrarRespuesta($this->convertirJson($this->devolverError(7)), 400);  
     }  
   }
   
 }  
 $api = new Api();  
 $api->procesarLLamada(); 