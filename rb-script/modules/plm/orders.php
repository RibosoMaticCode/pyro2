<?php
$objDataBase = new DataBase;
$qlist = $objDataBase->Ejecutar("SELECT * FROM plm_orders ORDER BY id DESC");
?>
<section class="seccion">
  <div class="seccion-header">
    <h2>Pedidos</h2>
  </div>
  <div class="seccion-body">
    <div id="content-list">
      <script>
        $(document).ready(function() {
          $('#table').DataTable({
            "language": {
              "url": "resource/datatables/Spanish.json"
            }
          });
        } );
      </script>
      <table id="table" class="tables table-striped">
        <thead>
          <tr>
            <th>ID</th>
            <th>Codigo único</th>
            <th>Fecha registro</th>
            <th>Usuario ID</th>
            <th>Total pagado</th>
            <th>Cargo ID</th>
            <th>Detalles</th>
            <!--<th>Acciones</th>-->
          </tr>
        </thead>
        <tbody>
          <?php include_once 'orders.list.php' ?>
        </tbody>
      </table>
    </div>
  </div>
</section>
<?php
$urlreload=G_SERVER.'rb-admin/module.php?pag=plm_orders';
?>
