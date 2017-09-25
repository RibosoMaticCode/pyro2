<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'rb-script/class/rb-database.class.php';
$q = $objDataBase->Ejecutar("SELECT * FROM albums");
?>
<li class="col">
	<span class="col-head">
		<strong>Slide</strong><a class="close-column" href="#">X</a>
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
		</div>
	</div>
</li>
