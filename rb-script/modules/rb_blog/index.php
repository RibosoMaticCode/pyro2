<?php
/*
Module Name: Blog
Plugin URI: http://emocion.pe
Description: Gestiona publicaciones divididas en categorias
Author: Jesus Liñan
Version: 1.1
Author URI: http://ribosomatic.com
*/

// Valores iniciales
$rb_modure_dir = "rb_blog";
$rb_module_url = G_SERVER."rb-script/modules/$rb_modure_dir/";
$rb_module_url_img = G_SERVER."rb-script/modules/$rb_modure_dir/blog.png";

// Ubicacion en el Menu
$menu1 = [
	'key' => 'rb_blog',
	'nombre' => "Blog",
	'url' => "#",
	'url_imagen' => $rb_module_url_img,
	'pos' => 1,
	'show' => true,
	'item' => [
		[
			'key' => 'rb_blog_pubs',
			'nombre' => "Publicaciones",
			'url' => "module.php?pag=rb_blog_pubs",
			'url_imagen' => "none",
			'pos' => 1
		],
		[
			'key' => 'rb_blog_category',
			'nombre' => "Categorias",
			'url' => "module.php?pag=rb_blog_category",
			'url_imagen' => "none",
			'pos' => 2
		],
		[
			'key' => 'rb_blog_config',
			'nombre' => "Configuracion",
			'url' => "module.php?pag=rb_blog_config",
			'url_imagen' => "none",
			'pos' => 3
		]
	]
];

$menu = [
	"rb_blog" => $menu1
];

// Widget para añadir a paginas
$widget = [
  'link_action' => 'addPost1',
  'dir' => 'rb_blog',
  'name' => 'Publicaciones',
  'desc' => 'Muestra un bloque de publicaciones',
  'filejs' => 'file.js',
  'img_abs' => $rb_module_url.'widget.pub.png',
	'file' => 'widget.pubs.php',
	'type' => 'post1',
	'custom' => true
];
array_push($widgets, $widget);

// Administracion

// Añdir los Configuradores de los widgets
function rb_blog_block_config(){
	global $rb_module_url;
	include_once 'widget.pubs.conf.php';
}
add_function('modals-config','rb_blog_block_config');

// ------ PUBLICACIONES ------ //
if(isset($_GET['pag']) && $_GET['pag']=="rb_blog_pubs"):
	function rb_blog_pubs_title(){
		return "Publicaciones";
	}
	function rb_blog_pubs(){
		global $rb_module_url;
		global $userType;
		global $objDataBase;
		if(isset($_GET['pub_id'])){
			include_once 'pubs.edit.php';
		}else{
			global $array_help_close;
			include_once 'pubs.init.php';
		}
	}
	add_function('module_title_page','rb_blog_pubs_title');
	add_function('module_content_main','rb_blog_pubs');
endif;

// ------ CATEGORIAS ------ //
if(isset($_GET['pag']) && $_GET['pag']=="rb_blog_category"):
	function rb_blog_cat_title(){
		return "Categorias de publicaciones";
	}
	function rb_blog_cat(){
		global $rb_module_url;
		global $userType;
		global $objDataBase;
		if(isset($_GET['cat_id'])){
			include_once 'categories.edit.php';
		}else{
			global $array_help_close;
			include_once 'categories.init.php';
		}
	}
	add_function('module_title_page','rb_blog_cat_title');
	add_function('module_content_main','rb_blog_cat');
endif;

// ------ CONFIGURACIN PRODUCTOS ------ //
if(isset($_GET['pag']) && $_GET['pag']=="rb_blog_config"):
	function rb_blog_config_title(){
		return "Configuracion de Publicaciones";
	}
	function rb_blog_config(){
		global $rb_module_url;
		include_once 'config.php';
	}
	add_function('module_title_page','rb_blog_config_title');
	add_function('module_content_main','rb_blog_config');
endif;

// ---------------- URL FRIENDLY --------------------- //
function rb_blog_call_url(){
	include_once 'funcs.php';
	$base_pub = blog_get_option("base_publication");
	$base_cat = blog_get_option("base_category");
	$PostAll = false;
	if(G_ENL_AMIG):
		//Direccionar no amigable a amigable publicacion
		if ( isset($_GET['art']) ):
			$Post = rb_show_post( $_GET['art'], false );
			header( 'Location: '.$Post['url'] );
			exit();
		endif;

		// Direccionar no amigable a amigable categoria
		if ( isset($_GET['cat']) ):
			$CategoryId = $_GET['cat'];
			$Categoria = rb_get_category_info($CategoryId);
			header( 'Location: '.G_SERVER.$base_cat.'/'.$Categoria['nombre_enlace'].'/');
			exit();
		endif;

		// Destripar la url
		$requestURI = str_replace(G_DIRECTORY, "", $_SERVER['REQUEST_URI']);
	  $requestURI = explode("/", $requestURI);
		$requestURI = array_values( array_filter( $requestURI ) );
		$numsItemArray = count($requestURI);

		if( $numsItemArray > 0 ):
			// Si es Post - Articulos - Publicacion
			if( $requestURI[0] == $base_pub ):
				if(isset($requestURI[1])){
					$PostId = $requestURI[1];
				}else{
					$PostAll = true;
				}
			endif;
			// Si es Categoria
			if( $requestURI[0] == $base_cat ):
				$num_parts = count($requestURI);
				if( $num_parts == 4):
					$CategoryId = $requestURI[1];
					$Page = $requestURI[3];
				else:
					$CategoryId = $requestURI[1];
				endif;
			endif;
		endif;
	else: // SI ENLACES NO AMIGABLES
		if ( isset($_GET['art']) && $_GET['art'] > 0 && $_GET['art'] != "") :
			$PostId = $_GET['art'];
		elseif( isset($_GET['art'])):
			$PostAll = true;
		endif;
		if ( isset($_GET['cat']) ):
		 	$CategoryId = $_GET['cat'];
			if ( isset($_GET['page']) ) $Page = $_GET['page'];
		endif;
	endif;

	// Datos del usuario del sistema
	if(G_ACCESOUSUARIO==1):
		$user = rb_get_user_info(G_USERID);
		define('rm_usernick', $user['nickname']);
		define('rm_usernames', $user['nombres']);
		define('rm_userlastnames', $user['apellidos']);
		define('rm_userimgid', $user['photo_id']);
	endif;

	// MOSTRAR PUBLICACION SEGUN SU ID
	if(isset( $PostId )){
		$Post = rb_show_post( $PostId );
		if(!$Post) header('Location: '.G_SERVER.'404.php');

		// VALORES DE CABECERA DEL POST
		define('rm_title' , $Post['titulo']." | ".G_TITULO);
		define('rm_title_page' , $Post['titulo']);
		define('rm_page_image', $Post['url_img_pri_max']);
		define('rm_metadescription' , rb_fragment_text($Post['contenido'],30, false) );
		define('rm_metaauthor' , $Post['autor_id']); //--> capturar codigo de usuario
		$rm_url_page = $Post['url'];
		$rm_menu_name = "";
		$rm_url_page_img = $Post['url_img_por_max'];

		// CATEGORIA
		$qc = rb_get_category_by_post_id($Post['id']);
		$Cat = $qc->fetch_assoc();
		$Categoria_id = $Cat['id'];

		$file = ABSPATH.'rb-script/modules/rb_blog/frontend.pub.php';
		if(file_exists( $file )): require_once( $file );rb_set_read_post($Post['id'], 'articulos');
		else: die( message_error($file));
		endif;
		die();
	}

	// CATEGORIAS
	if( isset($CategoryId) ){
		$num_posts_page = blog_get_option('num_pubs_by_pages');
		// Verificar si paginacion esta definida
		if( isset( $Page ) ):
			$CurrentPage = $Page;
			$RegStart = ($CurrentPage-1)*$num_posts_page;
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

		$CountPostAll = rb_nums_post_by_category( $categoria_id );

		$TotalPage = floor($CountPostAll / $num_posts_page);

		if($CountPostAll % $num_posts_page) $TotalPage++;
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

		$Posts = rb_get_post_by_category($categoria_id);
		$file = ABSPATH.'rb-script/modules/rb_blog/frontend.pubs.category.php';
		if(file_exists( $file )) require_once( $file );
		else die( message_error($file));
		die();
	}

	// TODAS LAS PUBLICACIONES
	if( $PostAll ){
		define('rm_title', rm_longtitle);
		define('rm_title_page', "Publicaciones");
		define('rm_page_image', rb_photo_login(G_LOGO));
		define('rm_metadescription', G_METADESCRIPTION);
		define('rm_metaauthor', "Blackpyro");
		$rm_menu_name = "m-inicio";

		$file = ABSPATH.'rb-script/modules/rb_blog/frontend.pubs.all.php';
		if(file_exists( $file )) require_once( $file );
		else die( message_error($file));
		die();
	}
}
add_function('call_modules_url','rb_blog_call_url');

// Frontend CSS
function blog_css(){
  global $rb_modure_dir;
	$css = "<link rel='stylesheet' href='".G_DIR_MODULES_URL.$rb_modure_dir."/blog.css'>\n";
	return $css;
}
add_function('theme_header','blog_css');
