<?php
/*
Module Name: Galeria carrusel
Plugin URI: http://kenwheeler.github.io/slick/
Description: Convierte una galería en un carrusel de fotos. Usa el plugin slick.js
Author: Jesus Liñan
Version: 1.1
Author URI: http://ribosomatic.com
PageConfig: carrusel
*/
// Menu
rb_add_specific_item_menu('files', array(
			'key' => 'carrusel',
			'nombre' => "Carrusel",
			'url' => "module.php?pag=carrusel"
));

function carrusel_title(){
	return "Galerias carrusel";
}

// OPCIONES DE VOTACION - BACKEND:
if(isset($_GET['pag']) && $_GET['pag']=="carrusel"):
	function carrusel_content(){
		include_once 'carrusel.list.php';
	}

	add_function('module_title_page','carrusel_title');
	add_function('module_content_main','carrusel_content');
endif;

// CSS Front End
function carrusel_front_css(){
	$css = "<link rel='stylesheet' href='".G_DIR_MODULES_URL."rb-carrusel/slick.css'>\n";
	$css .= "<link rel='stylesheet' href='".G_DIR_MODULES_URL."rb-carrusel/slick-theme.css'>\n";
	$css .= "<script src='".G_DIR_MODULES_URL."rb-carrusel/slick.min.js'></script>\n";
	return $css;
}
add_function('theme_header','carrusel_front_css');

// SHORTCODE PARA MOSTRAR VOTACIONES EN LAS PAGINAS
function show_carrusel( $params ){ // Mostrar el formulario segun su id
	global $objDataBase;
	$gallery_id = $params['id'];
	$photos = rb_get_images_from_gallery($gallery_id);
	$carrusel_html = "<script>\n
    $(document).ready(function(){\n
      $('.gallery".$gallery_id."').slick({\n
				infinite: true,\n
  			slidesToShow: 4,\n
  			slidesToScroll: 1,\n
				autoplay: true,\n
				variableWidth: true,\n
  			autoplaySpeed: 2000,\n
				responsive: [
					{
			      breakpoint: 480,
			      settings: {
			        slidesToShow: 3,
			        slidesToScroll: 1
			      }
			    }
				]
			});\n
    });\n
  </script>";
	$carrusel_html .= '
	<div class="gallery'.$gallery_id.'">';
			foreach ($photos as $photo) {
				$photo_url = $photo['goto_url'];
				if($photo['goto_url']=="#"){
					$photo_url = $photo['url_max'];
				}
				$carrusel_html.='
					<a class="fancy" href="'.$photo_url.'" data-fancybox-group="gallery">
						<img src="'.$photo['url_max'].'" alt="Carrusel picture" />
					</a>';
			}
	$carrusel_html.="</div>\n";
	return $carrusel_html;
}

$r = $objDataBase->Ejecutar('SELECT id FROM albums');
while($gallery = $r->fetch_assoc()){
	add_shortcode('carrusel', 'show_carrusel', ['id' => $gallery['id'] ]);
}

function test1(){
	return "Esto es una demostración de como usar los shortcodes - primitivo";
}
add_shortcode('carrusel_all', 'test1');
?>
