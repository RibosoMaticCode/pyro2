<?php
require_once 'hook.php';
require_once 'admin.php';
include 'islogged.php';

// Carga formato js de la base de datos
global $objOpcion;
$modules_prev = rb_get_values_options('modules_load');

// Convierte json a array
$array_modules = json_decode($modules_prev, true);

// Incluir modulos independiente a traves de codigo
include_once ABSPATH.'rb-admin/core/grupos/group.php';

// Incluir los modulos externos desde la base de datos
require_once 'modules.list.php';

$rb_title_module = do_action('module_title_page') ? do_action('module_title_page') : (isset($title_page) ? $title_page : "");
$rb_title = $rb_title_module." | ".G_TITULO; // antes $rb_module_title

include_once 'header.php';
?>
<section id="wrap">
	<?php include('menu.php') ?>
	<!--<div id="message"></div>-->
	<div id="contenedor">
		<h2 class="title"><?= $rb_title_module ?></h2>
		<?= do_action('module_content_main') ?>
	</div>
</section>
<?php include_once 'footer.php' ?>
