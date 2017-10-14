<?php
include("../rb-script/funciones.php");
define('G_SERVER', rb_get_values_options('direccion_url'));

include 'islogged.php';

/*------------------ SCRIPT PHP PARA GUARDAR -----------------*/
$operacion=$_POST['section'];

switch($operacion){
	/*---------------------------------------------*/
	/*-------------- COMENTARIO -------------------*/
	/*---------------------------------------------*/
	case "com":
		require_once("../rb-script/class/rb-database.class.php");

		$id=$_POST['id'];
		$com=$_POST['comentario'];
		$web=$_POST['web'];
		$autor=$_POST['autor'];
		$mail=$_POST['mail'];

		$campos = array( $autor, $com, $mail, $web );
		$q = "UPDATE comentarios SET nombre='".$campos[0]."', contenido='".$campos[1]."', mail='".$campos[2]."', web='".$campos[3]."' WHERE id=$id";

		if( $objDataBase->Ejecutar($q) ){
			$enlace=G_SERVER."/rb-admin/index.php?pag=com&opc=edt&id=".$id;
			header('Location: '.$enlace);
		}else{
			echo "Hubo unos incovenientes";
		}
	break;
}
?>
