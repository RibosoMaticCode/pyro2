<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';
require_once ABSPATH.'rb-script/class/rb-database.class.php';
require_once ABSPATH.'rb-script/funcs.php';
// definiendo valores

$nomVis=$_POST['galeria_nombre'];
$nomOcul = rb_cambiar_nombre(utf8_encode($_POST['galeria_nombre']));
$des="";
$catpadre = 0;
$nivel = 0;

//$campos = array(,"",,"",,0);
$data = [
		'nombre' => $nomVis,
		'descripcion' => "",
		'imagenes' => 0,
		'fecha' => date('Y-m-d G:i:s'),
		'nombre_enlace' => $nomOcul,
		'usuario_id' => G_USERID,
		'photo_id' => 0
];

//$q = "INSERT INTO albums (nombre, descripcion, imagenes, fecha, nombre_enlace, galeria_grupo, usuario_id, photo_id) VALUES ('".$campos[0]."','".$campos[1]."',0,NOW(),'".$campos[2]."','".$campos[3]."', ".$campos[4].", ".$campos[5].")";
$result = $objDataBase->Insert(G_PREFIX."galleries", $data);
if($result){
	$ultimo_id=$result['insert_id'];
	echo "<label class=\"label_checkbox\">";
	echo "<input type=\"radio\" value=\"$ultimo_id\" name=\"albums\" /> $nomVis (<a data-id='".$ultimo_id."' class='galleries' href='#'>Editar</a>) \n";
	echo "</label>";
}else{
	die("error");
}
