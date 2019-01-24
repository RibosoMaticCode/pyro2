<?php
//require_once(ABSPATH."rb-script/class/rb-menus.class.php");
$mode;
if(isset($_GET["id"])){
  // if define realice the query
  $id=$_GET["id"];
  $cons = $objDataBase->Ejecutar("SELECT * FROM menus WHERE id=$id");
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
      <span class="post-submit">
        <input class="submit" name="guardar" type="submit" value="Guardar" />
        <a class="button" href="<?= G_SERVER ?>/rb-admin/?pag=menus">Cancelar</a>
      </span>
    </div>
  </div>
    <section class="seccion">
      <div class="seccion-body">
        <label title="Nombre del Menu" for="nombre">Nombre del Menu:
          <input required  name="nombre" type="text" value="<?php if(isset($row))echo $row['nombre'] ?>" />
        </label>
      </div>
    </section>
    <?php if(isset($row)): ?>
      <section class="seccion">
        <div class="seccion-body">
          <a class="btn-primary" href="index.php?pag=menu&id=<?= $row['id'] ?>">Añadir items</a>
        </div>
      </section>
    <?php endif ?>
  <input name="mode" value="<?php echo $mode; ?>" type="hidden" />
  <input name="section" value="menus" type="hidden" />
  <input name="id" value="<?php if(isset($row)) echo $row['id']; ?>" type="hidden" />
</form>
</div>
