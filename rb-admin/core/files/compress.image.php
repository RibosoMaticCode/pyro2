<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';
require_once ABSPATH.'rb-script/funciones.php';

$image = $_GET['image'];
$url_image = ABSPATH.'rb-media/gallery/'.$image;
rb_compress($url_image, $url_image);

header('Location: '.G_SERVER.'/rb-admin/index.php?pag=explorer&compress');
?>