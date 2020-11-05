<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH."global.php";
require_once ABSPATH."rb-script/class/rb-database.class.php";
$urlreload=G_SERVER.'rb-admin/module.php?pag=boletin_categorias';
$objDataBase = new DataBase;

$qa = $objDataBase->Ejecutar('SELECT * FROM boletin_areas');
$mode = "new";
$id = 0;
if(isset($_GET['id']) && $_GET['id'] > 0):
	$id = $_GET['id'];
	$r = $objDataBase->Ejecutar("SELECT * FROM boletin_categorias WHERE id=".$id);
	$row = $r->fetch_assoc();
	$mode = "upd";
endif;
?>
<form id="frmCategoria" class="form">
	<input type="hidden" name="mode" value="<?= $mode ?>" required />
	<input type="hidden" name="id" value="<?= $id ?>" required />
  <label>
		Titulo:
    <input type="text" name="titulo" required value="<?php if(isset($row)) echo $row['titulo']; ?>" />
  </label>
  <label>
    <!--Icon ID:
    <input type="text" name="icon_id" value="<?php if(isset($row)) echo $row['icon_id']; ?>" />-->
    <script>
      $(document).ready(function() {
        $(".icon").filexplorer({
          inputHideValue : "<?= isset($row) ? $row['icon_id'] : "0" ?>"
        });
      });
    </script>
    Imagen fondo cabecera:
    <input type="text" name="icon" class="icon" readonly value="<?php $Photo = rb_get_photo_details_from_id( isset($row) ? $row['icon_id'] : 0 ); print $Photo['file_name']; ?>" />
  </label>
  <label>
    Area:
    <!--<input type="text" name="area_id" value="<?php if(isset($row)) echo $row['area_id']; ?>" />-->
    <select name="area_id">
      <?php while ($area = $qa->fetch_assoc()): ?>
        <option value="<?= $area['id'] ?>" <?php if(isset($row) && $row['area_id']==$area['id']) echo "selected" ?>><?= $area['titulo'] ?></option>
      <?php endwhile; ?>
    </select>
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
