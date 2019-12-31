<?php
header('Content-type: application/json; charset=utf-8');
/*
* Instalador: Establece valores iniciales em la tabla Opciones
* Ultima actualizacion : 24-01-17
*/
//require_once("../global.php");
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(__FILE__)) . '/');

require_once ABSPATH.'rb-script/funcs.php';
require_once ABSPATH.'rb-script/class/rb-database.class.php';

define('G_PREFIX', 'py_');
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
	# Para evitar errores con vinculos de facebook
	# RewriteCond %{QUERY_STRING} \"fbclid=\" [NC]
	# RewriteRule (.*) $dir/$1? [R=301,L]

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
	/*"base_publication" => "articulo",
	"base_category" => "categoria",*/
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
	"menu_panel" => '{"index":{"key":"index","nombre":"Inicio","url":"index.php","url_imagen":"img\/icon_home.png","pos":1,"show":true,"item":null},"files":{"key":"files","nombre":"Archivos","url":"#","url_imagen":"img\/icon_media.png","pos":3,"show":true,"item":[{"key":"explorer","nombre":"Explorar","url":"index.php?pag=explorer","url_imagen":"none","pos":1},{"key":"gal","nombre":"Galeria de imagenes","url":"index.php?pag=gal","url_imagen":"none","pos":1}]},"users":{"key":"users","nombre":"Usuarios","url":"#","url_imagen":"img\/icon_user.png","pos":4,"show":true,"item":{"0":{"key":"usu","nombre":"Gestionar","url":"index.php?pag=usu","url_imagen":"none","pos":1},"2":{"key":"men","nombre":"Mensajeria","url":"index.php?pag=men","url_imagen":"none","pos":1},"3":{"key":"nivel","nombre":"Niveles de acceso","url":"index.php?pag=nivel","url_imagen":"none","pos":1}}},"visual":{"key":"visual","nombre":"Contenidos","url":"#","url_imagen":"img\/icon_design.png","pos":5,"show":true,"item":[{"key":"pages","nombre":"Paginas","url":"index.php?pag=pages","url_imagen":"none","pos":1},{"key":"menus","nombre":"Menus","url":"index.php?pag=menus","url_imagen":"none","pos":1},{"key":"editfile","nombre":"Plantilla","url":"index.php?pag=editfile","url_imagen":"none","pos":1}]}}',
	"alcance" => "1",
	"version" => "3.0.0",
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
	"files_allowed" => "jpeg,jpg,png,gif,doc,docx,xls,xlsx,pdf,svg",
	"gallery_groups" => "",
	"water_mark_image" => 0
);

if(isset($_POST)):
	// Validaciones
	$sitio_titulo = $_POST['sitio_titulo'];
	if($sitio_titulo==""){
		$response = ['result' => false, 'message' => 'Especifique un titulo a su sitio web'];
		die(json_encode($response));
	}
	$sitio_url = $_POST['sitio_url'];
	if($sitio_url==""){
		$response = ['result' => false, 'message' => 'La url no su sitio web no debe quedar en blanco'];
		die(json_encode($response));
	}
	$usuario_correo = $_POST['usuario_correo'];
	if(!filter_var($usuario_correo, FILTER_VALIDATE_EMAIL)){
		$response = ['result' => false, 'message' => 'Ingrese un correo válido'];
		die(json_encode($response));
	}
	$usuario_pass = $_POST['usuario_pass'];
	if ( !rb_valid_pass($usuario_pass) ){
		$response = ['result' => false, 'message' => 'La contraseña debe tener al entre 8 y 16 caracteres, al menos un dígito, al menos una minúscula y al menos una mayúscula. Puede tener otros símbolos.'];
		die(json_encode($response));
	}
	$usuario_pass1 = $_POST['usuario_pass1'];
	if ( !rb_valid_pass($usuario_pass1) ){
		$response = ['result' => false, 'message' => 'La contraseña debe tener al entre 8 y 16 caracteres, al menos un dígito, al menos una minúscula y al menos una mayúscula. Puede tener otros símbolos.'];
		die(json_encode($response));
	}
	if($usuario_pass != $usuario_pass1){
		$response = ['result' => false, 'message' => 'Las contraseñas no coinciden'];
		die(json_encode($response));
	}

	/*$objDataBase = new DataBase;
	// Creamos la estructura de la base de datos
	$query_db = file_get_contents("_sql/pyro3.sql");
	$conexion = $objDataBase->conexion();
	$stmt = $conexion->prepare($query_db);
	if( $stmt->execute() ):
		$response = ['result' => false, 'message' => 'Error al ejecutar script de base de datos'];
		die(json_encode($response));
	endif;*/

	function createDB($filename){
		// https://dev.to/erhankilic/how-to-import-sql-file-with-php--1jbc
		global $objDataBase;
		// Temporary variable, used to store current query
		$conexion = $objDataBase->Conexion();
		$templine = '';
		// Read in entire file
		$lines = file($filename);
		// Loop through each line
		foreach ($lines as $line) {
		// Skip it if it's a comment
		    if (substr($line, 0, 2) == '--' || $line == '')
		        continue;

		// Add this line to the current segment
		    $templine .= $line;
		// If it has a semicolon at the end, it's the end of the query
		    if (substr(trim($line), -1, 1) == ';') {
		        // Perform the query
		        $objDataBase->Ejecutar($templine) or print('Error performing query ' . $templine . ': ' .  $conexion->connect_errno.$conexion->error . '<br /><br />');
						/*if(!$objDataBase->Ejecutar($templine)){
							return "error:".$conexion->error;
						}*/
						// or print('Error performing query \'<strong>' . $templine . '\': ' . $con->error() . '<br /><br />');
		        // Reset temp variable to empty
		        $templine = '';
		    }
		}
		return true;
	}
	createDB("_sql/pyro3.sql");
	/* Creamos al usuario admin */
	$query_user = $objDataBase->Insertar("INSERT INTO ".G_PREFIX."users (nickname, password, nombres, apellidos, correo, tipo, sexo, photo_id)
		VALUES ('admin', '".md5($usuario_pass)."', 'Admin', 'Del Sitio', '$usuario_correo', 1, 'h', 0)");

	if($query_user['result']==true):
		$usuario_id = $query_user['insert_id'];

		// ACTIVANDO USUARIO
		$objDataBase->EditarPorCampo(G_PREFIX."users",'activo',1,$usuario_id);

		// Recorrer array de valores para ingresarlos como valores por defecto
		foreach($opciones_valores as $option  => $value){
			$objDataBase->Ejecutar("INSERT INTO ".G_PREFIX."configuration (option_name, value) VALUES ('$option','$value')");
		}

		/* VALORES INICIALES PARA EL BLOG */
		rb_set_values_options( "nombresitio", $sitio_titulo);
		rb_set_values_options( "direccion_url", $sitio_url);
		rb_set_values_options( "mail_destination", $usuario_correo); // correo que le llega forms de contacto
		rb_set_values_options( "name_sender", $sitio_titulo); // Nombre en el correo

		// Niveles de usuarios
		$objDataBase->Ejecutar("INSERT INTO ".G_PREFIX."users_levels (id, nombre, nivel_enlace, descripcion) VALUE (1, 'Administrador', 'admin', 'Administra y gestiona la configuración de TODO el sitio web')");
		$objDataBase->Ejecutar("INSERT INTO ".G_PREFIX."users_levels (id, nombre, nivel_enlace, descripcion) VALUE (2, 'Usuario Gestionador', 'user-panel', 'Usuario con acceso para gestionar solo parte del sitio web')");
		$objDataBase->Ejecutar("INSERT INTO ".G_PREFIX."users_levels (id, nombre, nivel_enlace, descripcion) VALUE (3, 'Usuario Final', 'user-front', 'Usuario final, no tiene acceso a gestionar el sitio web')");

		create_htaccess($directory);

		// Crear directorio para la plantilla y asignarlo por defecto
		rb_recurse_copy(ABSPATH.'rb-themes/default', ABSPATH.'rb-themes/'.rb_cambiar_nombre($sitio_titulo));
		rb_set_values_options( "tema", rb_cambiar_nombre($sitio_titulo));

		$response = ['result' => true, 'message' => 'Instalación completa. Sera redireccionado...', 'details' => 'Procesos sin errores'];
		die(json_encode($response));
	else:
		//die("Problemas a registrar los datos. Si problema persiste consulte el soporte técnico. ".$query_user['error']);
		$response = ['result' => false, 'message' => 'Error al ejecutar script de base de datos', 'details' => $query_user['error']];
		die(json_encode($response));
	endif;
endif;
?>
