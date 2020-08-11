<div class="inside_contenedor_frm">
<?php
require_once 'funcs.php';
$mode;
if(isset($_GET["cat_id"]) && $_GET["cat_id"] > 0){
  // if define realice the query
  $id=$_GET["cat_id"];
  $cons_art = $objDataBase->Ejecutar("SELECT * FROM blog_categories WHERE id=$id");
  $row=$cons_art->fetch_assoc();
  $mode = "update";
  $cancel ="Cancelar";
  $new_button = '<a class="button" href="'.G_SERVER.'rb-admin/module.php?pag=rb_blog_category&cat_id=0">Nuevo</a>';
}else{
  $mode = "new";
  $cancel ="Cancelar";
  $new_button = "";
}
?>
<script>
  $(document).ready(function() {
    $(".explorer-file").filexplorer({
      inputHideValue : "<?= isset($row) ? $row['photo_id'] : "0" ?>"
    });
  });
</script>
<form class="form" id="categorie-form" name="categorie-form" method="post" action="<?= G_SERVER ?>rb-script/modules/rb_blog/categories.save.php">
  <div id="toolbar">
    <div class="inside_toolbar">
      <span class="post-submit">
        <input class="btn-primary" name="guardar" type="submit" value="Guardar" />
        <a href="<?= G_SERVER ?>rb-admin/module.php?pag=rb_blog_category" class="button"><?= $cancel ?></a>
        <?= $new_button ?>
      </span>
    </div>
  </div>
  <div>
    <div class="content-edit">
      <section class="seccion">
        <div class="seccion-body">
          <?php
          $title_category = "Categoría";
          if($mode=="new"):
            if(isset($_GET['parent_id']) && isset($_GET['niv'])):?>
            <label>Ruta / Ubicacion:
                <input readonly type="text" value="<?= rb_path_categories($_GET['parent_id']) ?>" />
                <?php $title_category = "Subcategoria" ?>
            </label>
            <?php
            endif;
          elseif($mode=="update"):
            if($row['nivel'] > 0 && $row['categoria_id'] > 0): ?>
              <label>Ruta / Ubicacion:
                  <input readonly type="text" value="<?= rb_path_categories($row['categoria_id']) ?>" />
                  <?php $title_category = "Subcategoria" ?>
              </label>
            <?php
            endif;
          endif ?>
          <label>Nombre <?= $title_category ?> <span class="required">*</span>:
            <input required  name="nombre" type="text" value="<?php if(isset($row))echo $row['nombre'] ?>" />
          </label>
          <label title="Descripcion de la categoria">Descripcion: <span class="info">La descripción no es necesaria, salvo si su plantilla/diseño lo requiera.</span>
            <textarea name="descripcion" id="descripcion" rows="4" style="width:100%; height:150px;"><?php if(isset($row))echo $row['descripcion'] ?></textarea>
          </label>
          <label title="Tag url" for="nombre">Enlace por defecto:
            <input  name="nombre_enlace" type="text" value="<?php if(isset($row))echo $row['nombre_enlace'] ?>" />
          </label>
        </div>
      </section>
    </div>
    <div id="sidebar">
      <!-- SECCION ACCESO POR NIVELES -- POR DEFECTO VISIBLE -->
      <section class="seccion">
        <div class="seccion-header">
          <h3>Acceso al categoria</h3>
          <a class="more" href="#"><span class="arrow-up">&#9650;</span><span class="arrow-down">&#9660;</span></a>
        </div>
        <div class="seccion-body">
          <label>
            <input type="radio" name="acceso" value="public" <?php if(isset($row) && $row['acceso']=="public"){ echo " checked "; }else{ echo " checked "; } ?> /> Publico
            <span class="info2">
              La categoría (y su contenido) puede ser vista por cualquier persona. No necesita registrarse.
            </span>
          </label>
          <label>
            <input type="radio" name="acceso" value="privat" <?php if(isset($row) && $row['acceso']=="privat"){ echo " checked "; } ?> /> Privado por niveles
            <span class="info2">
              La categoría (y su contenido) puede verla los usuarios registrados. También puede filtrar por niveles de usuarios que pueden ver.
            </span>
          </label>
          <div class="seccion-list-margin-left">
            <?php
            $q = $objDataBase->Ejecutar("SELECT * FROM ".G_PREFIX."users_levels WHERE id<>1");
            while($r = $q->fetch_assoc()):
            ?>
            <label>
              <?php if($mode=="new"): ?>
              <input checked type="checkbox" name="niveles[]" value="<?= $r['id'] ?>" /> <?= $r['nombre'] ?>
              <?php
              else:
                $array_niveles = explode(',',$row['niveles']);
              ?>
              <input type="checkbox" name="niveles[]" value="<?= $r['id'] ?>" <?php if(in_array($r['id'], $array_niveles)) echo " checked " ?> /> <?= $r['nombre'] ?>
              <?php endif; ?>
            </label>
            <?php
            endwhile;
            ?>
          </div>
        </div>
      </section>
      <section class="seccion">
        <div class="seccion-body">
          <label>Seleccionar imagen:
            <span class="info">De preferencia una imagen de las misma dimensión horizontal y vertical</span>
            <?php
              $photo_cat = "";
              if( isset($row) && $row['photo_id'] > 0){
                $Photo = rb_get_photo_details_from_id( $row['photo_id'] );
                $photo_cat = $Photo['file_name'];
              }
            ?>
            <input readonly name="imagen-categoria" type="text" class="explorer-file" value="<?= $photo_cat ?>" />
          </label>
        </div>
      </section>
    </div>
  </div>
  <input name="mode" value="<?php echo $mode; ?>" type="hidden" />
  <input name="section" value="cat" type="hidden" />
  <input name="id" value="<?php if(isset($row)) echo $row['id']; ?>" type="hidden" />
  <input name="nivel" value="<?php if(isset($row)) {echo $row['nivel'];}elseif(isset($_GET['niv'])){ echo $_GET['niv']; }else{ echo "0";} ?>" type="hidden" />
  <input name="parent_id" value="<?php if(isset($row)) {echo $row['categoria_id'];}elseif(isset($_GET['parent_id'])){ echo $_GET['parent_id']; }else{ echo "0";} ?>" type="hidden" />
</form>
</div>
