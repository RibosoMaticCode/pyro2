<?php
/*
* Instalador: Establece valores iniciales em la tabla Opciones
* Ultima actualizacion : 24-01-17
*/
require_once("../rb-script/funciones.php");
require_once("../rb-script/class/rb-database.class.php");

$key_web = randomPassword(12,1,"lower_case,upper_case,numbers,special_symbols");

//function crear htaccess
function create_htaccess($dir){
	//Agradecimiento: http://www.dreamincode.net/forums/topic/214225-php-create-htaccess/page__view__findpost__p__1243819
	$create_name = "../.htaccess";
	// open the .htaccess file for editing
	$file_handle = fopen($create_name, 'w') or die("Error: Can't open file");
	//enter the contents
	$content_string = "# Generado automaticamente por Blackpyro\n";
	//$content_string .= "RewriteEngine On\n";
	$content_string .= "
<IfModule mod_rewrite.c>
	RewriteEngine On

	# Force www:
	#RewriteCond %{HTTP_HOST} ^example.com [NC]
	#RewriteRule ^(.*)$ http://www.example.com/$1 [L,R=301,NC]

	# Force non-www:
	#RewriteCond %{HTTP_HOST} ^www\.example\.com [NC]
	#RewriteRule ^(.*)$ http://example.com/$1 [L,R=301]

	# HTTPS
	#RewriteCond %{HTTPS} !=on
 	#RewriteRule ^.*$ https://%{SERVER_NAME}%{REQUEST_URI} [R,L]

	RewriteBase $dir/
	RewriteRule ^index\.php$ - [L]
	RewriteCond %{REQUEST_FILENAME} !-f
	RewriteCond %{REQUEST_FILENAME} !-d
	RewriteRule . $dir/index.php [L]
</IfModule>\n\n";

	// Mas opciones
	$content_string .= '
## EXPIRES CACHING ##
<IfModule mod_expires.c>
	ExpiresActive On
	ExpiresByType image/jpg "access 1 year"
	ExpiresByType image/jpeg "access 1 year"
	ExpiresByType image/gif "access 1 year"
	ExpiresByType image/png "access 1 year"
	ExpiresByType text/css "access 1 month"
	ExpiresByType text/html "access 1 month"
	ExpiresByType application/pdf "access 1 month"
	ExpiresByType text/x-javascript "access 1 month"
	ExpiresByType application/x-shockwave-flash "access 1 month"
	ExpiresByType image/x-icon "access 1 year"
	ExpiresDefault "access 1 month"
</IfModule>

## EXPIRES CACHING ##
<IfModule mod_gzip.c>
	mod_gzip_on Yes
	mod_gzip_item_include file \.html$
	mod_gzip_item_include file \.php$
	mod_gzip_item_include file \.css$
	mod_gzip_item_include file \.js$
	mod_gzip_item_include mime ^application/javascript$
	mod_gzip_item_include mime ^application/x-javascript$
	mod_gzip_item_include mime ^text/.*
	mod_gzip_item_include handler ^application/x-httpd-php
	mod_gzip_item_exclude mime ^image/.*
</IfModule>';
	fwrite($file_handle, $content_string);
	// close
	fclose($file_handle);
}

$directory = str_replace('/rb-install/save.php', '', $_SERVER['SCRIPT_NAME']); //obteniendo sub directorio de instalacion
$opciones_valores = array(
	"nombresitio" => "Nombre Sitio",
	"descripcion" => "Gestionado por Pyro CMS",
	"direccion_url" => "http://",
	"host" => $_SERVER['HTTP_HOST'],
	"meta_keywords" => "",
	"meta_description" => "",
	"tema" => "default",
	"enlaceamigable" => "0",
	"meta_author" => "Pyro CMS",
	"show_items" => "25",
	"background-image" => "0",
	"mail_destination" => "",
	"objetos" => "",
	"mail_sender" => "no-reply@".$_SERVER['HTTP_HOST'],
	"initial" => "0",
	"post_by_category" => "15",
	"t_width" => "280",
	"t_height" => "190",
	"linkregister" => "0",
	"moneda" => "S/.",
	"modules_optiones" => '{"post":"1","cat":0,"pag":0,"com":0,"file":0,"gal":0,"usu":0,"mess":0,"men":0}',
	"post_options" => '{"gal":"0","adj":"1","edi":"0","adi":"0","enl":"0","vid":"0","otr":"0","sub":"1","cal":0}',
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
	"base_gallery" => "galeria",
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
	"name_sender" => "No-Reply",
	"directorio_url" => $directory,
	"menu_panel" => '{"index":{"key":"index","nombre":"Inicio","url":"index.php","url_imagen":"img\/icon_home.png","pos":1,"show":true,"item":null},"blogs":{"key":"blogs","nombre":"Blog","url":"#","url_imagen":"img\/icon_post.png","pos":2,"show":true,"item":[{"key":"art","nombre":"Publicaciones","url":"index.php?pag=art","url_imagen":"none","pos":1},{"key":"cat","nombre":"Categorias","url":"index.php?pag=cat","url_imagen":"none","pos":1}]},"files":{"key":"files","nombre":"Archivos","url":"#","url_imagen":"img\/icon_media.png","pos":3,"show":true,"item":[{"key":"explorer","nombre":"Explorar","url":"index.php?pag=explorer","url_imagen":"none","pos":1},{"key":"gal","nombre":"Galeria de de imagenes","url":"index.php?pag=gal","url_imagen":"none","pos":1}]},"users":{"key":"users","nombre":"Usuarios","url":"#","url_imagen":"img\/icon_user.png","pos":4,"show":true,"item":{"0":{"key":"usu","nombre":"Gestionar","url":"index.php?pag=usu","url_imagen":"none","pos":1},"2":{"key":"men","nombre":"Mensajeria","url":"index.php?pag=men","url_imagen":"none","pos":1},"3":{"key":"nivel","nombre":"Niveles de acceso","url":"index.php?pag=nivel","url_imagen":"none","pos":1}}},"visual":{"key":"visual","nombre":"Contenidos y Estructuras","url":"#","url_imagen":"img\/icon_design.png","pos":5,"show":true,"item":[{"key":"pages","nombre":"Paginas","url":"index.php?pag=pages","url_imagen":"none","pos":1},{"key":"menus","nombre":"Menus","url":"index.php?pag=menus","url_imagen":"none","pos":1},{"key":"editfile","nombre":"Plantilla","url":"index.php?pag=editfile","url_imagen":"none","pos":1}]}}',
	"alcance" => "1",
	"version" => "2.0.6",
	"sidebar" => "0",
	"sidebar_pos" => "left",
	"sidebar_id" => "0",
	"terms_url" => "",
	"index_custom" => "",
	"favicon" => "0",
	"message_config_restrict" => '{"send_users":"0", "receive_users": "0", "admin_users":"0", "notify": 0}',
	"user_superadmin" => '{"admin":"1"}',
	"key_web" => $key_web[0],
	"block_header_ids" => "0",
	"block_footer_ids" => "0",
	"show_terms_register" => "0",
	"pass_security" => "0",
	"more_fields_register" => '{"nombres":"Nombres"}',
	"repet_pass_register" => 0,
	"after_login_url" => "[RUTA_SITIO]?pa=panel",
	"sidebar_id" => 0,
	"files_allowed" => "jpeg,jpg,png,gif,doc,docx,xls,xlsx,pdf,svg"
);

if(isset($_POST)):
	$sitio_titulo = $_POST['sitio_titulo'];
	$sitio_url = $_POST['sitio_url'];
	$usuario_correo = $_POST['usuario_correo'];
	$usuario_pass = $_POST['usuario_pass'];
	$usuario_pass1 = $_POST['usuario_pass1'];

	if($usuario_pass != $usuario_pass1) die("Contraseñas no coinciden");

	/* USUARIO INICIAL */
	$response = $objDataBase->Insertar("INSERT INTO usuarios (nickname, password, nombres, apellidos, correo, tipo, sexo, photo_id)
		VALUES ('admin', '".md5($usuario_pass)."', 'Admin', 'Del Sitio', '$usuario_correo', 1, 'h', 0)");

	if($response['result']==true):
		$usuario_id = $response['insert_id'];

		// ACTIVANDO USUARIO
		$objDataBase->EditarPorCampo('usuarios','activo',1,$usuario_id);

		// Recorrer array de valores para ingresarlos como valores por defecto
		foreach($opciones_valores as $option  => $value){
			$objDataBase->Ejecutar("INSERT INTO opciones (opcion, valor) VALUES ('$option','$value')");
		}

		/* VALORES INICIALES PARA EL BLOG */
		rb_set_values_options( "nombresitio", $sitio_titulo);
		rb_set_values_options( "direccion_url", $sitio_url);
		rb_set_values_options( "mail_destination", $usuario_correo); // correo que le llega forms de contacto
		rb_set_values_options( "name_sender", $sitio_titulo); // Nombre en el correo

		// Niveles de usuarios
		$objDataBase->Ejecutar("INSERT INTO usuarios_niveles (id, nombre, nivel_enlace, descripcion) VALUE (1, 'Administrador', 'admin', 'Administra y gestiona la configuración de TODO el sitio web')");
		$objDataBase->Ejecutar("INSERT INTO usuarios_niveles (id, nombre, nivel_enlace, descripcion) VALUE (2, 'Usuario Gestionador', 'user-panel', 'Usuario con acceso para gestionar solo parte del sitio web')");
		$objDataBase->Ejecutar("INSERT INTO usuarios_niveles (id, nombre, nivel_enlace, descripcion) VALUE (3, 'Usuario Final', 'user-front', 'Usuario final, no tiene acceso a gestionar el sitio web')");

		create_htaccess($directory);
		header('Location: '.$sitio_url."/login.php");
	else:
		die("Problemas a registrar los datos. Si problema persiste consulte el soporte técnico. ".$response['error']);
	endif;
endif;
?>
