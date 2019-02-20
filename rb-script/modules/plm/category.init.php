<?php
/* Parametros iniciales para CRUD basico */
$title_section = "Categorias";
$file_prefix = "category";
$table_name = "plm_category";
$module_dir = "plm";
$key = "plm_category";

$newedit_path = G_DIR_MODULES_URL.$module_dir."/".$file_prefix.".newedit.php";
$urlreload=G_SERVER.'/rb-admin/module.php?pag='.$key;
require_once ABSPATH."rb-script/modules/plm/funcs.php";

$columns_title_coltable = [
  'Nombres' => 'nombre'
];

/* start */
$objDataBase = new DataBase;
$qlist = $objDataBase->Ejecutar("SELECT * FROM $table_name ORDER BY id DESC");
?>
<section class="seccion">
  <div class="seccion-header">
    <h2><?= $title_section ?></h2>
    <ul class="buttons">
      <li>
        <a class="btn-primary fancyboxForm fancybox.ajax" href="<?= $newedit_path ?>">Nuevo</a>
      </li>
    </ul>
  </div>
  <div class="seccion-body">
    <div class="cols-container">
      <div class="cols-6-md">
        <?php
        $categorias = list_category(0);

        function show_categories($categorias){
          $newedit_path = G_DIR_MODULES_URL."plm/category.newedit.php";
          echo "<ul class='categories_list'>\n";
          foreach ($categorias as $categoria) {
            ?>
            <li>
              <div><?= $categoria['nombre'] ?>
                <div class="option">
                  <a class="fancyboxForm fancybox.ajax" href="<?= $newedit_path ?>?parent_id=<?= $categoria['id'] ?>" title="Añadir categoria aqui"><i class="fa fa-plus-circle"></i></a>
                  <a href="#" title="Eliminar. Tambien se eliminaran sus items." class="del" data-item="<?= $categoria['id'] ?>"><i class="fa fa-times"></i></a>
                </div>
              </div>
              <?php
              if(isset($categoria['items'])){
                show_categories($categoria['items']);
              }?>
            </li>
            <?php
          }
          echo "</ul>";
        }

        show_categories($categorias);
        ?>
      </div>
    </div>
    <?php
    //print_r(list_category(0));
    ?>
  </div>
</section>
<script>
// Eliminar item
$('.del').on("click", function(event){
  event.preventDefault();
  var eliminar = confirm("¿Continuar con la eliminacion de este elemento?");
  if ( eliminar ) {
    var id = $(this).attr('data-item');
    $.ajax({
      type: "GET",
      url: "<?= G_DIR_MODULES_URL.$module_dir."/".$file_prefix ?>.del.php?id="+id
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
