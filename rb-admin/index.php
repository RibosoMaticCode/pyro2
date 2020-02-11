<?php
// Carga funciones gancho, funciones personalizadas
require_once '../rb-script/hook.php';

// Carga configuracion inicial del admin
require_once 'admin.php';

if(count($_GET)==0) { // Si index no tiene parametros cambiamos por la que establecio el cliente.
	// Si cliente establecio pagina inicial a otra ruta, comprobamos antes:
	$index_custom = rb_get_values_options('index_custom');
	if(strlen($index_custom)>0){
		$urlreload=G_SERVER."rb-admin/".$index_custom;
		header('Location: '.$urlreload);
	}
}

// Carga Modulos en la base de datos en formato JSON
$modules_prev = rb_get_values_options('modules_load');

// Convierte JSON a array php
$array_modules = json_decode($modules_prev, true);

// Incluir los modulos externos desde la base de datos
require_once '../rb-script/modules.list.php';

// Cargar los widgets del sistemas y personalizados (de los modulos)
require_once 'widgets.system.php';

// Titulo de la seccion
$rb_title_module = do_action('module_title_page') ? do_action('module_title_page') : (isset($title_page) ? $title_page : "");
$rb_title = $rb_title_module." | ".G_TITULO; // antes $rb_module_title

$rb_title = "Panel Administrativo | ".G_TITULO;
include_once 'header.php';
?>
<section id="wrap">
	<?php include('menu.php') ?>
	<!--<div id="message"></div>-->
	<?php require('seleccionar.php') ?>
	<div id="contenedor">
		<div class="inside_contenedor_list">
			<?= do_action('module_content_main') ?>
		</div>
	</div>
</section>
<?php include_once 'footer.php' ?>
