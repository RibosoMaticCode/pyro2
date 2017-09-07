<?php
require_once '../rb-script/hook.php';
require_once 'admin.php';
include 'islogged.php';

// Carga formato js de la base de datos
global $objOpcion;
$modules_prev = $objOpcion->obtener_valor(1,'modules_load');

// Convierte json a array
$array_modules = json_decode($modules_prev, true);

// Incluir los modulos de la base de datos
require_once 'modules.list.php';

$rb_title_module = "Modulos";
$rb_title = $rb_module_title." | ".G_TITULO;

include_once 'header.php';
?>
<section id="wrap">
	<?php include('menu.php') ?>
	<!--<div id="message"></div>-->
	<div id="contenedor">
		<h2 class="title"><?= $rb_module_title_section ?></h2>
		<?= do_action('module_content_main') ?>
	</div>
</section>
<?php include_once 'footer.php' ?>
