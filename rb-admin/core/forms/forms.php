<script src="<?= G_URLPANEL ?>core/forms.js"></script>
<div class="wrap-content-list">
  <section class="seccion">
    <div class="seccion-header">
      <h2>Formularios</h2>
      <ul class="buttons">
        <li><a class="button btn-primary" href="<?= G_SERVER ?>rb-admin/forms/new"><i class="fa fa-plus-circle"></i> <span class="button-label">Nuevo</span></a></li>
        <li><a class="button btn-delete" href="#" id="delete"><i class="fa fa-times"></i> <span class="button-label">Eliminar</span></a></li>
      </ul>
    </div>
    <div class="seccion-body">
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
            <th width="30px"><input type="checkbox" value="all" id="select_all" /></th>
            <th>Nombre</th>
            <th>Validaciones</th>
            <th>Shortcode</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php include('forms.list.php') ?>
        </tbody>
      </table>
    </div>
  </section>
</div>
