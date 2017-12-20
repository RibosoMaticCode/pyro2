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
<form id="categorie-form" name="categorie-form" method="post" action="core/menu/menu-save.php">
  <div id="toolbar">
    <div id="toolbar-buttons">
      <span class="post-submit">
        <input class="submit" name="guardar" type="submit" value="Guardar" />
        <a href="../rb-admin/?pag=menus"><input title="Volver al listado" class="button" name="cancelar" type="button" value="Cancelar" /></a>
      </span>
    </div>
  </div>
  <div class="content-edit">
    <section class="seccion">
      <div class="seccion-body">
        <label title="Nombre del Menu" for="nombre">Nombre del Menu:
          <input required  name="nombre" type="text" value="<?php if(isset($row))echo $row['nombre'] ?>" />
        </label>
      </div>
    </section>
  </div>
  <div id="sidebar">
    <?php if(isset($row)): ?>
      <section class="seccion">
        <div class="seccion-body">
          <a class="btn-primary" href="index.php?pag=menu&id=<?= $row['id'] ?>">Añadir items</a>
        </div>
      </section>
    <?php endif ?>
  </div>
  <input name="mode" value="<?php echo $mode; ?>" type="hidden" />
  <input name="section" value="menus" type="hidden" />
  <input name="id" value="<?php if(isset($row)) echo $row['id']; ?>" type="hidden" />
</form>
