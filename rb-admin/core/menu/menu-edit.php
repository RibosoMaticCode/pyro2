<?php
//require_once(ABSPATH."rb-script/class/rb-menus.class.php");
$mode;
if(isset($_GET["id"])){
  // if define realice the query
  $id=$_GET["id"];
  $cons = $objDataBase->Ejecutar("SELECT * FROM ".G_PREFIX."menus WHERE id=".$id);
  $row= $cons->fetch_assoc();
  $mode = "update";
}else{
  $mode = "new";
}
?>
<div class="inside_contenedor_frm">
<form id="categorie-form"class="form" name="categorie-form" method="post" action="core/menu/menu-save.php">
  <div id="toolbar">
    <div class="inside_toolbar">
      <div class="navigation">
        <a href="<?= G_SERVER ?>rb-admin/?pag=menus">Menus</a> <i class="fas fa-angle-right"></i>
        <?php if(isset($row)): ?>
          <span><?= $row['nombre'] ?></span>
        <?php else: ?>
          <span>Nuevo menú</span>
        <?php endif ?>
      </div>
      <input class="btn-primary" name="guardar" type="submit" value="Guardar" />
      <?php if(isset($row)): ?>
        <a class="button btn-primary" href="<?= G_SERVER ?>rb-admin/index.php?pag=menu&id=<?= $row['id'] ?>">Añadir items</a>
      <?php endif ?>
      <a class="button" href="<?= G_SERVER ?>rb-admin/?pag=menus">Cancelar</a>
    </div>
  </div>
    <section class="seccion">
      <div class="seccion-body">
        <label title="Nombre del Menu" for="nombre">Nombre del Menu:
          <input required  name="nombre" type="text" value="<?php if(isset($row))echo $row['nombre'] ?>" />
        </label>
      </div>
    </section>

  <input name="mode" value="<?php echo $mode; ?>" type="hidden" />
  <input name="section" value="menus" type="hidden" />
  <input name="id" value="<?php if(isset($row)) echo $row['id']; ?>" type="hidden" />
</form>
</div>
