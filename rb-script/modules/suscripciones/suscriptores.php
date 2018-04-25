<div id="sidebar-left">
  <ul class="buttons-edition">
    <li><a class="btn-primary fancyboxForm fancybox.ajax" href="<?= G_DIR_MODULES_URL ?>suscripciones/newedit.suscriptor.php">Nuevo</a></li>
  </ul>
</div>
<div class="wrap-content-list">
  <section class="seccion">
    <div id="content-list">
      <table class="tables">
        <thead>
          <tr>
            <th>Fecha</th>
            <th>Nombres</th>
            <th>Correo</th>
            <th></th>
          <tr>
        </thead>
        <tbody>
          <?php include_once 'list.suscriptores.php' ?>
        </tbody>
      </table>
    </div>
    <div id="pagination">
    </div>
  </section>
</div>
<?php
$urlreload=G_SERVER.'/rb-admin/module.php?pag=rb_sus_susc';
?>
<script>
// Eliminar evento del dia
$('.del').on("click", function(event){
  event.preventDefault();
  var eliminar = confirm("[?] Esta seguro de eliminar este valor?");
  if ( eliminar ) {
    var id = $(this).attr('data-item');
    $.ajax({
      type: "GET",
      url: "<?= G_SERVER ?>/rb-script/modules/suscripciones/del.suscriptor.php?id="+id
    })
    .done(function( data ) {
      if(data.resultado){
        notify(data.contenido);
        setTimeout(function(){
          window.location.href = '<?= $urlreload ?>';
        }, 1000);
      }else{
        notify(data.contenido);
      }
    });
  }
});
</script>
