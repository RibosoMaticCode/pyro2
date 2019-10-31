<?php
if (!in_array("usu", $array_help_close)): ?>
<div class="help" data-name="usu">
  <h4>Información</h4>
  <p>Esta sección permite gestionar <strong>usuarios</strong>, activar y darle los permisos necesarios para acceso al sistema.</p>
</div>
<?php endif ?>
<script>
$(document).ready(function() {
  // SELECT ALL ITEMS CHECKBOXS
  $('#select_all').change(function(){
      var checkboxes = $(this).closest('table').find(':checkbox');
      if($(this).prop('checked')) {
        checkboxes.prop('checked', true);
      } else {
        checkboxes.prop('checked', false);
      }
  });
  // DELETE all
  $('#delete').click(function( event ){
		var len = $('input:checkbox[name=items]:checked').length;
		if(len==0){
			alert("[!] Seleccione un elemento a eliminar");
			return;
		}

		var eliminar = confirm("[?] Esta seguro de eliminar los "+len+ " items?");
		if ( eliminar ) {
      users_delete = {};
			$('input:checkbox[name=items]:checked').each(function(){
				item_id = $(this).val();
        userkey = $(this).attr('data-userkey');
        userid = $(this).attr('data-userid');

        user_delete = {};
        user_delete['userkey'] = userkey;
        user_delete['userid'] = userid;

        users_delete[item_id] = user_delete;
			});
      $.fancybox({
          href : '<?= G_SERVER ?>rb-admin/core/users/user.del.auth.php?users='+JSON.stringify(users_delete)
      }, {
          type: 'ajax'
      });
      console.log(users_delete);
		}
	});
});
</script>
<div class="wrap-content-list">
  <section class="seccion">
    <div class="seccion-header">
      <h2>Usuarios</h2>
      <ul class="buttons">
        <li><a class="button btn-primary" href="<?= G_SERVER ?>rb-admin/?pag=usu&opc=nvo"><i class="fa fa-plus-circle"></i> <span class="button-label">Nuevo</span></a></li>
        <li><a class="button btn-delete" rel="usu" href="#" id="delete"><i class="fa fa-times"></i> <span class="button-label">Eliminar</span></a></li>
      </ul>
    </div>
    <div class="seccion-body seccion-scroll">
      <div id="content-list">
        <div id="resultado">
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
                <th>Usuario</th>
                <th>Nombre Completo</th>
                <th>Correo</th>
                <th>Nivel Acceso</th>
                <th>Registro</th>
                <th>Ultimo acceso</th>
                <th>Activo</th>
                <th>Accions</th>
              </tr>
            </thead>
            <tbody id="itemstable">
            <?php include('user-list.php') ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </section>
  <a href="<?= G_SERVER ?>rb-admin/?pag=usu&opc=csv">Cargar archivo CSV</a>
</div>
