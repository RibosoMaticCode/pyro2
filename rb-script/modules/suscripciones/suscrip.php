<section class="seccion">
  <div class="seccion-header">
    <h2>Suscriptores</h2>
    <ul class="buttons">
      <li><a class="button btn-primary fancyboxForm fancybox.ajax" href="<?= G_DIR_MODULES_URL ?>suscripciones/suscrip.newedit.php">Nuevo</a></li>
      <li><a href="<?= G_DIR_MODULES_URL ?>suscripciones/list.print.php" class="button">Ver listado</a></li>
    </ul>
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
            <th>Fecha</th>
            <th>Nombres</th>
            <th>Correo</th>
            <th>Telefono</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php include_once 'suscrip.list.php' ?>
        </tbody>
      </table>
    </div>
  </div>
</section>
<script src="<?= G_DIR_MODULES_URL ?>suscripciones/funcs.js"></script>
