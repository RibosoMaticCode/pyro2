<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH."global.php";
require_once ABSPATH."rb-script/class/rb-database.class.php";
$urlreload=G_SERVER.'rb-admin/module.php?pag=rb_sus_susc';
$objDataBase = new DataBase;
$mode = "new";
$suscriptor_id = 0;
if(isset($_GET['id']) && $_GET['id'] > 0):
	$suscriptor_id = $_GET['id'];
	$r = $objDataBase->Ejecutar("SELECT * FROM suscriptores WHERE id=".$suscriptor_id);
	$row = $r->fetch_assoc();
	$mode = "upd";
endif;
?>
<form id="frmSuscrip" class="form">
	<input type="hidden" name="mode" value="<?= $mode ?>" required />
	<input type="hidden" name="id" value="<?= $suscriptor_id ?>" required />
  <label>
		Nombres:
    <input type="text" name="nombres" required value="<?php if(isset($row)) echo $row['nombres']; ?>" />
  </label>
	<label>
		Correo:
    <input type="email" name="correo" value="<?php if(isset($row)) echo $row['correo']; ?>" />
  </label>
	<label>
		Telefono:
    <input type="tel" name="telefono" value="<?php if(isset($row)) echo $row['telefono']; ?>" />
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
