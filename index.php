<?php
require_once 'rb-admin/hook.php';
require_once 'global.php';
require_once 'rb-script/funciones.php';
require_once 'rb-script/class/rb-database.class.php';
require_once 'rb-script/class/rb-usuarios.class.php';

// Carga formato js de la base de datos
$modules_prev = rb_get_values_options('modules_load');

// Convierte json a array
$array_modules = json_decode($modules_prev, true);

require_once 'rb-admin/modules.list.php';

// VARIABLES CON DATOS DE CABECERA GENERALES
define('rm_titlesite', G_TITULO);
define('rm_subtitle', G_SUBTITULO);
define('rm_longtitle' , G_TITULO . ( G_SUBTITULO=="" ? "" :  " - ".G_SUBTITULO ));
define('rm_url', G_SERVER."/" );
define('rm_urltheme', G_URLTHEME."/");
define('rm_datetoday', date("Y-m-d"));

// Verifica en los modulos si hay alguna URL personalizada que direccione a otro lado
do_action('call_modules_url'); // parece dar error al enviar un aviso antes, que aparezcan las cabeceras (20-08-18), modo local, funciona bien. Modo remoto, no.

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
	//$class_col_1 = " block-full ";
}
function message_error($file){
	header( 'Location: '.G_SERVER.'/login.php');
}
// SI NO ACCESÓ
if(G_ACCESOUSUARIO==0){
	if(G_ESTILO=="0"){ // Si no hay estilo seleccionado, que se logueo para asignar la plantilla
		header('Location: '.G_SERVER.'/login.php');
	}
}
// Si sitio inicial es Privado y no se logueo, manda a loguearse
if(G_ALCANCE==1 && G_ACCESOUSUARIO==0) header('Location: '.G_SERVER.'/login.php');

// VALORES SI INICIA SESION USUARIO - Datos del usuario que inicio sesion
if(G_ACCESOUSUARIO==1):
	$user = rb_get_user_info(G_USERID);
	define('rm_usernick', $user['nickname']);
	define('rm_usernames', $user['nombres']);
	define('rm_userlastnames', $user['apellidos']);
	define('rm_userimgid', $user['photo_id']);
endif;

// VALIDAMOS SI TRABAJAMOS CON ENLACES AMIGABLES
if(G_ENL_AMIG):
	// -- Si opcion enlaces amigables e ingresa de manera tradicional, direccionarlo a enlaces amigables.
	//Direccionar a publicacion
	if ( isset($_GET['art']) ):
		$Post = rb_show_post( $_GET['art'], false );
		header( 'Location: '.$Post['url'] );
		exit();
	endif;

	// Direccionar a pagina
	if ( isset($_GET['p']) ):
		$Page = rb_show_specific_page( $_GET['p'] );
		header( 'Location: '.G_SERVER.'/'.$Page['titulo_enlace'].'/');
		exit();
	endif;

	// Direccionar a gallery G_BASEGALLERY
	if ( isset($_GET['gallery']) ):
		$Gallery = rb_get_info_gallery( $_GET['gallery'] );
		header( 'Location: '.G_SERVER.'/galeria/'.$Gallery['nombre_enlace'].'/');
		exit();
	endif;

	// Direccionar categoria
	if ( isset($_GET['cat']) ):
		$CategoryId = $_GET['cat'];
		$Categoria = rb_get_category_info($CategoryId);
		header( 'Location: '.G_SERVER.'/'.G_BASECAT.'/'.$Categoria['nombre_enlace'].'/');
		exit();
	endif;

	//Direccionar en caso de busqueda
	if ( isset($_GET['s']) ):
		header( 'Location: '.G_SERVER.'/'.G_BASESEAR.'/'.rb_cambiar_nombre(trim($_GET['s'])).'/' );
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
		// Si es Post - Articulos - Publicacion
		if( $requestURI[0] == G_BASEPUB ):
			$PostId = $requestURI[1];
		endif;
		// Si es Categoria
		if( $requestURI[0] == G_BASECAT ):
			$num_parts = count($requestURI);
			if( $num_parts == 4):
				$CategoryId = $requestURI[1];
				$Page = $requestURI[3];
			else:
				$CategoryId = $requestURI[1];
			endif;
		endif;
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
require ABSPATH.'rb-temas/'.G_ESTILO.'/urls.php';

// ARCHIVOS DIRECTOS, PAGINAS PERSONALIZADAS
if(isset($_GET['pa'])){
	// Si accede a panel y no esta logueado, manda al index
	if($_GET['pa']=="panel" && G_ACCESOUSUARIO==0):
		header('Location: '. rb_get_values_options('direccion_url') );

	// Si accede a panel y esta logueado, lleva al modulo externo para el panel
	elseif($_GET['pa']=="panel" && G_ACCESOUSUARIO==1):
		define('rm_title_page' , "Panel de usuario");
		define('rm_page_image', G_SERVER.'/rb-script/images/gallery-default.jpg');
		define('rm_title' , "Panel de usuario | ".G_TITULO );
		//define('rm_metadescription' , rb_get_values_options('descripcion') );
		define('rm_metadescription' , "Panel del usuario. Puede editar sus datos personales y recibir notificaciones del sistema aqui." );
		define('rm_metaauthor' , G_TITULO." - ".G_VERSION);
		$css_add = [
			'/rb-script/modules/rb-userpanel/paneluser.css'
		];
		define('rm_css', $css_add);
		$rm_menu_name = "";
		require_once ABSPATH.'rb-script/modules/rb-userpanel/panel.php';

	// Si es cualquier pagina, la carga respectivamente
	else:
		$file = ABSPATH.'rb-temas/'.G_ESTILO.'/'.$_GET['pa'].'.php';
		if(file_exists( $file )) require_once( $file );
		else header('Location: '.G_SERVER.'/404.php');
	endif;
// PUBLICACIONES
}elseif(isset( $PostId )){
	$Post = rb_show_post( $PostId );
	if(!$Post) header('Location: '.G_SERVER.'/404.php');

	// VALORES DE CABECERA DEL POST
	define('rm_title' , $Post['titulo']." | ".G_TITULO);
	define('rm_title_page' , $Post['titulo']);
	define('rm_page_image', $Post['url_img_por_max']);
	define('rm_metadescription' , rb_fragment_text($Post['contenido'],30, false) );
	define('rm_metaauthor' , $Post['autor_id']); //--> capturar codigo de usuario
	$rm_url_page = $Post['url'];
	$rm_menu_name = "";
	$rm_url_page_img = $Post['url_img_por_max'];

	// CATEGORIA
	$qc = rb_get_category_by_post_id($Post['id']);
	$Cat = $qc->fetch_assoc();
	$Categoria_id = $Cat['id'];

	$file = ABSPATH.'rb-temas/'.G_ESTILO.'/post.php';
	if(file_exists( $file )): require_once( $file );rb_set_read_post($Post['id'], 'articulos');
	else: die( message_error($file));
	endif;

// PAGINAS
}elseif( isset( $PageId ) ){
	$Page = rb_show_specific_page( $PageId );
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
			$file = ABSPATH.'rb-temas/'.G_ESTILO.'/'.$PageId.'.php';
			if(file_exists( $file )) require_once( $file );
			// En caso no encontrar la pagina arroja error 404
			else header('Location: '.G_SERVER.'/404.php');
		endif;
	// Si pagina alojada en el sistema
	}else{ // Asignando valores
		define('rm_title', $Page['titulo']." | ".G_TITULO);
		define('rm_title_page', $Page['titulo']);
		define('rm_page_image', rb_photo_login(G_LOGO)); // IMAGEN PARA PAGINA
	  	define('rm_metakeywords', $Page['tags']);
	  	define('rm_metadescription', rb_fragment_text($Page['description'],30, false));
	  	define('rm_metaauthor', $Page['autor_id']); //--> capturar codigo de usuario

		$show_header = $Page['show_header'];
		$show_footer = $Page['show_footer'];
		$block_header_id = $Page['header_custom_id'];
		$block_footer_id = $Page['footer_custom_id'];
		$rm_url_page = rb_url_link('pag', $Page['id']);

		$file = ABSPATH.'rb-script/modules/pages.view3/page.php';
		if(file_exists( $file )): require_once( $file );rb_set_read_post($Page['id'], 'paginas');
		else: die( message_error($file));
		endif;
	}
// CATEGORIAS
}elseif( isset($CategoryId) ){
	// Verificar si pagina esta definida
	if( isset( $Page ) ):
		$CurrentPage = $Page;
		$RegStart = ($CurrentPage-1)*G_POSTPAGE;
		$NextPage = $CurrentPage+1;
		$PrevPage = $CurrentPage-1;
	else:
		$CurrentPage = 1;
		$RegStart = 0;
		$NextPage = 2;
		$PrevPage = 0;
	endif;
	$Categoria = rb_get_category_info($CategoryId);
	$categoria_id = $Categoria['id'];
	$rm_menu_name = $Categoria['nombre_enlace'];

	//$Posts = rb_get_post_by_category($CategoryId, G_POSTPAGE, $RegStart);
	$CountPostAll = rb_nums_post_by_category( $categoria_id );

	$TotalPage = floor($CountPostAll / G_POSTPAGE);

	if($CountPostAll % G_POSTPAGE) $TotalPage++;
	$LastPage = $TotalPage;

	if($NextPage > $TotalPage) $NextPage = 0;
	if($CurrentPage == $TotalPage) $LastPage = 0;

	define('rm_title', $Categoria['nombre']." | ".G_TITULO);
	define('rm_title_page', $Categoria['nombre']);
	define('rm_page_image', $Categoria['photo_id']); // foto de categoria
	define('rm_metakeywords',  $Categoria['nombre']);
	define('rm_metadescription',  $Categoria['descripcion']);
	define('rm_metaauthor', G_METAAUTHOR);
	define('rm_url_page', rb_url_link('cat', $categoria_id));

	$Photo = rb_get_photo_from_id( $Categoria['photo_id'] );
	if($Photo) $rm_url_page_img = $rm_url."rb-media/gallery/".$Photo['src'];

	$Posts = rb_get_post_by_category($categoria_id, false, true);
	$file = ABSPATH.'rb-temas/'.G_ESTILO.'/category.php';
	if(file_exists( $file )) require_once( $file );
	else die( message_error($file));

// BUSQUEDA
}elseif( isset( $SearchTerm ) ){
	$data_to_search = $SearchTerm;

	/*search articulos*/
	$qs = $objDataBase->Search($data_to_search, 'articulos', ['titulo', 'contenido']);
	$CountPosts = $qs->num_rows;

	//$CountTotal = $CountPosts + $CountPages;

	define('rm_title',"Buscando ".$data_to_search." | ".G_TITULO);
	define('rm_title_page',"Buscando ".$data_to_search);
	define('rm_page_image', rb_photo_login(G_LOGO));
	define('rm_metakeywords', "");
	define('rm_metadescription', "Resultados de busqueda");
	define('rm_metaauthor',G_METAAUTHOR);

	$file = ABSPATH.'rb-temas/'.G_ESTILO.'/search.php';
	if(file_exists( $file )) require_once( $file );
	else die( message_error($file));

// GALERIA DE IMAGENES
}elseif( isset( $GalleryId ) ){
	//$gallery_id = $_GET['gallery_id'];
	$gallery = rb_get_info_gallery($GalleryId);
	$fotos = rb_get_images_from_gallery($GalleryId);

	define('rm_title',"Fotos de ".$gallery['nombre']." | ".G_TITULO);
	define('rm_title_page',"Fotos de ".$gallery['nombre']);
	define('rm_page_image', rb_photo_login(G_LOGO));
	define('rm_metakeywords', "");
	define('rm_metadescription', "Galería de fotos de ".$gallery['nombre']);
	define('rm_metaauthor',G_METAAUTHOR);

	$file = ABSPATH.'rb-temas/'.G_ESTILO.'/gallery.php';
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
	// ** PAGINA INDEX DEL TEMA MUESTRA EN BLOG POR DEFECTO **
	if(G_INITIAL==0){
		// todas las publicaciones
		$qAll = $objDataBase->Ejecutar("SELECT *, DATE_FORMAT(fecha_creacion, '%Y-%m-%d') as fecha_corta FROM articulos WHERE activo='A' ORDER BY fecha_creacion DESC LIMIT 12");

		// post destacados
		$qStarred = $objDataBase->Ejecutar("SELECT *, DATE_FORMAT(fecha_creacion, '%Y-%m-%d') as fecha_corta FROM articulos WHERE activo='A' and portada=1 ORDER BY fecha_creacion DESC LIMIT 3");

		define('rm_title', rm_longtitle);
		define('rm_page_image', rb_photo_login(G_LOGO));
		define('rm_metadescription', G_METADESCRIPTION);
		define('rm_metaauthor', "Blackpyro");
		$rm_menu_name = "m-inicio";

		$file = ABSPATH.'rb-temas/'.G_ESTILO.'/index.php';
		if(file_exists( $file )) require_once( $file );
		else die( message_error($file));
	}else{ // Pagina seleccionada por el usuario
	  	$Page = rb_show_specific_page(G_INITIAL);
		define('rm_title', rm_longtitle);
		define('rm_title_page', $Page['titulo']);
		define('rm_page_image', rb_photo_login(G_LOGO));
		define('rm_metadescription', ''); //rb_fragment_text($Page['contenido'],30, false)
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
