<?php
require_once "funcs.php";
include_once ABSPATH.'rb-admin/tinymce/tinymce.config.php';
$objDataBase = new Database;

if( isset($_GET['product_id']) ){
  $id=$_GET['product_id'];
  $q = $objDataBase->Ejecutar("SELECT * FROM plm_coupons WHERE id=$id");
  $row = $q->fetch_assoc();
}else{
  $id = 0;
}
?>
<script src="<?= G_DIR_MODULES_URL ?>plm/coupons.js"></script>
<div class="inside_contenedor_frm">
  <div id="toolbar">
    <div class="inside_toolbar">
      <div class="navigation">
        <a href="<?= G_SERVER ?>/rb-admin/module.php?pag=plm_coupons">Cupones</a> <i class="fas fa-angle-right"></i>
        <?php if(isset($row)): ?>
          <?= rb_fragment_letters($row['code'], 40) ?>
        <?php else: ?>
          <span>Nuevo cupón</span>
        <?php endif ?>
      </div>
    	<button class="button btn-primary" type="submit" form="frmEdit">Guardar</button>
    	<a class="button" href="<?= G_SERVER ?>/rb-admin/module.php?pag=plm_coupons">Volver</a>
    </div>
  </div>
  <form id="frmEdit" class="form">
    <div class="cols-container">
      <div class="cols-8-md col-padding-right">
        <section class="seccion">
        	<div class="seccion-header">
        		<h3>Informacion del cupón</h3>
        	</div>
        	<div class="seccion-body">
            <input type="hidden" id="id" name="id" value="<?= $id ?>" required />
            <label>
      		    Código del cupón *
      		    <input type="text" id="code" name="code"  required value="<?php if(isset($row)) echo $row['code'] ?>" />
      		  </label>
            <label>
              Descripción
              <span class="info">Detalle información importante para el cliente.</span>
              <textarea rows="5" id="description" name="description"><?php if(isset($row)) echo $row['description'] ?></textarea>
            </label>
      			<label>
              Monto cupón *
              <input type="number" id="amount" name="amount"  required value="<?php if(isset($row)) echo $row['amount'] ?>" />
            </label>
            <label>
              Tipo *
              <select id="type" name="type">
                <option value="0" <?php if(isset($row) && $row['type']==0) print "selected" ?>>Fijo</option>
                <option value="1" <?php if(isset($row) && $row['type']==1) print "selected" ?>>Porcentaje</option>
              </select>
            </label>
            <label>
              Estado *
              <select id="status" name="status">
                <option value="0" <?php if(isset($row) && $row['status']==0) print "selected" ?>>Inactivo</option>
                <option value="1" <?php if(isset($row) && $row['status']==1) print "selected" ?>>Activo</option>
              </select>
            </label>
          </div>
        </section>
      </div>
      <div class="cols-4-md col-padding-left">
        <section class="seccion">
          <div class="seccion-header">
            <h3>Limites</h3>
          </div>
          <div class="seccion-body">
            <label>
              Fecha expiración: 
              <input type="date" id="date_expired" name="date_expired"  value="<?php if(isset($row)) echo rb_sqldate_to($row['date_expired'], 'Y-m-d') ?>" />
            </label>
            <label>
              Monto mínimo:
              <input type="number" id="expensive_min" name="expensive_min"  value="<?php if(isset($row)) echo $row['expensive_min'] ?>" />
            </label>
            <label>
              Monto máximo:
              <input type="number" id="expensive_max" name="expensive_max"  value="<?php if(isset($row)) echo $row['expensive_max'] ?>" />
            </label>
            <label>
              Limite por usuario
              <input type="number" id="limit_by_user" name="limit_by_user"  value="<?php if(isset($row)) echo $row['limit_by_user'] ?>" />
            </label>
          </div>
        </section>

      </div>
    </div>
  </form>
</div>