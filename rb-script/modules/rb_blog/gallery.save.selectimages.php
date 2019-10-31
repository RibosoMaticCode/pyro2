<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

include_once ABSPATH."global.php";
include_once ABSPATH."rb-script/funcs.php";

/*------------------ SCRIPT PHP PARA GUARDAR -----------------*/
$operacion=$_POST['section'];

switch($operacion){
	/*---------------------------------------------*/
	/*-------------- ARTICULOS --------------------*/
	/*---------------------------------------------*/
	case "imgnew":
		require_once(ABSPATH."rb-script/class/rb-database.class.php");
		if(!isset($_REQUEST['items'])) {
			print "[!] Debe seleccionar alguna imagen ... !!!";
			die();
		}
		$array_images = $_REQUEST['items'];

		foreach($array_images as $image){
			//update album_id
			$objDataBase->Ejecutar("UPDATE ".G_PREFIX."files SET album_id =".$_POST['album_id']." WHERE id=".$image);
		}
		echo "ok";
	break;
}
?>
