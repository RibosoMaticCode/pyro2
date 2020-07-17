<?php
$menu_asincrono = true;
?>
<?php if (!in_array("menus", $array_help_close)): ?>
<div class="help" data-name="menus">
  <h4>Información</h4>
  <p>Dependiendo de la plantilla instalada podrás editar los <strong>Menús</strong> y sus elementos.</p>
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

    var url;
		var eliminar = confirm("[?] Esta seguro de eliminar los "+len+ " items?");
		if ( eliminar ) {
			$('input:checkbox[name=items]:checked').each(function(){
				item_id = $(this).val();
				url = 'core/menu/menu-del.php?id='+item_id;
				$.ajax({
					url: url,
					cache: false,
					type: "GET"
				}).done(function( data ) {
          if(data.result==0){
            notify('Ocurrio un error inesperado. Intente luego.');
            return false;
          }
        });
			});
      notify('Los datos seleccionados fueron eliminados correctamente.');
      setTimeout(function(){
        window.location.href = '<?= G_SERVER ?>rb-admin/index.php?pag=menus';
      }, 1000);
		}
	});
  // DELETE ITEM
  $('.del-item').click(function( event ){
    var item_id = $(this).attr('data-id');
    var eliminar = confirm("[?] Esta a punto de eliminar este dato. Continuar?");

  	if ( eliminar ) {
  		$.ajax({
  			url: 'core/menu/menu-del.php?id='+item_id,
  			cache: false,
  			type: "GET",
  			success: function(data){
          if(data.result = 1){
            notify('El dato fue eliminado correctamente.');
            setTimeout(function(){
              window.location.href = '<?= G_SERVER ?>rb-admin/index.php?pag=menus';
            }, 1000);
          }else{
            notify('Ocurrio un error inesperado. Intente luego.');
          }
  			}
  		});
  	}
  });
});
</script>
<div class="wrap-content-list">
  <section class="seccion">
    <div class="seccion-header">
      <h2>Menus</h2>
      <ul class="buttons">
        <li><a class="fancyboxForm fancybox.ajax button btn-primary" href="<?= G_SERVER ?>rb-admin/core/menu/menu-edit.php?id=0"><i class="fa fa-plus-circle"></i> <span class="button-label">Nuevo</span></a></li>
      </ul>
    </div>
    <div class="seccion-body">
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
                <th>Nombre</th>
                <th>Shortcode</th>
                <th>Tipo</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody id="itemstable">
            <?php include('menu-list.php') ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </section>
</div>
