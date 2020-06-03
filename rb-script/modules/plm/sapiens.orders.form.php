<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH."global.php";
require_once ABSPATH."rb-script/class/rb-database.class.php";
$urlreload=G_SERVER.'rb-admin/module.php?pag=sapiens_orders';

$objDataBase = new DataBase;
$mode = "new";
$order_id = 0;
if(isset($_GET['id']) && $_GET['id'] > 0):
	$order_id = $_GET['id'];
	$r = $objDataBase->Ejecutar("SELECT * FROM sapiens_orders WHERE id=".$order_id);
	$row = $r->fetch_assoc();
	$mode = "upd";
endif;
?>
<form id="frmData" class="form">
	<input type="hidden" name="mode" value="<?= $mode ?>" required />
	<input type="hidden" name="id" value="<?= $order_id ?>" required />
  <input type="hidden" name="sendmail" value="0" required />
  <div class="cols-container">
    <div class="cols-4-md">
      <!--<label>
        Titulo libro:
        <input type="text" name="book_title" required value="<?php if(isset($row)) echo $row['book_title']; ?>" />
      </label>
    	<label>
    	  URL Libro:
        <input type="text" name="book_url" required value="<?php if(isset($row)) echo $row['book_url']; ?>" />
      </label>-->
      <label>
    		Nombres:
        <input type="text" name="names" value="<?php if(isset($row)) echo $row['names']; ?>" />
      </label>
      <label>
        Apellidos:
        <input type="text" name="lastnames" value="<?php if(isset($row)) echo $row['lastnames']; ?>" />
      </label>
    	<label>
    		Correo:
        <input type="email" name="email" value="<?php if(isset($row)) echo $row['email']; ?>" />
      </label>
    	<label>
    		Telefono:
        <input type="tel" name="phone" value="<?php if(isset($row)) echo $row['phone']; ?>" />
      </label>
      <label>
        Carrera:
        <input type="text" name="career" value="<?php if(isset($row)) echo $row['career']; ?>" />
      </label>
      <label>
        Colegio:
        <input type="text" name="school" value="<?php if(isset($row)) echo $row['school']; ?>" />
      </label>
      <label>
        Direccion:
        <input type="text" name="address" value="<?php if(isset($row)) echo $row['address']; ?>" />
      </label>
      <h4>Entrega</h4>
      <?php if(isset($row) && $row['delivery']==0): ?>
        <p>Envio a domicilio</p>
      <?php endif ?>
      <?php if(isset($row) && $row['delivery']==1): ?>
        <p>Recogerá en tienda</p>
      <?php endif ?>
      <?php if(isset($row) && $row['delivery']==0): ?>
        <h4>Costo por envio</h4>
        <p>Pago S/. <?= $row['delivery_cost'] ?></p>
      <?php endif ?>
      
    </div>
    <div class="cols-8-md">
      <label>Detalle del pedido</label>
      <div class="sapi_details_order">
        <table class="tables table_orders">
          <?php if(isset($row)) echo $row['order_details']; ?>
        </table>
      </div>
    </div>
  </div>
  <div class="cols-container">
    <div class="cols-6-md cols-content-left">
      <!--<button type="submit" class="button btn-primary">Guardar</button>-->
    </div>
    <div class="cols-6-md cols-content-right">
      <button type="button" class="button CancelFancyBox">Cancelar</button>
    </div>
  </div>
</form>