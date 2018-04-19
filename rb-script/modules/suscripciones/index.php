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
						)
					));

$menu = [
	"rb_sus" => $menu1
];

// --- FUNCIONES PARA EL FRONT-END  ----- //
function header_files(){
	global $rb_module_url;
	$files = '<script src="'.$rb_module_url.'suscrip.js"></script>';
	return $files;
}
add_function('theme_header','header_files');

// ***** Suscriptores ******* //
if(isset($_GET['pag']) && $_GET['pag']=="rb_sus_susc"):
	global $rb_module_title_section;
	$rb_module_title_section = "Suscriptores"; // Titulo interno

	function sus_suscriptores(){
		global $rb_module_url;
		include_once 'suscriptores.php';
	}
	add_function('module_content_main','sus_suscriptores');
endif;
?>
