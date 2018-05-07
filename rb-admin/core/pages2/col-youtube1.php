<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'rb-script/class/rb-database.class.php';
$q = $objDataBase->Ejecutar("SELECT * FROM albums");

if(!isset($_GET['temp_id'])) $temp_id = 1;
else $temp_id = $_GET['temp_id'];
?>
<li id="<?= $temp_id ?>" class="col" data-id="<?= $temp_id ?>" data-type="youtube1" data-class="" data-values="{}" data-saved-id="0">
	<span class="col-head">
		<strong>Youtube Videos: <span class="col-save-title"></span><a href="#" class="showEditBlock">Guardar</a></strong>
		<a class="close-column" href="#" title="Eliminar">
			<i class="fa fa-trash fa-lg" aria-hidden="true"></i>
		</a>
	</span>
	<div class="col-box-edit">
		<div class="box-edit">
			<div class="box-edit-html" id="box-edit<?= $temp_id ?>">
				<p style="text-align:center;max-width:100%"><img src="core/pages2/img/slider.png" alt="post" /></p>
			</div>
			<div class="box-edit-tool"><a href="#" class="showEditYoutube1">Editar</a></div>
		</div>
	</div>
</li>
