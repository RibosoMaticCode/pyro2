<section class="seccion">
  <div class="seccion-header">
    <h2>Contenidos</h2>
    <ul class="buttons">
      <li><a class="button btn-primary" href="<?= G_SERVER ?>rb-admin/module.php?pag=boletin_contenidos&id=0">Nuevo contenido</a></li>
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
            <th>Fecha</th>
            <th>Titulo</th>
            <th>Categoria</th>
            <th>Lecturas</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php include_once 'contenido.list.php' ?>
        </tbody>
      </table>
    </div>
  </div>
</section>
<script src="<?= G_DIR_MODULES_URL ?>boletin/contenido.js"></script>
