<?php
/*
Module Name: Suscripciones
Plugin URI: http://emocion.pe
Description: Base datos para suscriptores de la web. Administracion desde el panel y registro del front-end
Author: Jesus Liñan
Version: 1.0.0
Author URI: http://ribosomatic.com
*/

include_once 'vars.php';

// Personalizar estructura del Menu
$menu1 = array(
					'key' => 'rb_sus',
					'nombre' => "Suscripciones",
					'url' => "#",
					'url_imagen' => $rb_module_url_img,
					'pos' => 1,
					'extend' => false,
					'show' => true,
					'item' => array(
						array(
							'key' => 'rb_sus_susc',
							'nombre' => "Suscriptores",
							'url' => "module.php?pag=rb_sus_susc",
							'url_imagen' => "none",
							'pos' => 1
						),
						array(
							'key' => 'rb_sus_susc_config',
							'nombre' => "Configuracion",
							'url' => "module.php?pag=rb_sus_susc_config",
							'url_imagen' => "none",
							'pos' => 2
						)
					));

$menu = [
	"rb_sus" => $menu1
];
// Funciones iniciales
function suscrip_title(){
	return "Suscripciones";
}

// ------ FUNCIONES PARA EL FRONT-END ------ //
function header_files(){
	global $rb_module_url;
	$files = "<script src='".G_DIR_MODULES_URL."suscripciones/suscrip.js'></script>\n";
	$files .= "<link rel='stylesheet' type='text/css' href='".G_DIR_MODULES_URL."suscripciones/suscrip.css' />\n";
	return $files;
}
add_function('theme_header','header_files');

// ------ SUSCRIPTORES ------ //
if(isset($_GET['pag']) && $_GET['pag']=="rb_sus_susc"):
	function sus_suscriptores(){
		global $rb_module_url;
		include_once 'suscriptores.php';
	}
	add_function('module_title_page','suscrip_title');
	add_function('module_content_main','sus_suscriptores');
	//add_function('module_title_section','set_title_suscrip');
endif;

// ------ SUSCRIPTORES CONFIG ------ //
if(isset($_GET['pag']) && $_GET['pag']=="rb_sus_susc_config"):
	function sus_suscriptores_config(){
		global $rb_module_url;
		include_once 'suscriptores_config.php';
	}
	add_function('module_title_page','suscrip_title');
	add_function('module_content_main','sus_suscriptores_config');
endif;

// ----------- SHORTCODE ----------------- //
// Este short code, muestra el formulario de suscripcion al iniciar una pagina,
// si se suscribe o ya esta suscrito permite continuar, caso contrario al cancelar
// redirecciona a la pagina principal

function sus_shortcode(){
	$action = "<a id='hidden_link' href='".G_SERVER."/rb-script/modules/suscripciones/suscrip.frm.frontend.php' class='fancySuscrip fancybox.ajax'>Suscripcion</a>
	<script type='text/javascript'>
		$(document).ready(function() {
			$('#hidden_link').trigger('click');
		});
	</script>";
	return $action;
}

add_shortcode('suscripform', 'sus_shortcode');
?>
