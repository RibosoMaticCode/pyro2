<section class="seccion">
  <div class="seccion-header">
    <h2>Suscriptores</h2>
    <ul class="buttons">
      <li><a class="button btn-primary fancyboxForm fancybox.ajax" href="<?= G_DIR_MODULES_URL ?>suscripciones/newedit.suscriptor.php">Nuevo</a></li>
      <li><a href="<?= G_DIR_MODULES_URL ?>suscripciones/list.print.php" class="button">Ver listado</a></li>
    </ul>
  </div>
  <div class="seccion-body">
    <div id="content-list">
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
            <th>Fecha</th>
            <th>ID Documento</th>
            <th>Nombres</th>
            <th>Correo</th>
            <th>Telefono</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php include_once 'list.suscriptores.php' ?>
        </tbody>
      </table>
    </div>
  </div>
</section>

<?php
$urlreload=G_SERVER.'rb-admin/module.php?pag=rb_sus_susc';
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
      url: "<?= G_SERVER ?>rb-script/modules/suscripciones/del.suscriptor.php?id="+id
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
