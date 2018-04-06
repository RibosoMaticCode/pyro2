<?php
require_once 'hook.php';
require_once 'admin.php';

if(count($_GET)==0) { // Si index no tiene parametros cambiamos por la que establecio el cliente.
	// Si cliente establecio pagina inicial a otra ruta, comprobamos antes:
	$index_custom = rb_get_values_options('index_custom');
	if(strlen($index_custom)>0){
		$urlreload=G_SERVER."/rb-admin/".$index_custom;
		header('Location: '.$urlreload);
	}
}

// Carga formato js de la base de datos
$modules_prev = rb_get_values_options('modules_load');

// Convierte json a array
$array_modules = json_decode($modules_prev, true);

require_once 'modules.list.php';

$rb_title = "Panel Inicial | ".G_TITULO;
include_once 'header.php';
?>
<section id="wrap">
	<?php include('menu.php') ?>
	<!--<div id="message"></div>-->
	<?php require('seleccionar.php') ?>
</section>
<?php include_once 'footer.php' ?>
