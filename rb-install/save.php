<?php
/*
* Instalador: Establece valores iniciales em la tabla Opciones
* Ultima actualizacion : 24-01-17
*/
$opciones_valores = array(
	"nombresitio" => "Nombre Sitio",
	"descripcion" => "Descripcion del sitio",
	"direccion_url" => "http://",
	"meta_keywords" => "",
	"meta_description" => "",
	"tema" => "",
	"enlaceamigable" => "0",
	"meta_author" => "blackpyro",
	"show_items" => "25",
	"background-image" => "",
	"mail_destination" => "",
	"objetos" => "",
	"mail_sender" => "",
	"initial" => "0",
	"post_by_category" => "15",
	"t_width" => "280",
	"t_height" => "190",
	"linkregister" => "0",
	"form_code" => "1",
	"form_code2" => "1",
	"mainmenu_id" => "0",
	"moneda" => "S/.",
	"modules_optiones" => '{"post":"1","cat":0,"pag":0,"com":0,"file":0,"gal":0,"usu":0,"mess":0,"men":0}',
	"post_options" => '{"gal":"1","adj":"1","edi":"1","adi":"1","enl":"1","vid":"1","otr":"1","sub":"1","cal":0}',
	"slide_main" => "0",
	"fb" => "",
	"tw" => "",
	"youtube" => "",
	"gplus" => "",
	"insta" => "",
	"in" => "",
	"pin" => "",
	"whatsapp" => "",
	"base_publication" => "articulo",
	"base_category" => "categoria",
	"base_search" => "busqueda",
	"base_user" => "usuario",
	"base_page" => "pag",
	"user_active_admin" => "0",
	"logo" => "0",
	"map-x" => "",
	"map-y" => "",
	"map-zoom" => "",
	"map-desc" => "",
	"nivel_user_register" => "3",
	"modules_load" => "[]",
	"sendgridapikey" => "",
	"name_sender" => "No-Reply",
	"lib_mail_native" => "0",
	"directorio_url" => "",
	"menu_panel" => '{"index":{"key":"index","nombre":"Inicio","url":"index.php","url_imagen":"img/icon_home.png","pos":1,"show":true,"item":null},"contents":{"key":"contents","nombre":"Contenidos","url":"#","url_imagen":"img/icon_post.png","pos":2,"show":true,"item":[{"key":"art","nombre":"Publicaciones","url":"index.php?pag=art","url_imagen":"none","pos":1},{"key":"cat","nombre":"Categorias","url":"index.php?pag=cat","url_imagen":"none","pos":1},{"key":"pages","nombre":"Paginas","url":"index.php?pag=pages","url_imagen":"none","pos":1},{"key":"com","nombre":"Comentarios","url":"index.php?pag=com","url_imagen":"none","pos":1}]},"media":{"key":"media","nombre":"Medios","url":"#","url_imagen":"img/icon_media.png","pos":3,"show":true,"item":[{"key":"files","nombre":"Archivos","url":"index.php?pag=files","url_imagen":"none","pos":1},{"key":"gal","nombre":"Galeria de Medios","url":"index.php?pag=gal","url_imagen":"none","pos":1}]},"users":{"key":"users","nombre":"Usuarios","url":"#","url_imagen":"img/icon_user.png","pos":4,"show":true,"item":[{"key":"usu","nombre":"Gestionar","url":"index.php?pag=usu","url_imagen":"none","pos":1},{"key":"men","nombre":"Mensaje","url":"index.php?pag=men","url_imagen":"none","pos":1},{"key":"nivel","nombre":"Niveles de acceso","url":"index.php?pag=nivel","url_imagen":"none","pos":1}]},"visual":{"key":"visual","nombre":"Apariencia","url":"#","url_imagen":"img/icon_design.png","pos":5,"show":true,"item":[{"key":"menus","nombre":"Menus","url":"index.php?pag=menus","url_imagen":"none","pos":1},{"key":"editfile","nombre":"Plantillas","url":"index.php?pag=editfile","url_imagen":"none","pos":1}]}}',
	"alcance" => "1"
);

require_once("../rb-script/funciones.php");
require_once("../rb-script/class/rb-database.class.php");

if(isset($_POST)):
	$sitio_titulo = $_POST['sitio_titulo'];
	$sitio_url = $_POST['sitio_url'];
	$usuario_correo = $_POST['usuario_correo'];
	$usuario_pass = $_POST['usuario_pass'];
	$usuario_pass1 = $_POST['usuario_pass1'];

	if($usuario_pass != $usuario_pass1) die("Contraseñas no coinciden");

	/* USUARIO INICIAL */
	$response = $objDataBase->Insertar("INSERT INTO usuarios (nickname, password, nombres, apellidos, correo, tipo, sexo, photo_id)
		VALUES ('admin', md5($usuario_pass), 'Admin', 'Del Sitio', '$usuario_correo', 1, 'h', 0)");
	
	if($response['result']==true):

	//if($objUsuario->Insertar( array('admin', $usuario_pass, 'Admin', 'Del Sitio', '', '', '', '', $usuario_correo, '', 1, 'h', 0) )):
		$usuario_id = $response['insert_id'];

		// ACTIVANDO USUARIO
		$objDataBase->EditarPorCampo('usuarios','activo',1,$usuario_id);

		// Recorrer array de valores para ingresarlos como valores por defecto
		foreach($opciones_valores as $option  => $value){
			//$objOpcion->insert_valor(1, $option, $value);
			$objDataBase->Ejecutar("INSERT INTO opciones (opcion, valor) VALUES ('$option','$value')");
		}

		/* VALORES INICIALES PARA EL BLOG */
		rb_set_values_options( "nombresitio", $sitio_titulo);
		rb_set_values_options( "direccion_url", $sitio_url);
		rb_set_values_options( "mail_destination", $usuario_correo);
		rb_set_values_options( "mail_sender", $usuario_correo);

		// Niveles de usuarios
		$objDataBase->Ejecutar("INSERT INTO usuarios_niveles (id, nombre, nivel_enlace, permisos) VALUE (1, 'Adminitrador', 'admin', 'Administra y gestiona la configuración todo el sitio web')");
		$objDataBase->Ejecutar("INSERT INTO usuarios_niveles (id, nombre, nivel_enlace, permisos) VALUE (2, 'Usuario Gestionador', 'user-panel', 'Usuario con acceso privilegio para gestionar parte del sitio web')");
		$objDataBase->Ejecutar("INSERT INTO usuarios_niveles (id, nombre, nivel_enlace, permisos) VALUE (3, 'Usuario Final', 'user-front', 'Usuario final, no tiene acceso a gestionar la web')");

		header('Location: '.$sitio_url."/login.php");
	else:
		die("Problemas a registrar los datos. Si problema persiste consulte el soporte técnico.".$response['error']);
	endif;
endif;
?>
