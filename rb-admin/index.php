<?php
require_once '../rb-script/hook.php';
require_once 'admin.php';

if(count($_GET)==0) { // Si index no tiene parametros cambiamos por la que establecio el cliente.
	// Si cliente establecio pagina inicial a otra ruta, comprobamos antes:
	$index_custom = rb_get_values_options('index_custom');
	if(strlen($index_custom)>0){
		$urlreload=G_SERVER."rb-admin/".$index_custom;
		header('Location: '.$urlreload);
	}
}

// Carga formato js de la base de datos
$modules_prev = rb_get_values_options('modules_load');

// Convierte json a array
$array_modules = json_decode($modules_prev, true);

// Incluir los modulos externos desde la base de datos
require_once '../rb-script/modules.list.php';

// Cargar los widgets del sistemas y personalizados (de los modulos)
require_once 'widgets.system.php';

$rb_title = "Panel Inicial | ".G_TITULO;
include_once 'header.php';
?>
<section id="wrap">
	<?php include('menu.php') ?>
	<!--<div id="message"></div>-->
	<?php require('seleccionar.php') ?>
</section>
<?php include_once 'footer.php' ?>
