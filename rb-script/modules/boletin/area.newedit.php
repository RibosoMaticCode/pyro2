<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH."global.php";
require_once ABSPATH."rb-script/class/rb-database.class.php";
$urlreload=G_SERVER.'rb-admin/module.php?pag=boletin_areas';
$objDataBase = new DataBase;
$mode = "new";
$id = 0;
if(isset($_GET['id']) && $_GET['id'] > 0):
	$id = $_GET['id'];
	$r = $objDataBase->Ejecutar("SELECT * FROM boletin_areas WHERE id=".$id);
	$row = $r->fetch_assoc();
	$mode = "upd";
endif;
?>
<form id="frmarea" class="form">
	<input type="hidden" name="mode" value="<?= $mode ?>" required />
	<input type="hidden" name="id" value="<?= $id ?>" required />
  <label>
		Titulo:
    <input type="text" name="titulo" required value="<?php if(isset($row)) echo $row['titulo']; ?>" />
  </label>
	<label>
		Descripcion:
    <textarea rows="3" name="descripcion"><?php if(isset($row)) echo $row['descripcion']; ?></textarea>
  </label>
	<label>
		<!--Image ID:
    <input type="text" name="foto_id" value="<?php if(isset($row)) echo $row['foto_id']; ?>" />-->
    <script>
      $(document).ready(function() {
        $(".foto").filexplorer({
          inputHideValue : "<?= isset($row) ? $row['foto_id'] : "0" ?>"
        });
      });
    </script>
    Imagen fondo cabecera:
    <input type="text" name="foto" class="foto" readonly value="<?php $Photo = rb_get_photo_details_from_id( isset($row) ? $row['foto_id'] : 0 ); print $Photo['file_name']; ?>" />
  </label>
  <div class="cols-container">
    <div class="cols-6-md cols-content-left">
      <button type="submit" class="button btn-primary">Guardar</button>
    </div>
    <div class="cols-6-md cols-content-right">
      <button type="button" class="button CancelFancyBox">Cancelar</button>
    </div>
  </div>
</form>
