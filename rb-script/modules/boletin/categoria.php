<section class="seccion">
  <div class="seccion-header">
    <h2>Categorias</h2>
    <ul class="buttons">
      <li><a class="button btn-primary fancyboxForm fancybox.ajax" href="<?= G_DIR_MODULES_URL ?>boletin/categoria.newedit.php">Nuevo</a></li>
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
            <th>Id</th>
            <th>Titulo</th>
            <th>Icon ID</th>
            <th>Area ID</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php include_once 'categoria.list.php' ?>
        </tbody>
      </table>
    </div>
  </div>
</section>
<script src="<?= G_DIR_MODULES_URL ?>boletin/categoria.js"></script>
