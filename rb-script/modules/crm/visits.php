<?php
$objDataBase = new DataBase;
$qlist = $objDataBase->Ejecutar("SELECT * FROM crm_visits ORDER BY id DESC");
?>
  <section class="seccion">
    <div class="seccion-header">
      <h2>Visitas / atención al cliente</h2>
      <ul class="buttons">
        <li>
          <a class="btn-primary fancyboxForm fancybox.ajax" href="<?= G_DIR_MODULES_URL ?>crm/newedit.visit.php">Nuevo</a>
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
        <table id="table" class="tables table-striped">
          <thead>
            <tr>
                <th>Cliente</th>
                <th>Fecha Visita</th>
                <th>Observaciones</th>
                <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            <?php include_once 'list.visits.php' ?>
          </tbody>
        </table>
      </div>
    </div>
  </section>
<?php
$urlreload=G_SERVER.'rb-admin/module.php?pag=visits';
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
      url: "<?= G_SERVER ?>rb-script/modules/crm/del.visit.php?id="+id
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
