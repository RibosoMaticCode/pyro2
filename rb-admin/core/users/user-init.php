<?php
if (!in_array("usu", $array_help_close)): ?>
<div class="help" data-name="usu">
  <h4>Información</h4>
  <p>Esta sección permite gestionar <strong>Usuarios</strong>. Activar y darle los permisos necesarios para acceso al sistema.</p>
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
			$('input:checkbox[name=items]:checked').each(function(){
				item_id = $(this).val();
				url = 'core/users/user-del.php?id='+item_id;
				$.ajax({
					url: url,
					cache: false,
					type: "GET"
				}).done(function( data ) {
          if(data.result==0){
            notify('Datos eliminados, pero usuario "admin" no');
            return false;
          }
        });
			});
      notify('Los datos seleccionados fueron eliminados correctamente.');
      setTimeout(function(){
        window.location.href = '<?= G_SERVER ?>/rb-admin/index.php?pag=usu';
      }, 1000);
		}
	});
  // DELETE ITEM
  $('.del-item').click(function( event ){
    var item_id = $(this).attr('data-id');
    //var eliminar = confirm("[?] Esta a punto de eliminar este usuario. Continuar?");
    var pass_admin = prompt("Solo usuarios nivel ADMIN, pueden eliminar cuentas. \nPor favor ingresa tu contraseña");
  	if (pass_admin != null) {
  		$.ajax({
  			url: 'core/users/user-del.php?user_id='+item_id+'&pwd_adm='+pass_admin,
  			cache: false,
  			type: "GET",
  			success: function(data){
          if(data.result == 1){
            notify('El dato fue eliminado correctamente.');
            setTimeout(function(){
              window.location.href = '<?= G_SERVER ?>/rb-admin/index.php?pag=usu';
            }, 1000);
          }else{
            notify(data.message);
          }
  			}
  		});
  	}
  });
});
</script>
<div id="sidebar-left">
  <ul class="buttons-edition">
    <li><a class="btn-primary" href="../rb-admin/?pag=usu&amp;opc=nvo"><img src="img/add-white-16.png" alt="Nuevo" /> Nuevo</a></li>
    <li><a class="btn-delete" rel="usu" href="#" id="delete"><img src="img/del-white-16.png" alt="Eliminar" /> Eliminar</a></li>
  </ul>
</div>
<div class="wrap-content-list">
  <section class="seccion">
    <div id="content-list">
      <div id="resultado">
        <table id="t_usuarios" class="tables" border="0" cellpadding="0" cellspacing="0">
          <thead>
            <tr>
              <th width="30px"><input type="checkbox" value="all" id="select_all" /></th>
              <th><h3>Usuario</h3></th>
              <th><h3>Nombre Completo</h3></th>
              <th><h3>Correo</h3></th>
              <th><h3>Nivel Acceso</h3></th>
              <th><h3>Activo</h3></th>
            </tr>
          </thead>
          <tbody id="itemstable">
          <?php include('user-list.php') ?>
          </tbody>
        </table>
      </div>
    </div>
    <div id="pagination">
    <?php include('user-paginate.php') ?>
    </div>
  </section>
</div>
