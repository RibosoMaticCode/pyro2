<?php
/*
Module Name: elastic_slideshow
Plugin URI: https://github.com/louisremi/jquery.smartresize.js
Description: Convierte una galería en un slide (con el plugin elastic_slideshow)
Author: Jesus Liñan
Version: 1.0
Author URI: http://ribosomatic.com
PageConfig: elastic
*/

// CSS Front End
function elastic_front_headers(){
	$css = "<link rel='stylesheet' href='".G_DIR_MODULES_URL."ei-slider/elastic.css'>\n";
	$css .= "<script src='".G_DIR_MODULES_URL."ei-slider/elasticslideshow.js'></script>\n";
	return $css;
}
add_function('theme_header','elastic_front_headers');

// PAGINA CONFIGURACION
if(isset($_GET['pag']) && $_GET['pag']=="elastic"):
  function elastic_title(){
		return "Configuracion de elastic slideshow";
	}

	function elastic_main_content(){
		include_once 'ei-slider.init.php';
	}
	add_function('module_title_page','elastic_title');
	add_function('module_content_main','elastic_main_content');

endif;


// SHORTCODE PARA MOSTRAR SLIDESHOW
function show_elastic( $params ){
	global $objDataBase;
	$gallery_id = $params['id'];
	$photos = rb_get_images_from_gallery($gallery_id);

	$carrusel_html = '
        <div id="ei-slider" class="ei-slider">
        <ul class="ei-slider-large">';
		foreach ($photos as $photo) {
            $carrusel_html.='
                <li>
                    <img src="'.$photo['url_max'].'" alt="image" class="responsiveslide">
                    <div class="ei-title">
                        '.$photo['title'].'
                    </div>
                </li>';
        }
    $carrusel_html .= '
        </ul>
        <ul class="ei-slider-thumbs">
            <li class="ei-slider-element">Current</li>';
        foreach ($photos as $photo) {
            $carrusel_html.='<li><a href="#">Slide 1</a><img src="'.$photo['url_min'].'" class="slideshowthumb" alt="thumb01"/></li>';
        }
    $carrusel_html .="</ul></div><div class='minipause'></div>\n";

	return $carrusel_html;
}

$r = $objDataBase->Ejecutar('SELECT id FROM '.G_PREFIX.'galleries');
while($gallery = $r->fetch_assoc()){
	add_shortcode('elastic', 'show_elastic', ['id' => $gallery['id'] ]);
}
?>
