<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'rb-script/class/rb-database.class.php';
$q = $objDataBase->Ejecutar("SELECT * FROM albums");

if(!isset($_GET['temp_id'])) $temp_id = 1;
else $temp_id = $_GET['temp_id'];
?>
<li class="col" data-id="<?= $temp_id ?>" data-type="slide">
	<span class="col-head">
		<strong>Slide</strong>
		<a class="close-column" href="#" title="Eliminar">
			<i class="fa fa-trash fa-lg" aria-hidden="true"></i>
		</a>
	</span>
	<div class="col-box-edit">
		<div class="box-edit">
			<label>
			  <span>Seleccionar galería</span>
			  <select class="slide_name" name="slides">
			    <option value="0">Seleccionar</option>
			    <?php
			    while($r = $q->fetch_assoc()):
			    ?>
			    <option value="<?= $r['id'] ?>"><?= $r['nombre'] ?></option>
			    <?php
			    endwhile;
			    ?>
			  </select>
			</label>
			<label> Class CSS:
				<input type="text" id="class_<?= $temp_id ?>" value="" />
			</label>
		</div>
	</div>
</li>
