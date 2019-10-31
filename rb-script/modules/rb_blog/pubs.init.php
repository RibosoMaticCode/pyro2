<?php
if (!in_array("pub", $array_help_close)): ?>
<div class="help" data-name="pub">
  <h4>Información</h4>
  <p>Las <strong>Publicaciones</strong> permiten que el contenido aparezca en orden cronológico inverso en la página principal. Debido a su orden cronológico inverso, las Publicaciones se mostrarán de forma oportuna. Las antiguas serán archivadas conforme al mes y año en que fueron publicadas.</p>
  <p>Para una mejor gestión y administración del contenido, tienes la opción de organizarlas ​​en "categorías".</p>
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
				url = '<?= G_SERVER ?>rb-script/modules/rb_blog/pubs.del.php?id='+item_id;
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
        window.location.href = '<?= G_SERVER ?>rb-admin/module.php?pag=rb_blog_pubs';
      }, 1000);
		}
	});
  // DELETE ITEM
  $('.del-item').click(function( event ){
    var item_id = $(this).attr('data-id');
    var eliminar = confirm("[?] Esta a punto de eliminar este dato. Continuar?");

  	if ( eliminar ) {
  		$.ajax({
  			url: '<?= G_SERVER ?>rb-script/modules/rb_blog/pubs.del.php?id='+item_id,
  			cache: false,
  			type: "GET",
  			success: function(data){
          if(data.result = 1){
            notify('El dato fue eliminado correctamente.');
            setTimeout(function(){
              window.location.href = '<?= G_SERVER ?>rb-admin/module.php?pag=rb_blog_pubs';
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
<section class="seccion">
  <div class="seccion-header">
    <h2>Publicaciones</h2>
    <ul class="buttons">
    <li><a class="button btn-primary" href="<?= G_SERVER ?>rb-admin/module.php?pag=rb_blog_pubs&pub_id=0"><i class="fa fa-plus-circle"></i> <span class="button-label">Nuevo</span></a></li>
    <li><a class="button btn-delete" rel="art" href="#" id="delete"><i class="fa fa-times"></i> <span class="button-label">Eliminar</span></a></li>
  </ul>
  </div>
  <div class="seccion-body seccion-scroll">
    <?php
    if(isset($_GET['term'])){
      echo '<div id="message1">';
      echo '<p>Buscando: <strong>'.$_GET['term'].'</strong></p>';
      echo '</div>';
    }
    ?>
    <div id="content-list">
      <div id="resultado"> <!-- ajax asyncron here -->
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
              <th><input type="checkbox" value="all" id="select_all" /></th>
              <th>Título</th>
              <th>Autor</th>
              <th>Categoría</th>
              <th>Vistas</th>
              <th>Fecha</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody id="itemstable">
            <?php include('pubs.list.php') ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</section>
