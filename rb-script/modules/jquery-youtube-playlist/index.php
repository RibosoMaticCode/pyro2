<?php
/*
Module Name: jQuery-Youtube-Channels-Playlist
Plugin URI: https://github.com/bachors/jQuery-Youtube-Channels-Playlist
Description: jQuery-Youtube-Channels-Playlist
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
?>
