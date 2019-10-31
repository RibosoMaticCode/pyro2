<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(dirname(__FILE__))))) . '/');

require_once ABSPATH."global.php";

// Personalizar valores iniciales
$rb_module_title = "Suscripciones"; // Titulo de pagina
$rb_module_title_section = ""; // Titulo interno, puede ser definido en cada subpagina tambien
$rb_module_directory = "suscripciones";
$rb_module_unique = "rb_sus";
$rb_module_icon = "subscribe.png";

// Valores por defecto. Quiza no sea necesario cambiar nada aqui
$rb_module_url_main = G_SERVER."rb-admin/module.php";
$rb_module_url = G_SERVER."rb-script/modules/$rb_module_directory/";
$rb_module_url_img = G_SERVER."rb-script/modules/$rb_module_directory/img/$rb_module_icon";
?>
