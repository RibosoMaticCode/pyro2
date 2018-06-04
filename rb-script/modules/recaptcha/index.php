<?php
/*
Module Name: Recaptcha
Plugin URI: https://www.google.com/recaptcha/
Description: Evitar spam en los formularios. Debes establecer el ID del submit como: btnSend. <a href='module.php?pag=recaptcha_google'>Configuracion</a>
Author: Google Inc.
Version: 1.0
Author URI: https://www.google.com/recaptcha/
*/

// ------ FUNCIONES PARA EL FRONT-END ------ //
function recaptcha_files_header(){
	global $rb_module_url;
	$files = "<script src='https://www.google.com/recaptcha/api.js'></script>\n";
	$files .= "<script src='".G_DIR_MODULES_URL."recaptcha/funcs.js'></script>\n";
	$files .= '
	<style>
		.g-recaptcha {
    	overflow: hidden;
		}
		#btnSend[disabled]{
			background-color: #e8e8e8;
			color: #cacaca;
		}
		</style>';
	return $files;
}

add_function('theme_header','recaptcha_files_header');

// ---------- FUNCIONES PARA EL BACK END ------- //

// Pagina de configuraciones
if(isset($_GET['pag']) && $_GET['pag']=="recaptcha_google"):
  function recapt_title(){
		return "Configuracion de Recaptcha de Google";
	}

	function recapt_main_content(){
		include_once 'recapt.init.php';
	}
	add_function('module_title_page','recapt_title');
	add_function('module_content_main','recapt_main_content');

endif;
?>
