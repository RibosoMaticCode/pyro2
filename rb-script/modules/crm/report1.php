<?php
// Report1: Visita por cliente
$objDataBase = new DataBase;
$qlist = $objDataBase->Ejecutar("SELECT * FROM crm_customers ORDER BY id DESC");
?>
  <section id="visitsbycustomer" class="seccion">
    <div class="seccion-header">
      <h2>Visitas por cliente</h2>
    </div>
    <div class="seccion-body">
      <div id="content-report1">
        <script>
          $(document).ready(function() {
            $('#report1').DataTable({
              "language": {
                "url": "resource/datatables/Spanish.json"
              } 
            });
          } );
        </script>
        <table id="report1" class="tables table-striped">
          <thead>
            <tr>
              <th>Cliente</th>
              <th>Ultimos 15 días</th>
              <th>Ultimos 30 dias</th>
            </tr>
          </thead>
          <tbody>
          <?php
          while ($row = $qlist->fetch_assoc()):
            ?>
            <tr>
              <td><?= $row['nombres'] ?> <?= $row['apellidos'] ?></td>
              <?php
              $last15 =  count_last_days($row['id'], 15)->num_rows;
              $last30 =  count_last_days($row['id'], 30)->num_rows;
              ?>
              <td><a class="fancyboxForm fancybox.ajax" href="<?= G_SERVER ?>/rb-script/modules/crm/visit.details.php?id=<?= $row['id'] ?>&days=15"><?= $last15 ?></a></td>
              <td><a class="fancyboxForm fancybox.ajax" href="<?= G_SERVER ?>/rb-script/modules/crm/visit.details.php?id=<?= $row['id'] ?>&days=30"><?= $last30 ?></a></td>
            </tr>
            <?php
          endwhile;
          ?>
          </tbody>
        </table>
      </div>
    </div>
  </section>