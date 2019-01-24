<?php
$objDataBase = new DataBase;
$qlist = $objDataBase->Ejecutar("SELECT * FROM crm_customers ORDER BY id DESC");
?>

  <section class="seccion">
    <div class="seccion-header">
      <h2>Clientes</h2>
      <ul class="buttons">
        <li>
          <a class="btn-primary fancyboxForm fancybox.ajax" href="<?= G_DIR_MODULES_URL ?>crm/newedit.customer.php">Nuevo</a>
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
              <th>Nombres</th>
              <th>Apellidos</th>
              <th>Telefono</th>
              <th>Correo electronico</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            <?php include_once 'list.customers.php' ?>
          </tbody>
        </table>
      </div>
    </div>
  </section>
<?php
$urlreload=G_SERVER.'/rb-admin/module.php?pag=customers';
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
      url: "<?= G_SERVER ?>/rb-script/modules/crm/del.customer.php?id="+id
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
