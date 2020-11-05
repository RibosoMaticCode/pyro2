<section class="seccion">
  <div class="seccion-header">
    <h2>Areas</h2>
    <ul class="buttons">
      <li><a class="button btn-primary fancyboxForm fancybox.ajax" href="<?= G_DIR_MODULES_URL ?>boletin/area.newedit.php">Nuevo</a></li>
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
            <th>ID</th>
            <th>Titulo</th>
            <th>Descripcion</th>
            <th>Image ID</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php include_once 'area.list.php' ?>
        </tbody>
      </table>
    </div>
  </div>
</section>
<script src="<?= G_DIR_MODULES_URL ?>boletin/area.js"></script>
