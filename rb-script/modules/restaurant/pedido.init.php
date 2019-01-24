<?php
$title_section = "Generar pedido";
$file_prefix = "pedido";
$module_dir = "restaurant";
$newedit_path = G_DIR_MODULES_URL.$module_dir."/".$file_prefix.".newedit.php";

$objDataBase = new DataBase;
$qlist = $objDataBase->Ejecutar("SELECT * FROM rest_mesa ORDER BY id ASC");
?>
<section class="seccion">
  <div class="seccion-header">
    <h2><?= $title_section ?></h2>
  </div>
  <div class="seccion-body">
    <div class="mesas">
      <?php
      while($mesa = $qlist->fetch_assoc()){
        ?>
        <div class="cover-mesa">
          <a accesskey="<?= $mesa['id'] ?>" class="mesa fancyboxForm fancybox.ajax" href="<?= $newedit_path ?>?mesa=<?= $mesa['id'] ?>">
            <span><?= $mesa['nombre'] ?></span>
            <?php if($mesa['estado']==1){ ?>
            <span>En proceso..</span>
            <?php } ?>
          </a>
        </div>
        <?php
      }
      ?>
    </div>
  </div>
</section>
<script>
// Eliminar item
$('.mesa').on("click", function(event){
  event.preventDefault();

});
</script>
