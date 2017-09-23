<?php
require_once '../rb-script/hook.php';
require_once 'admin.php';

// Carga formato js de la base de datos
global $objOpcion;
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
