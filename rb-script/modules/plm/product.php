<?php
$objDataBase = new DataBase;
$qlist = $objDataBase->Ejecutar("SELECT * FROM plm_products ORDER BY id DESC");
require_once ABSPATH."rb-script/modules/plm/funcs.php";
?>
<section class="seccion">
  <div class="seccion-header">
    <h2>Productos</h2>
    <ul class="buttons">
      <li>
        <a class="button btn-primary" href="<?= G_SERVER ?>rb-admin/module.php?pag=plm_products&product_id=0">Nuevo</a>
      </li>
      <li>
        <?php
        if(G_ENL_AMIG):
          $product_catalogue_link = G_SERVER."products/";
        else:
          $product_catalogue_link = G_SERVER."?products";
        endif;
        ?>
        <a class="button" target="_blank" href="<?= $product_catalogue_link ?>">Vista frontend</a>
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
            <th>Foto</th>
            <th>Nombre</th>
            <th>Nombre largo</th>
            <th>Categoria</th>
            <!--<th>Precio Final</th>
            <th>Descuento %</th>
            <th>Precio Normal</th>
            <th>Galeria</th>-->
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php include_once 'product.list.php' ?>
        </tbody>
      </table>
    </div>
  </div>
</section>
<?php
$urlreload=G_SERVER.'rb-admin/module.php?pag=plm_products';
?>
<script>
// Eliminar item
$('.del').on("click", function(event){
  event.preventDefault();
  var eliminar = confirm("La eliminacion es permanente. ¿Desea continuar?");
  if ( eliminar ) {
    var id = $(this).attr('data-item');
    $.ajax({
      type: "GET",
      url: "<?= G_SERVER ?>rb-script/modules/plm/product.del.php?id="+id
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
