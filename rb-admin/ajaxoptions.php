<?php
// Actualiza cookie local para establecer el valor de cuantos elementos mostrar por lista
$value = $_GET['value'];
$sec = $_GET['sec'];
require("../global.php");

//define('G_SERVER', rb_get_values_options('direccion_url'));

switch($sec){
	case "usu":
		setcookie("user_show_items", $value);
	break;
	case "art":
		setcookie("art_show_items", $value);
	break;
	case "pages":
		setcookie("page_show_items", $value);
	break;
	case "com":
		setcookie("com_show_items", $value);
	break;
}
$urlreload=G_SERVER.'/rb-admin/index.php?pag='.$sec;
header('Location: '.$urlreload);
?>
