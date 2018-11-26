<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';
require_once ABSPATH.'rb-script/funciones.php';
require_once ABSPATH.'rb-script/class/rb-database.class.php';
$objDataBase = new DataBase;
$mode = "new";
if(isset($_GET['id']) && $_GET['id'] > 0):
	$r = $objDataBase->Ejecutar("SELECT * FROM staff WHERE id=".$_GET['id']);
	$row = $r->fetch_assoc();
	$mode = "upd";
endif;
?>
<?php include_once ABSPATH.'rb-admin/tinymce/tinymce.config.php' ?>

<div id="toolbar">
	<button type="submit" class="button" form="frmstaff">Guardar</button>
  <a class="button" href="<?= G_SERVER ?>/rb-admin/module.php?pag=staff">Volver</a>
</div>
<section class="seccion">
	<div class="seccion-body">
		<form id="frmstaff" method="post">
			<div class="form">
			<input type="hidden" name="mode" value="<?= $mode ?>" />
			<input type="hidden" name="id" value="<?php if(isset($row)) echo $row['id']; else echo "0" ?>" />
			<label>
				Nombres
				<input type="text" name="name" value="<?php if(isset($row)) echo $row['name'] ?>" />
			</label>
			<label>
				Cargo
				<input type="text" name="position" value="<?php if(isset($row)) echo $row['position'] ?>" />
			</label>
			<label>
				Area
				<input type="text" name="area" value="<?php if(isset($row)) echo $row['area'] ?>" />
			</label>
			<label>
				Ciudad
				<input type="text" name="city" value="<?php if(isset($row)) echo $row['city'] ?>" />
			</label>
			<label>
				Correo electrónico
				<input type="text" name="email" value="<?php if(isset($row)) echo $row['email'] ?>" />
			</label>
			<label>
				Teléfono
				<input type="text" name="telefono" value="<?php if(isset($row)) echo $row['telefono'] ?>" />
			</label>
			<label>
				Foto
				<script>
				$(document).ready(function() {
					$(".staff_photo").filexplorer({
						inputHideValue: "<?php if(isset($row)) echo $row['photo_id']; else echo "0"; ?>"
					});
				});
				</script>
				<input type="text" name="photo" class="staff_photo" value="<?php $photos = rb_get_photo_from_id( isset($row) ? $row['photo_id'] : 0 ); echo $photos['src']; ?>" />
			</label>
			</div>
			<textarea name="description" class="mceEditor"><?php if(isset($row)) echo $row['description'] ?></textarea>
		</form>
	</div>
</section>
