<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';
require_once ABSPATH.'rb-script/class/rb-database.class.php';
require_once ABSPATH.'rb-script/funciones.php';

if(isset($_GET['custom_id'])){
	$id = $_GET['custom_id'];
}else{
	$id = $block_id;
}
$qb = $objDataBase->Ejecutar("SELECT * FROM bloques WHERE id=$id");
$row= $qb->fetch_assoc();
$widget = json_decode($row['contenido'], true);
$data_saved_id = $row['id'];
$name_save = $row['nombre'];
switch ($widget['widget_type']) {
	case 'html':
		include_once 'widgets/editor/w.editor.php';
		break;
	case 'htmlraw':
		include 'widgets/code/w.code.php';
		break;
	case 'slide':
		include 'widgets/slide/w.slide.php';
		break;
	case 'galleries':
		include 'widgets/gallery/w.gallery.php';
		break;
	case 'youtube1':
		include 'widgets/youtube/w.youtube.php';
		break;
	case 'post1':
		include 'widgets/pubs/w.pubs.php';
		break;
}
?>
