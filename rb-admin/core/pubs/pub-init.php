<?php if (!in_array("pub", $array_help_close)): ?>
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
				url = 'core/pubs/pub-del.php?id='+item_id;
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
        window.location.href = '<?= G_SERVER ?>/rb-admin/index.php?pag=art';
      }, 1000);
		}
	});
  // DELETE ITEM
  $('.del-item').click(function( event ){
    var item_id = $(this).attr('data-id');
    var eliminar = confirm("[?] Esta a punto de eliminar este dato. Continuar?");

  	if ( eliminar ) {
  		$.ajax({
  			url: 'core/pubs/pub-del.php?id='+item_id,
  			cache: false,
  			type: "GET",
  			success: function(data){
          if(data.result = 1){
            notify('El dato fue eliminado correctamente.');
            setTimeout(function(){
              window.location.href = '<?= G_SERVER ?>/rb-admin/index.php?pag=art';
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
    <li><a class="btn-primary" href="../rb-admin/?pag=art&amp;opc=nvo"><img src="img/add-white-16.png" alt="Nuevo" /> Nuevo</a></li>
    <li><a class="btn-primary" rel="art" href="#" id="delete"><img src="img/del-white-16.png" alt="delete" /> Eliminar</a></li>
  </ul>
</div>
<div class="wrap-content-list">
<section class="seccion">
  <?php
  if(isset($_GET['term'])){
    echo '<div id="message1">';
    echo '<p>Buscando: <strong>'.$_GET['term'].'</strong></p>';
    echo '</div>';
  }
  ?>
      <div id="content-list">
            <div id="resultado"> <!-- ajax asyncron here -->
            <table id="t_articulos" class="tables" border="0" cellpadding="0" cellspacing="0">
                <thead>
                    <tr>
                      <th width="30px"><input type="checkbox" value="all" id="select_all" /></th>
                      <th><h3>T&iacute;tulo</h3></th>
                      <th width="90px;"><h3>Destacado</h3></th>
                        <th class="col_autor" width="80px;"><center><h3>Autor</h3></center></th>
                        <th class="col_categoria" width="120px;"><h3>Categor&iacute;as</h3></th>
                        <th class="col_vistas" width="30px;"><h3>Vistas</h3></th>
                        <th class="col_fecha" width="80px;"><h3>Fecha</h3></th>
                    </tr>
                </thead>
                <tbody id="itemstable">
                <?php include('pub-list.php') ?>
                </tbody>
            </table>
            </div>
        </div>
  <div id="pagination">
  <?php include('pub-paginate.php') ?>
  </div>
</div>
</section>
