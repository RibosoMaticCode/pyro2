<?php
$album_id = $_GET["album_id"];
$result_g = $objDataBase->Ejecutar("SELECT nombre FROM ".G_PREFIX."galleries WHERE id=".$album_id);
$row_g = $result_g->fetch_assoc();
include_once ABSPATH.'rb-admin/tinymce/tinymce.mini.config.php';
?>
<div class="inside_contenedor_frm">
  <div id="toolbar">
    <div class="inside_toolbar">
      <div class="navigation">
        <a href="<?= G_SERVER ?>rb-admin/?pag=gal">Galerias</a> <i class="fas fa-angle-right"></i> <?= $row_g['nombre'] ?>
      </div>
      <a class="button btn-primary" href="<?= G_SERVER ?>rb-admin/?pag=imgnew&amp;opc=nvo&amp;album_id=<?= $album_id ?>"><i class="fa fa-plus-circle"></i> <span class="button-label">Agregar imagen</span></a>
      <a class="button btn-primary" href="#" id="imgSaveOrder"><i class="fas fa-save"></i> <span class="button-label">Guardar orden</span></a>
      <a class="button btn-delete" rel="img" data-albumid="<?= $album_id ?>" href="#" id="delete"><i class="fas fa-trash-alt"></i> <span class="button-label">Retirar</span></a>
      <a class="button" href="<?= G_SERVER ?>rb-admin/?pag=gal"><i class="fas fa-undo-alt"></i> <span class="button-label">Volver</span></a>
    </div>
  </div>

  <section class="seccion">
    <div class="seccion-body">
      <div id="content-list">
        <div id="resultado"> <!-- ajax asyncron here -->
          <script src="<?= G_SERVER ?>rb-admin/resource/ui/jquery-ui.js"></script>
          <script>
            $(document).ready(function() {
              // ELIMINAR VARIOS
              $('#delete').click(function( event ){
            		var len = $('input:checkbox[name=items]:checked').length;
            		if(len==0){
            			alert("[!] Seleccione un elemento a eliminar");
            			return;
            		}
                var album_id = $(this).attr('data-albumid');
            		var eliminar = confirm("[?] Esta seguro de eliminar los "+len+ " items?");
            		if ( eliminar ) {
            			$('input:checkbox[name=items]:checked').each(function(){
            				item_id = $(this).val();
            				url = 'core/galleries/img-remove.php?id='+item_id;
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
                    window.location.href = '<?= G_SERVER ?>rb-admin/index.php?pag=gal&album_id='+album_id;
                  }, 1000);
            		}
            	});
              // DELETE ITEM
              $('.del-item').click(function( event ){
                var album_id = $(this).attr('data-album-id');
                var item_id = $(this).attr('data-id');
                var eliminar = confirm("[?] Esta a punto de eliminar este dato. Continuar?");

              	if ( eliminar ) {
              		$.ajax({
              			url: 'core/galleries/img-remove.php?id='+item_id,
              			cache: false,
              			type: "GET",
              			success: function(data){
                      if(data.result = 1){
                        notify('El dato fue eliminado correctamente.');
                        setTimeout(function(){
                          window.location.href = '<?= G_SERVER ?>rb-admin/index.php?pag=gal&album_id='+album_id;
                        }, 1000);
                      }else{
                        notify('Ocurrio un error inesperado. Intente luego.');
                      }
              			}
              		});
              	}
              });
              // ORDER FOTOS
              $( "#grid" ).sortable();
              $( "#grid" ).disableSelection();

              $( '#imgSaveOrder').click ( function ( event ){
                var files = [];
                $( "#grid li" ).each(function( index ) {
                  files.push({
                      id: $( this ).attr('data-id'),
                      order: index
                  });
                });
                files = JSON.stringify( files );
                console.log( files );

                $.ajax({
                  method: "GET",
                  url: "core/galleries/gallery.img.save.order.php",
                  data: { jsonOrder : files }
                }).done(function( msg ) {
                  notify("Se guardo el orden de la fotos");
                  console.log( msg );
                });
              });
            });
          </script>
          <ul id="grid" class="wrap-grid">
            <?php include('img-list.php') ?>
          </ul>
        </div>
      </div>
    </div>
  </section>
</div>
