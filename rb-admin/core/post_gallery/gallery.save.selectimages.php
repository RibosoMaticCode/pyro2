<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

include(ABSPATH."rb-script/funciones.php");
//require(ABSPATH."rb-script/class/rb-opciones.class.php");

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
			$objDataBase->Ejecutar("UPDATE photo SET album_id =".$_POST['album_id']." WHERE id=".$image);
		}

		echo "ok";
	break;
}
?>
