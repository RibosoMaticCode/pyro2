<?php
/*
Module Name: Carrusel OWL
Plugin URI: https://ribosomatic.com
Description: Adaptación del plugin owl.carousel.js para crear carrusel/slider responsives.
Author: Jesus Liñan
Version: 1.0.0
Author URI: https://ribosomatic.com
*/

// Valores iniciales
$rb_module_dir = "carrusel_owl";
$rb_module_url = G_SERVER."rb-script/modules/$rb_module_dir/";
$rb_module_url_img = G_SERVER."rb-script/modules/$rb_module_dir/slider.png";

// Estructura del menu
$menu1 = [
	'key' => 'carrusel_owl',
	'nombre' => "Carrusel owl",
	'url' => "#",
	'url_imagen' => $rb_module_url_img,
	'pos' => 1,
	'show' => true,
	'item' => [
		[
			'key' => 'carrusel_list',
			'nombre' => "Listado de sliders",
			'url' => "module.php?pag=carrusel_list",
			'url_imagen' => "none",
			'pos' => 1
		],
    [
			'key' => 'carrusel_config',
			'nombre' => "Configuración",
			'url' => "module.php?pag=carrusel_config",
			'url_imagen' => "none",
			'pos' => 2
		]
	]
];

// Añadir al menu principal del gestor
$menu = [
	"carrusel_owl" => $menu1
];

// CSS backend

// CSS FrontEnd
function owl_back_css(){
	global $rb_module_dir;
	$css = "<link rel='stylesheet' href='".G_DIR_MODULES_URL.$rb_module_dir."/owl.backend.css'>\n";
	return $css;
}
add_function('panel_header_css','owl_back_css');

// CSS y JS archivos en backend
function owl_front_css(){
	global $rb_module_dir;
	$res = "<link rel='stylesheet' href='".G_DIR_MODULES_URL.$rb_module_dir."/owlcarousel/assets/owl.carousel.min.css'>\n";
	$res .= "<link rel='stylesheet' href='".G_DIR_MODULES_URL.$rb_module_dir."/owlcarousel/assets/owl.theme.default.min.css'>\n";
	$res .= "<script src='".G_DIR_MODULES_URL.$rb_module_dir."/owlcarousel/owl.carousel.min.js'></script>\n";
	/*$res .= "<script>\n";
	$res .= "$(document).ready(function() {\n";
	$res .= "$('.owl-carousel').owlCarousel();\n";
	$res .= "});\n";
	$res .= "</script>\n";*/
	return $res;
}
add_function('theme_header','owl_front_css');

// Paneles dentro del gestor

// ------ CONFIGURACIN DEL PLUGIN ------ //
if(isset($_GET['pag']) && $_GET['pag']=="carrusel_config"):
	function owl_config_title(){
		return "Configuracion de PLM";
	}
	function owl_config(){
		global $rb_module_url;
		include_once 'owl.config.php';
	}
	add_function('module_title_page','owl_config_title');
	add_function('module_content_main','owl_config');
endif;

// ------ LISTADO DE GALERIAS ------ //
if(isset($_GET['pag']) && $_GET['pag']=="carrusel_list"):
	function owl_list_title(){
		return "Galerías";
	}
	function owl_list(){
		global $rb_module_url;

		if(isset($_GET['id'])){
			include_once 'owl.slider.details.php';
		}else {
			include_once 'owl.init.php';
		}
	}
	add_function('module_title_page','owl_list_title');
	add_function('module_content_main','owl_list');
endif;

// ------ EDICION DE GALERIA ------ //
/*if(isset($_GET['pag']) && $_GET['pag']=="carrusel_edit"):
	function owl_edit_title(){
		return "Edicion de galería";
	}
	function owl_edit(){
		if($_GET['id']){
			global $rb_module_url;
			include_once 'owl.slider.details.php';
		}
	}
	add_function('module_title_page','owl_edit_title');
	add_function('module_content_main','owl_edit');
endif;*/
?>
