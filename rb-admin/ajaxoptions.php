<?php
//include 'islogged.php';
$value = $_GET['value'];
$sec = $_GET['sec'];
require("../rb-script/class/rb-opciones.class.php");
define('G_SERVER', $objOpcion->obtener_valor(1,'direccion_url'));

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
