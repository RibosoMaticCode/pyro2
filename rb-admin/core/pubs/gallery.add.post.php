<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';
require_once ABSPATH.'rb-script/class/rb-database.class.php';
require_once ABSPATH.'rb-script/funciones.php';
// definiendo valores

$nomVis=$_POST['galeria_nombre'];
$nomOcul = rb_cambiar_nombre(utf8_encode($_POST['galeria_nombre']));
$des="";
$catpadre = 0;
$nivel = 0;

$campos = array($nomVis,"",$nomOcul,"",G_USERID,0);
$q = "INSERT INTO albums (nombre, descripcion, imagenes, fecha, nombre_enlace, galeria_grupo, usuario_id, photo_id) VALUES ('".$campos[0]."','".$campos[1]."',0,NOW(),'".$campos[2]."','".$campos[3]."', ".$campos[4].", ".$campos[5].")";
$result = $objDataBase->Insertar($q);
if($result){
	$ultimo_id=$result['insert_id'];
/*if($objGaleria->Insertar(array($nomVis,"",$nomOcul,"",G_USERID,0))){
	$ultimo_id=mysql_insert_id();*/
	echo "<label class=\"label_checkbox\">";
	echo "<input type=\"checkbox\" value=\"$ultimo_id\" name=\"albums[]\" /> $nomVis (<a data-id='".$ultimo_id."' class='galleries' href='#'>Editar</a>) \n";
	echo "</label>";
}else{
	die("error");
}
