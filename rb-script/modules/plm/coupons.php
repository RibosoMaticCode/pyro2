<?php
$objDataBase = new DataBase;
$qlist = $objDataBase->Ejecutar("SELECT * FROM plm_coupons ORDER BY id DESC");
?>
<section class="seccion">
  <div class="seccion-header">
    <h2>Cupones</h2>
    <ul class="buttons">
      <li>
        <a class="button btn-primary" href="<?= G_SERVER ?>/rb-admin/module.php?pag=plm_coupons&product_id=0">Nuevo cupón</a>
      </li>
    </ul>
  </div>
  <div class="seccion-body">
    <div id="content-list">
      <table id="table" class="tables table-striped">
        <thead>
          <tr>
            <th>Fecha creación</th>
            <th>Codigo</th>
            <th>Descripción</th>
            <th>Tipo</th>
            <th>Monto</th>
            <th>Fecha expiración</th>
            <th>Monto mínimo</th>
            <th>Monto máximo</th>
            <th>Limite por usuario</th>
            <th>Estado</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php include_once 'coupons.list.php' ?>
        </tbody>
      </table>
    </div>
  </div>
</section>
<script src="<?= G_DIR_MODULES_URL ?>plm/coupons.js"></script>
