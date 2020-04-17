<?php
/*
Module Name: Aula Virtual
Plugin URI: http://emocion.pe
Description: Gestion una aula virtula basica
Author: Jesus Liñan
Version: 1.0
Author URI: https://wwww.ribosomatic.com
*/

//include_once 'vars.php';

// Personalizar estructura del Menu
$menu1 = array(
	'key' => 'aulavirtual',
	'nombre' => "Aula Virtual",
	'url' => "#",
	'url_imagen' => $rb_module_url_img,
	'pos' => 1,
	'extend' => false,
	'show' => true,
	'item' => array(
		array(
			'key' => 'aula_contenidos',
			'nombre' => "Contenidos",
			'url' => "module.php?pag=aula_contenidos",
			'url_imagen' => "none",
			'pos' => 1
		)
	)
);

$menu = [
	"aulavirtual" => $menu1
];
// Funciones iniciales


// ------ FUNCIONES PARA EL FRONT-END ------ //
function aula_header_files(){
	global $rb_module_url;
	$files = "<link rel='stylesheet' type='text/css' href='".G_DIR_MODULES_URL."aulavirtual/contenidos.css' />\n";
	return $files;
}
add_function('panel_header_css','aula_header_files');

// ------ CONTENIDOS ------ //
if(isset($_GET['pag']) && $_GET['pag']=="aula_contenidos"):
	function aula_contenidos_titulo(){
		return "Aula virtual contenidos";
	}

	if(isset($_GET['id'])){
		function aula_contenidos_listado(){
			global $rb_module_url;
			include_once 'contenido.frmedit.php';
		}
		add_function('module_title_page','aula_contenidos_titulo');
		add_function('module_content_main','aula_contenidos_listado');

	}else{
		function aula_contenidos_listado(){
			global $rb_module_url, $objDataBase;
			$padre_id = 0;
			$q = "SELECT * FROM aula_contenidos WHERE padre_id=".$padre_id;
			$r = $objDataBase->Ejecutar($q);
			include_once 'contenidos.php';
		}
		add_function('module_title_page','aula_contenidos_titulo');
		add_function('module_content_main','aula_contenidos_listado');
	}
endif;

// ------ FUNCIONES PARA EL FRONT-END ------ //
function aula_contenidos_front_css(){
	global $rb_module_url;
	$front_files = "<link rel='stylesheet' type='text/css' href='".G_DIR_MODULES_URL."aulavirtual/contenidos.frontend.css' />\n";
	return $front_files;
}
add_function('theme_header','aula_contenidos_front_css');

// ------ VISUALIZACION USUARIO ------ //

function aula_contenidos_call_url(){
	require 'funcs.php';
	global $objDataBase;
	$requestURI = str_replace(G_DIRECTORY, "", $_SERVER['REQUEST_URI']);
	$requestURI = explode("/", $requestURI);
	$requestURI = array_values( array_filter( $requestURI ) );
	$numsItemArray = count($requestURI);

	if( $numsItemArray > 0 ):
		//$Section = $requestURI[0];
		switch ( $requestURI[0] ) {
			case 'curso':
				$tipo = 1;
				break;
			case 'sesion':
				$tipo = 2;
				break;
			case 'categoria':
				$tipo = 3;
				break;
		}

		if( isset( $requestURI[1] ) ): // Id del curso
			$ContentId = $requestURI[1];
			$r = $objDataBase->Ejecutar("SELECT * FROM aula_contenidos WHERE id=".$ContentId);

			if($r->num_rows == 0 ){
				header('Location: '.G_SERVER.'404.php');
				die();
			}
			$Content = $r->fetch_assoc();

			if($tipo==1 || $tipo==2){
				$rs = $objDataBase->Ejecutar("SELECT * FROM aula_contenidos WHERE padre_id=".$Content['id']);
				if($rs->num_rows > 0){
					$Links = $rs->fetch_all(MYSQLI_ASSOC);
				}	
			}
			//if($tipo==2 || $tipo==3){
				$path = path_classification($Content['id']);
			//}

			define('rm_title' , $Content['titulo']." | ".G_TITULO);
			define('rm_title_page' , '');
			define('rm_page_image', '');
			define('rm_metadescription' , '');
			define('rm_metaauthor' , G_USERID);

			$file = ABSPATH.'rb-script/modules/aulavirtual/contenido.public.php';
			if(file_exists( $file )) require_once( $file );
			die();
		endif;
	endif;
}

add_function('call_modules_url','aula_contenidos_call_url');

?>
