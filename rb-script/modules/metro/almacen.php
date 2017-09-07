<?php
function rb_content_almacen(){
  global $rb_module_url_main;
  $rb_module_url = G_SERVER."/rb-script/modules/metro/";
  $urlreload = G_SERVER."/rb-admin/module.php?pag=predi_alm";
  ?>
  <script>
  $(document).ready(function() {
    $('.del-item').click(function( event ){
      event.preventDefault();
      var id = $(this).attr('data-id');

      var eliminar = confirm("[?] Confirmar la eliminación permanente de este dato. ¿Continuar?");
      if ( eliminar ) {
        $.ajax({
          url: '<?= $rb_module_url ?>almacen.del.php?id='+id,
          cache: false,
          type: "GET",
          success: function(data){
            if(data.resultado=="ok"){
              notify('Eliminado');
                $( "#result-block" ).show().delay(5000);
              $( "#result-block" ).html(data.contenido);
              setTimeout(function(){
                window.location.href = '<?= $urlreload ?>';
              }, 1000);
            }

          }
        });
      }
    });
  });
  </script>
  <div class="help" data-name="cot_cli">
          <h4>Información</h4>
          <p>Esta sección gestiona los distintos almacenes de publicaciones de la predicacion metropolitana.</p>
    <a id="help-close" class="help-close" href="#">X</a>
  </div>
  <div id="sidebar-left">
    <ul class="buttons-edition">
      <li><a class="fancybox fancybox.ajax btn-primary" href="<?= $rb_module_url ?>almacen.frm.php"><img src="img/add-white-16.png" alt="Nuevo"> Nuevo</a></li>
    </ul>
  </div>
  <div class="wrap-content-list">
    <section class="seccion">
      <table class="tables">
        <thead>
          <tr>
            <th>Nombre del almacen</th>
            <th>Coordenadas</th>
            <th>Foto referencial</th>
          </tr>
        </thead>
        <tbody>
          <?php include('almacen.list.php') ?>
        </tbody>
      </table>
    </section>
  </div>
  <?php
}
add_function('module_content_main','rb_content_almacen');
?>
