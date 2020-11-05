<?php
/*
Module Name: Boletin 
Plugin URI: http://emocion.pe
Description: Gestion una boletin virtual basico
Author: Jesus Liñan
Version: 1.0
Author URI: https://wwww.ribosomatic.com
*/

$rb_module_url_img = G_SERVER."rb-script/modules/boletin/img/teacher.png";

// Personalizar estructura del Menu
$menu1 = array(
	'key' => 'boletin',
	'nombre' => "boletin Virtual",
	'url' => "#",
	'url_imagen' => $rb_module_url_img,
	'pos' => 1,
	'extend' => false,
	'show' => true,
	'item' => array(
		array(
			'key' => 'boletin_areas',
			'nombre' => "Areas",
			'url' => "module.php?pag=boletin_areas",
			'url_imagen' => "none",
			'pos' => 1
		),
		array(
			'key' => 'boletin_categorias',
			'nombre' => "Categorias",
			'url' => "module.php?pag=boletin_categorias",
			'url_imagen' => "none",
			'pos' => 2
		),
		array(
			'key' => 'boletin_contenidos',
			'nombre' => "Contenidos",
			'url' => "module.php?pag=boletin_contenidos",
			'url_imagen' => "none",
			'pos' => 3
		)
	)
);

$menu = [
	"boletin" => $menu1
];

/* ------------------------------------------------------- */
/* ---------------- BACK END ----------------------------- */
/* ------------------------------------------------------- */


// ------ CSS ------ //
/*function boletin_header_files(){
	global $rb_module_url;
	$files = "<link rel='stylesheet' type='text/css' href='".G_DIR_MODULES_URL."boletin/contenidos.css' />\n";
	return $files;
}
add_function('panel_header_css','boletin_header_files');*/

// ------ AREA ------ //
if(isset($_GET['pag']) && $_GET['pag']=="boletin_areas"):
	function boletin_areas_titulo(){
		return "Areas de boletin";
	}

	function boletin_areas_listado(){
		global  $objDataBase;
		$q = $objDataBase->Ejecutar('SELECT * FROM boletin_areas');
		include_once 'area.php';
	}

	add_function('module_title_page','boletin_areas_titulo');
	add_function('module_content_main','boletin_areas_listado');
endif;

// ------ CATEGORIA ------ //
if(isset($_GET['pag']) && $_GET['pag']=="boletin_categorias"):
	function boletin_categorias_titulo(){
		return "Categoria de boletin";
	}

	function boletin_categorias_listado(){
		global  $objDataBase;
		$q = $objDataBase->Ejecutar('SELECT * FROM boletin_categorias');
		include_once 'categoria.php';
	}

	add_function('module_title_page','boletin_categorias_titulo');
	add_function('module_content_main','boletin_categorias_listado');
endif;

// ------ CONTENIDOS ------ //
if(isset($_GET['pag']) && $_GET['pag']=="boletin_contenidos"):
	// Formulario Edicion
	if(isset($_GET['id'])){
		function boletin_contenidos_edit_titulo(){
			return "Edicion de boletin";
		}
		function boletin_contenidos_edit(){
			global $objDataBase;
			$qc = $objDataBase->Ejecutar('SELECT * FROM boletin_categorias');
			$id = 0;
			if( $_GET['id'] > 0){ // Modo editar
				$id = $_GET['id'];
				$r = $objDataBase->Ejecutar("SELECT * FROM boletin_contenidos WHERE id=".$id);
				$contenido = $r->fetch_assoc();
			}
			include_once 'contenido.frmedit.php';
		}
		
		add_function('module_title_page','boletin_contenidos_edit_titulo');
		add_function('module_content_main','boletin_contenidos_edit');
	}else{
	// Listado
		function boletin_contenidos_titulo(){
			return "Contenido de boletin";
		}
		function boletin_contenidos_listado(){
			global  $objDataBase;
			$q = $objDataBase->Ejecutar('SELECT * FROM boletin_contenidos');
			include_once 'contenido.php';
		}

		add_function('module_title_page','boletin_contenidos_titulo');
		add_function('module_content_main','boletin_contenidos_listado');
	}
	
endif;

/* ------------------------------------------------------- */
/* --------------- FRONT END ----------------------------- */
/* ------------------------------------------------------- */


// ------ CSS ------ //
function boletin_contenidos_front_css(){
	global $rb_module_url;
	$front_files = "<link rel='stylesheet' type='text/css' href='".G_DIR_MODULES_URL."boletin/frontend/boletin.css' />\n";
	return $front_files;
}
add_function('theme_header','boletin_contenidos_front_css');

// ------ VISUALIZACION USUARIO ------ //

function boletin_call_url(){
	global $objDataBase;
	$requestURI = str_replace(G_DIRECTORY, "", $_SERVER['REQUEST_URI']);
	$requestURI = explode("/", $requestURI);
	$requestURI = array_values( array_filter( $requestURI ) );
	$numsItemArray = count($requestURI);

	if( $numsItemArray > 0 ){
		$base = $requestURI[0];
		if($base == "boletin"){


			if( isset( $requestURI[1] ) && isset( $requestURI[2] ) ){
				switch( $requestURI[1] ){

					// Url: web/boletin/area/mi-area
					case "area":
						$url_id = $requestURI[2];
						$ra = $objDataBase->Ejecutar("SELECT * FROM boletin_areas WHERE url='".$url_id."'");
						$Area = $ra->fetch_assoc();
						$Photo = rb_get_photo_details_from_id( $Area['foto_id'] );
						$Area['url_image'] = $Photo['file_url'];

						$rc = $objDataBase->Ejecutar("SELECT * FROM boletin_categorias WHERE area_id=".$Area['id']);

						$i=0;
						$CategoriasArray = array();
						while($Categoria = $rc->fetch_assoc()){
							$CategoriasArray[$i]['id'] = $Categoria['id'];
							$CategoriasArray[$i]['titulo'] = $Categoria['titulo'];
							$Photo = rb_get_photo_details_from_id( $Categoria['icon_id'] );
							$CategoriasArray[$i]['url_icon'] = $Photo['file_url'];
							$CategoriasArray[$i]['url'] = G_SERVER."boletin/categoria/".$Categoria['url'];
							$i++;
						}

						define('rm_title' , $Area['titulo']." | ".G_TITULO);
						define('rm_title_page' , '');
						define('rm_page_image', '');
						define('rm_metadescription' , '');
						define('rm_metaauthor' , G_USERID);

						$file = ABSPATH.'rb-script/modules/boletin/frontend/area.php';
						if(file_exists( $file )) require_once( $file );
						die();
					break;

					// Url: web/boletin/categoria/mi-categoria
					case "categoria":
						$url_id = $requestURI[2];
						
						// Info categoria actual
						$rc = $objDataBase->Ejecutar("SELECT * FROM boletin_categorias WHERE url='".$url_id."'");
						$CategoriaActual = $rc->fetch_assoc();

						// Info area actual
						$ra = $objDataBase->Ejecutar("SELECT * FROM boletin_areas WHERE id=".$CategoriaActual['area_id']);
						$Area = $ra->fetch_assoc();
						$Photo = rb_get_photo_details_from_id( $Area['foto_id'] );
						$Area['url_image'] = $Photo['file_url'];

						// Listado de categorias del area actual
						$rcs = $objDataBase->Ejecutar("SELECT * FROM boletin_categorias WHERE area_id=".$Area['id']);

						$i=0;
						$CategoriasArray = array();
						while($Categoria = $rcs->fetch_assoc()){
							$CategoriasArray[$i]['id'] = $Categoria['id'];
							$CategoriasArray[$i]['titulo'] = $Categoria['titulo'];
							$Photo = rb_get_photo_details_from_id( $Categoria['icon_id'] );
							$CategoriasArray[$i]['url_icon'] = $Photo['file_url'];
							$CategoriasArray[$i]['url'] = G_SERVER."boletin/categoria/".$Categoria['url'];
							$i++;
						}

						// Publicaciones de la categoria actual
						$rcs = $objDataBase->Ejecutar("SELECT * FROM boletin_contenidos WHERE categoria_id=".$CategoriaActual['id']);

						$i=0;
						$ContenidosArray = array();
						while($Contenido = $rcs->fetch_assoc()){
							$ContenidosArray[$i]['id'] = $Contenido['id'];
							$ContenidosArray[$i]['titulo'] = $Contenido['titulo'];
							$ContenidosArray[$i]['contenido'] = $Contenido['contenido'];
							$ContenidosArray[$i]['url'] = G_SERVER."boletin/tema/".$Contenido['url'];
							if( $Contenido['pdfs']!="" ) $ContenidosArray[$i]['pdfs'] = true;
							else $ContenidosArray[$i]['pdfs'] = false;
							if( $Contenido['videos']!="" ) $ContenidosArray[$i]['videos'] = true;
							else $ContenidosArray[$i]['videos'] = false;
							if( $Contenido['video_live']!="" ) $ContenidosArray[$i]['video_live'] = true;
							else $ContenidosArray[$i]['video_live'] = false;
							$i++;
						}

						define('rm_title' , $CategoriaActual['titulo']." | ".G_TITULO);
						define('rm_title_page' , '');
						define('rm_page_image', '');
						define('rm_metadescription' , '');
						define('rm_metaauthor' , G_USERID);

						$file = ABSPATH.'rb-script/modules/boletin/frontend/categoria.php';
						if(file_exists( $file )) require_once( $file );
						die();
					break;

					// Url: web/boletin/tema/mi-tema
					case "tema":
						$url_id = $requestURI[2];

						// Info publicacion actual
						$rp = $objDataBase->Ejecutar("SELECT * FROM boletin_contenidos WHERE url='".$url_id."'");
						$PublicacionActual = $rp->fetch_assoc();
						if( $PublicacionActual['imagen_id'] > 0){
							$Photo = rb_get_photo_details_from_id( $PublicacionActual['imagen_id'] );
							$PublicacionActual['url_image'] = $Photo['file_url'];
						}

						if( $PublicacionActual['pdfs']!="" ){
							$PublicacionActual['pdfs_list'] = explode("\n", $PublicacionActual['pdfs']);
						}else{
							$PublicacionActual['pdfs_list'] = false;
						}
						

						if( $PublicacionActual['videos']!="" ){
							$PublicacionActual['videos_list'] = explode("\n", $PublicacionActual['videos']);
						}else{
							$PublicacionActual['videos_list'] = false;
						}

						// Info categoria actual
						$rc = $objDataBase->Ejecutar("SELECT * FROM boletin_categorias WHERE id='".$PublicacionActual['categoria_id']."'");
						$CategoriaActual = $rc->fetch_assoc();
						$CategoriaActual['url'] = G_SERVER."boletin/categoria/".$CategoriaActual['url'];

						// Info area actual
						$ra = $objDataBase->Ejecutar("SELECT * FROM boletin_areas WHERE id=".$CategoriaActual['area_id']);
						$Area = $ra->fetch_assoc();
						$Photo = rb_get_photo_details_from_id( $Area['foto_id'] );
						$Area['url_image'] = $Photo['file_url'];

						// Listado de categorias del area actual
						$rcs = $objDataBase->Ejecutar("SELECT * FROM boletin_categorias WHERE area_id=".$Area['id']);

						$i=0;
						$CategoriasArray = array();
						while($Categoria = $rcs->fetch_assoc()){
							$CategoriasArray[$i]['id'] = $Categoria['id'];
							$CategoriasArray[$i]['titulo'] = $Categoria['titulo'];
							$Photo = rb_get_photo_details_from_id( $Categoria['icon_id'] );
							$CategoriasArray[$i]['url_icon'] = $Photo['file_url'];
							$CategoriasArray[$i]['url'] = G_SERVER."boletin/categoria/".$Categoria['url'];
							$i++;
						}

						// Publicaciones de la categoria actual
						$rcs = $objDataBase->Ejecutar("SELECT * FROM boletin_contenidos WHERE categoria_id=".$CategoriaActual['id']);

						$i=0;
						$ContenidosArray = array();
						while($Contenido = $rcs->fetch_assoc()){
							$ContenidosArray[$i]['id'] = $Contenido['id'];
							$ContenidosArray[$i]['titulo'] = $Contenido['titulo'];
							$ContenidosArray[$i]['contenido'] = $Contenido['contenido'];
							$ContenidosArray[$i]['url'] = G_SERVER."boletin/tema/".$Contenido['url'];
							$i++;
						}

						define('rm_title' , $PublicacionActual['titulo']." | ".G_TITULO);
						define('rm_title_page' , '');
						define('rm_page_image', '');
						define('rm_metadescription' , '');
						define('rm_metaauthor' , G_USERID);

						$file = ABSPATH.'rb-script/modules/boletin/frontend/tema.php';
						if(file_exists( $file )) require_once( $file );
						die();
					break;
				}
				
			}
		}
		//header('Location: '.G_SERVER.'404.php');
		//die();
	}
}

add_function('call_modules_url','boletin_call_url');

function url_get_name_file($url){
	$url_array = explode("/", $url);
	return end($url_array);
}
?>
