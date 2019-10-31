<?php
$objDataBase = new DataBase;
$qlist = $objDataBase->Ejecutar("SELECT * FROM crm_notification ORDER BY id DESC");
include_once ABSPATH.'rb-admin/tinymce/tinymce.config.php';
?>

  <section class="seccion">
    <div class="seccion-header">
      <h2>Notificaciones</h2>
      <ul class="buttons">
        <li>
          <a class="btn-primary fancyboxFormEditor fancybox.ajax" href="<?= G_DIR_MODULES_URL ?>crm/newedit.notification.php">Nuevo</a>
        </li>
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
        <table id="table" class="tables">
          <thead>
            <tr>
                <th>Fecha registro</th>
                <th>Fecha envio</th>
                <th>Usuario remitente</th>
                <th>Cliente destinatario</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            <?php include_once 'list.notification.php' ?>
          </tbody>
        </table>
      </div>
    </div>
  </section>
<?php
$urlreload=G_SERVER.'rb-admin/module.php?pag=notifications';
?>
<script>
// Eliminar item
$('.del').on("click", function(event){
  event.preventDefault();
  var eliminar = confirm("[?] Esta seguro de eliminar este valor?");
  if ( eliminar ) {
    var id = $(this).attr('data-item');
    $.ajax({
      type: "GET",
      url: "<?= G_SERVER ?>rb-script/modules/crm/del.notification.php?id="+id
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

// Enviar mensaje a usuario
$(document).ready(function() {
  $('.send').on("click", function(event){
    var id = $(this).attr('data-item');
    $.ajax({
      type: "GET",
      url: "<?= G_SERVER ?>rb-script/modules/crm/notification.send.php?id="+id
    })
    .done(function( data ) {
      if(data.result){
        notify(data.msg);
        setTimeout(function(){
          window.location.href = '<?= $urlreload ?>';
        }, 1000);
      }else{
        notify(data.msg);
      }
    });
  });
});
</script>
