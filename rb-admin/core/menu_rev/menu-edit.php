<?php
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
<script src="<?= G_SERVER ?>/rb-admin/core/menu/func.js"></script>
<form id="categorie-form" name="categorie-form" method="post" action="core/menu/menu-save.php">
  <div id="toolbar">
    <div id="toolbar-buttons">
      <span class="post-submit">
        <input class="submit" name="guardar" type="submit" value="Guardar" />
        <a href="<?= G_SERVER ?>/rb-admin/?pag=menus"><input title="Volver al listado" class="button" name="cancelar" type="button" value="Cancelar" /></a>
      </span>
    </div>
  </div>
  <div class="content-edit">
    <section class="seccion">
      <div class="seccion-body">
        <label>Nombre del Menu:
          <input required  name="nombre" type="text" value="<?php if(isset($row))echo $row['nombre'] ?>" />
        </label>
        <label>Clase CSS:
          <input required  name="nombre" type="text" value="<?php if(isset($row))echo $row['css'] ?>" />
        </label>
        <h4>Estructura del menu (Items)</h4>
        <nav class="menu-edition">
          <ul id="items_menu">
          </ul>
          <a href="#" id="addItem">Añadir item</a>
        </nav>
      </div>
    </section>
  </div>
  <input name="mode" value="<?php echo $mode; ?>" type="hidden" />
  <input name="section" value="menus" type="hidden" />
  <input name="id" value="<?php if(isset($row)) echo $row['id']; ?>" type="hidden" />
</form>
<?php include_once 'item-editor.php' ?>
