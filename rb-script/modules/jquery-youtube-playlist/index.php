<?php
/*
Module Name: Lista de reproduccion Youtube
Plugin URI: https://github.com/bachors/jQuery-Youtube-Channels-Playlist
Description: Muestra un bloque de visualizacion de lista de reproduccion de Youtube
Author: Ican Bachors
Version: v06
Author URI: https://github.com/bachors
*/

// ------ FUNCIONES PARA EL FRONT-END ------ //
function ycp_files_header(){
	global $rb_module_url;
	$files = '<script src="'.G_DIR_MODULES_URL.'jquery-youtube-playlist/js/ycp.js"></script>';
  $files .= '<script src="'.G_DIR_MODULES_URL.'jquery-youtube-playlist/config.init.js"></script>';
  $files .= '<link rel="stylesheet" href="'.G_DIR_MODULES_URL.'jquery-youtube-playlist/css/ycp.css">';
	return $files;
}

add_function('theme_header','ycp_files_header');

function box($params){
	return '<div id="$1" data-ycp_title="$2" data-ycp_channel="$3"> </div>';
}
function hello(){
	return "Hola bebecode!!";
}
add_bbcode('YOUTUBELIST', 'box', ['id','title','channel']);
add_bbcode('YOUTUBE_HOLA', 'hello');
?>
