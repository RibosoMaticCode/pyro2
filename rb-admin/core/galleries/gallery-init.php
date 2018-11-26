<?php if (!in_array("gal", $array_help_close)): ?>
<div class="help" data-name="gal">
  <h4>Información</h4>
  <p>Las <strong>Galerías</strong> permiten agrupar u organizar solo imágenes. Se puede asociar con alguna Publicacion ó Pagina.</p>
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
				url = 'core/galleries/gallery-del.php?id='+item_id;
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
        window.location.href = '<?= G_SERVER ?>/rb-admin/index.php?pag=gal';
      }, 1000);
		}
	});
  // DELETE ITEM
  $('.del-item').click(function( event ){
    var item_id = $(this).attr('data-id');
    var eliminar = confirm("[?] Esta a punto de eliminar este dato. Continuar?");

  	if ( eliminar ) {
  		$.ajax({
  			url: 'core/galleries/gallery-del.php?id='+item_id,
  			cache: false,
  			type: "GET",
  			success: function(data){
          if(data.result = 1){
            notify('El dato fue eliminado correctamente.');
            setTimeout(function(){
              window.location.href = '<?= G_SERVER ?>/rb-admin/index.php?pag=gal';
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
<div id="sidebar-left">
  <ul class="buttons-edition">
    <li><a class="btn-primary" href="../rb-admin/index.php?pag=gal&amp;opc=nvo"><img src="img/add-white-16.png" alt="Editar" /> Nuevo</a></li>
    <li><a class="btn-delete" rel="gal" href="#" id="delete"><img src="img/del-white-16.png" alt="delete" /> Eliminar</a></li>
  </ul>
</div>
<div class="content">
  <div class="wrap-content-list">
    <section class="seccion">
      <div class="seccion-body">
        <div id="resultado"> <!-- ajax asyncron here -->
          <table id="t_articulos" class="tables" border="0" cellpadding="0" cellspacing="0">
            <thead>
              <tr>
                <th><input type="checkbox" value="all" id="select_all" /></th>
                <th>Portada</th>
                <th>Nombre</th>
                <th>Grupo</th>
                <th>Visualizar</th>
                <th>Fecha</th>
                <th>Imagenes</th>
              </tr>
            </thead>
            <tbody id="itemstable">
              <?php include('gallery-list.php') ?>
            </tbody>
          </table>
        </div>
      </div>
    </section>
  </div>
</div>
