<?php
require_once 'rb-script/hook.php';
require_once 'global.php';
require_once 'rb-script/funcs.php';
require_once 'rb-script/class/rb-database.class.php';
require_once 'rb-script/class/rb-users.class.php';

// Carga formato js de la base de datos
$modules_prev = rb_get_values_options('modules_load');

// Convierte json a array
$array_modules = json_decode($modules_prev, true);

// Incluir los modulos externos desde la base de datos
require_once 'rb-script/modules.list.php';

// Cargar los widgets del sistemas y personalizados (de los modulos)
require_once 'rb-admin/widgets.system.php';

// VARIABLES CON DATOS DE CABECERA GENERALES
define('rm_titlesite', G_TITULO);
define('rm_subtitle', G_SUBTITULO);
define('rm_longtitle' , G_TITULO . ( G_SUBTITULO=="" ? "" :  " - ".G_SUBTITULO ));
define('rm_url', G_SERVER);
define('rm_urltheme', G_URLTHEME);
define('rm_datetoday', date("Y-m-d"));

// definiendo clases para el sidebar
$show_sidebar = rb_get_values_options('sidebar');
if($show_sidebar==1){
	$sidebar_align = rb_get_values_options('sidebar_pos');
	if($sidebar_align == 'right'):
		define('class_col_1', "block-left-content");
		define('class_col_2', "block-right-sidebar");
	elseif($sidebar_align == 'left'):
		define('class_col_1', "block-right-content");
		define('class_col_2', "block-left-sidebar");
	endif;
}else{
	define('class_col_1', "block-full");
}

// Verifica en los modulos si hay alguna URL personalizada que direccione a otro lado
do_action('call_modules_url'); // parece dar error al enviar un aviso antes, que aparezcan las cabeceras (20-08-18), modo local, funciona bien. Modo remoto, no.

function message_error($file){
	header( 'Location: '.G_SERVER.'login.php');
}
// SI NO ACCESÓ
if(G_ACCESOUSUARIO==0){
	if(G_ESTILO=="0"){ // Si no hay estilo seleccionado, que se logueo para asignar la plantilla
		header('Location: '.G_SERVER.'login.php');
	}
}
// Si sitio inicial es Privado y no se logueo, manda a loguearse
if(G_ALCANCE==1 && G_ACCESOUSUARIO==0) header('Location: '.G_SERVER.'login.php');

// VALIDAMOS SI TRABAJAMOS CON ENLACES AMIGABLES
if(G_ENL_AMIG):
	// -- Si opcion enlaces amigables e ingresa de manera tradicional, direccionarlo a enlaces amigables.

	// Direccionar a pagina
	if ( isset($_GET['p']) ):
		$Page = rb_show_specific_page( $_GET['p'] );
		header( 'Location: '.G_SERVER.$Page['titulo_enlace'].'/');
		exit();
	endif;

	// Direccionar a gallery G_BASEGALLERY
	if ( isset($_GET['gallery']) ):
		$Gallery = rb_get_info_gallery( $_GET['gallery'] );
		header( 'Location: '.G_SERVER.'galeria/'.$Gallery['nombre_enlace'].'/');
		exit();
	endif;

	//Direccionar en caso de busqueda
	if ( isset($_GET['s']) ):
		header( 'Location: '.G_SERVER.G_BASESEAR.'/'.rb_cambiar_nombre(trim($_GET['s'])).'/' );
		exit();
	endif;

	// Analizamos URL amigable y destripamos sus elementos:

	// Si la web estuviera instalada en un subdirectorio distinto a la raiz
	// debemos obviarlo antes de destriparlo :-)
	$requestURI = str_replace(G_DIRECTORY, "", $_SERVER['REQUEST_URI']);
	// Pasamos la URL a un array que contenga sus elementos delimitados por la barra (slash)
  	$requestURI = explode("/", $requestURI);
	// Indexamos numericamente el array para mas facil consultar
	$requestURI = array_values( array_filter( $requestURI ) );
	$numsItemArray = count($requestURI);
	// Empezamos a hacer las comparaciones
	if( $numsItemArray > 0 ):
		// Si es Usuario ??? Revisar
		if( $requestURI[0] == G_BASEUSER ):
			echo "Usuario"; // En Desarrollo
		endif;
		// Si es Busqueda
		if( $requestURI[0] == G_BASESEAR ):
			$SearchTerm = $requestURI[1];
		endif;
		// Si es Panel ??? Revisar
		if( $requestURI[0] == G_BASESEAR ):
			$SearchTerm = $requestURI[1];
		endif;
		// Si es galeria
		if( $requestURI[0] == "galeria" ): //G_BASEGALLERY
			$GalleryId = $requestURI[1];
		endif;
		// Si es Pagina simple
		if( $numsItemArray == 1 ):
			if( $requestURI[0] == "index.php" ):
				header( 'Location: '.G_SERVER );
				exit();
			endif;
			$PageId = $requestURI[0];
			// Buscamos si existe en la base de datos
		endif;
	endif;
else: // SI ENLACES NO AMIGABLES
	if ( isset($_GET['art']) ) $PostId = $_GET['art'];
	if ( isset($_GET['p']) ) $PageId = $_GET['p'];
	if ( isset($_GET['cat']) ):
	 	$CategoryId = $_GET['cat'];
		if ( isset($_GET['page']) ) $Page = $_GET['page'];
	endif;
	if ( isset($_GET['s']) ) $SearchTerm = $_GET['s'];
	if ( isset($_GET['gallery']) ) $GalleryId = $_GET['gallery'];
	if ( isset($_GET['panel']) ) $Panel = $_GET['panel'];
endif;

// URL adicionales definidos por la plantilla
//require ABSPATH.'rb-themes/'.G_ESTILO.'/urls.php';

// ARCHIVOS DIRECTOS, PAGINAS PERSONALIZADAS
if(isset($_GET['pa'])){
	// Si accede a panel y no esta logueado, manda al index
	if($_GET['pa']=="panel" && G_ACCESOUSUARIO==0):
		header('Location: '. rb_get_values_options('direccion_url') );

	// Si accede a panel y esta logueado, lleva al modulo externo para el panel
	elseif($_GET['pa']=="panel" && G_ACCESOUSUARIO==1):
		define('rm_title_page' , "Panel de usuario");
		define('rm_page_image', G_SERVER.'rb-script/images/gallery-default.jpg');
		define('rm_title' , "Panel de usuario | ".G_TITULO );
		define('rm_metadescription' , "Panel del usuario. Puede editar sus datos personales y recibir notificaciones del sistema aqui." );
		define('rm_metaauthor' , G_TITULO." - ".G_VERSION);
		$rm_menu_name = "";
		require_once ABSPATH.'rb-script/modules/rb-userpanel/panel.php';

	// Si es cualquier pagina, la carga respectivamente
	else:
		$file = ABSPATH.'rb-themes/'.G_ESTILO.'/'.$_GET['pa'].'.php';
		if(file_exists( $file )) require_once( $file );
		else header('Location: '.G_SERVER.'404.php');
	endif;
// PAGINAS
}elseif( isset( $PageId ) ){
	$Page = rb_show_specific_page( $PageId );
	$Photo = rb_get_photo_details_from_id($Page['image_id']);

	// Si no es una pagina del sistema arroja FALSE
	if($Page==false){ // En tal caso es una pagina independiente alojada en la plantilla
		// Primero revisamos si es "panel" (ya que es una pagina reservada del sistema)
		// "panel" en caso NO este logueado
		if($PageId=="panel" && G_ACCESOUSUARIO==0):
			header('Location: '.$objOpcion->obtener_valor(1,'direccion_url'));

		// "panel" en caso esté logueado
		elseif($PageId=="panel" && G_ACCESOUSUARIO==1):
			$rm_menu_name = "";
			require_once ABSPATH.'rb-script/modules/rb-userpanel/panel.php';
		// Si es cualquier pagina, la carga respectivamente
		else:
			$file = ABSPATH.'rb-themes/'.G_ESTILO.'/'.$PageId.'.php';
			if(file_exists( $file )) require_once( $file );
			// En caso no encontrar la pagina arroja error 404
			else header('Location: '.G_SERVER.'404.php');
		endif;
	// Si pagina alojada en el sistema
	}else{ // Asignando valores
		define('rm_title', $Page['titulo']." | ".G_TITULO);
		define('rm_title_page', $Page['titulo']);
		define('rm_page_image', $Photo['file_url']);
	  	define('rm_metakeywords', $Page['tags']);
	  	define('rm_metadescription', rb_fragment_text($Page['description'],30, false));
	  	define('rm_metaauthor', $Page['autor_id']); //--> capturar codigo de usuario

		$show_header = $Page['show_header'];
		$show_footer = $Page['show_footer'];
		$block_header_id = $Page['header_custom_id'];
		$block_footer_id = $Page['footer_custom_id'];
		$rm_url_page = rb_url_link('pag', $Page['id']);

		$file = ABSPATH.'rb-script/modules/pages.view3/page.php';
		if(file_exists( $file )): require_once( $file );//rb_set_read_post($Page['id'], 'paginas');
		else: die( message_error($file));
		endif;
	}
// BUSQUEDA
}elseif( isset( $SearchTerm ) ){
	$data_to_search = $SearchTerm;

	/*search articulos*/
	$qs = $objDataBase->Search($data_to_search, 'articulos', ['titulo', 'contenido']);
	$CountPosts = $qs->num_rows;

	define('rm_title',"Buscando ".$data_to_search." | ".G_TITULO);
	define('rm_title_page',"Buscando ".$data_to_search);
	define('rm_page_image', rb_photo_login(G_LOGO));
	define('rm_metakeywords', "");
	define('rm_metadescription', "Resultados de busqueda");
	define('rm_metaauthor',G_METAAUTHOR);

	$file = ABSPATH.'rb-themes/'.G_ESTILO.'/search.php';
	if(file_exists( $file )) require_once( $file );
	else die( message_error($file));

// GALERIA DE IMAGENES
}elseif( isset( $GalleryId ) ){
	$gallery = rb_get_info_gallery($GalleryId);
	$fotos = rb_get_images_from_gallery($GalleryId);

	define('rm_title',"Fotos de ".$gallery['nombre']." | ".G_TITULO);
	define('rm_title_page',"Fotos de ".$gallery['nombre']);
	define('rm_page_image', rb_photo_login(G_LOGO));
	define('rm_metakeywords', "");
	define('rm_metadescription', "Galería de fotos de ".$gallery['nombre']);
	define('rm_metaauthor',G_METAAUTHOR);

	$file = ABSPATH.'rb-themes/'.G_ESTILO.'/gallery.php';
	if(file_exists( $file )) require_once( $file );
	else die( message_error($file));

// AL MODULO : PANEL DE USUARIO
}elseif( isset( $Panel ) ){
	if(G_ACCESOUSUARIO==1){
		require_once ABSPATH.'rb-script/modules/rb-userpanel/panel.php';
	}else{
		header('Location: '.rb_get_values_options('direccion_url').'/login.php');
	}
}else{
	// PAGINA PRINCIPAL - INDEX
	if(G_INITIAL==0){
		// Pagina principal de la plantilla, Pagina de bienvenida por defecto
		define('rm_title', G_TITULO);
		define('rm_metadescription', G_METADESCRIPTION);
		define('rm_metaauthor', G_METAAUTHOR);
		define('rm_page_image', rb_favicon(G_FAVICON));

		$file = ABSPATH.'rb-themes/'.G_ESTILO.'/index.php';
		if(file_exists( $file )) require_once( $file );
		else die( message_error($file));
	}else{ 
		// Pagina principal personalizada seleccionada por el usuario
	  	$Page = rb_show_specific_page(G_INITIAL);

		define('rm_title', rm_longtitle);
		define('rm_title_page', $Page['titulo']);
		define('rm_page_image', rb_favicon(G_FAVICON));
		define('rm_metadescription', rb_get_values_options('meta_description'));
		define('rm_metaauthor', $Page['autor_id']); //--> capturar codigo de usuario
	  	define('rm_metakeywords', $Page['tags']);

		$show_header = $Page['show_header'];
		$show_footer = $Page['show_footer'];
		$block_header_id = $Page['header_custom_id'];
		$block_footer_id = $Page['footer_custom_id'];

	  	$file = ABSPATH.'rb-script/modules/pages.view3/page.php';
		if(file_exists( $file )) require_once( $file );
		else die( message_error($file));
	}
}
?>
