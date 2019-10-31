<?php
if(isset($_GET['m']) && $_GET['m']=="ok") msgOk("Cambios guardados");

$mode;
if(isset($_GET["id"])){
  // if define realice the query
  $id=$_GET["id"];
  $cons_art = $objDataBase->Ejecutar("SELECT * FROM ".G_PREFIX."galleries WHERE id=".$id);
  $row=$cons_art->fetch_assoc();
  $mode = "update";
}else{
  $mode = "new";
}
?>
<div class="inside_contenedor_frm">
<form class="form" id="galery-form" name="galery-form" method="post" action="core/galleries/gallery-save.php">
  <input type="hidden" name="user_id" value="<?= G_USERID ?>" />
  <div id="toolbar">
    <div class="inside_toolbar">
      <div class="navigation">
        <a href="<?= G_SERVER ?>rb-admin/?pag=gal">Galerias</a> <i class="fas fa-angle-right"></i>
        <?php if(isset($row)): ?>
          <span><?= $row['nombre'] ?></span>
        <?php else: ?>
          <span>Nueva galería</span>
        <?php endif ?>
      </div>
      <input class="btn-primary" name="guardar" type="submit" value="Guardar" />
      <?php if(isset($row)): ?>
        <a class="button btn-primary" href="index.php?pag=imgnew&opc=nvo&album_id=<?php echo $row['id'] ?>">Subir imágenes</a>
      <?php endif ?>
      <a class="button" href="<?= G_SERVER ?>rb-admin/?pag=gal">Volver</a>
    </div>
  </div>
  <section class="seccion">
    <div class="seccion-head">

    </div>
    <div class="seccion-body">
      <label title="Especifica un nombre a tu galeria de fotos" for="nombre">Nombre de la Galeria:
        <input  name="nombre" type="text" value="<?php if(isset($row))echo $row['nombre'] ?>" required />
      </label>
      <label title="Describe brevemente acerca de esta galeria">Descripcion:
        <span class="info">La descripción no es necesaria, salvo si su plantilla/diseño lo requiera.</span>
        <textarea name="descripcion" id="descripcion" cols="75" rows="15" style="width:100%; height:150px;"><?php if(isset($row))echo $row['descripcion'] ?></textarea>
      </label>
        <label title="Edita enlace amigable" for="titulo-enlace">Enlace por defecto:
        <input maxlength="200"  name="titulo_enlace" type="text" id="titulo-enlace" value="<?php if(isset($row)) echo $row['nombre_enlace'] ?>" />
      </label>
      <label>Grupo:
        <span class="info">Si deseas agrupar galerias, establece un texto identificador</span>
        <span class="info">O puedes elegir entre los grupos por defecto:
          <?php
          $grupos = rb_get_values_options('gallery_groups');
          $grupos = explode(",", $grupos);
          foreach ($grupos as $grupo) {
            ?>
            <a class="group" data-groupname="<?= trim($grupo) ?>" href="#"><?= trim($grupo) ?></a>
            <?php
          }
          ?>
        </span>
        <input maxlength="200" id="gallery_group" name="grupo" type="text" value="<?php if(isset($row)) echo $row['galeria_grupo'] ?>" />
      </label>
      <script>
      $(document).ready(function() {
        $(".group").click(function(event){
          $("#gallery_group").val($(this).attr('data-groupname'));
        });
      });
      </script>
      <label>Imagen de portada:
        <script>
          $(document).ready(function() {
            $(".explorer-file").filexplorer({
              inputHideValue : "<?= isset($row) ? $row['photo_id'] : "0" ?>"
            });
          });
        </script>
        <input name="imgfondo" type="text" class="explorer-file" readonly value="<?php if(isset($row)): $photos = rb_get_photo_from_id($row['photo_id']); echo $photos['src']; endif ?>" />
      </label>
      <label>
        <input type="checkbox" name="private" <?php if(isset($row) && $row['private']==1) echo "checked" ?>> Galería privada
      </label>
    </div>
  </section>
  <input name="mode" value="<?php echo $mode ?>" type="hidden" />
  <input name="id" value="<?php if(isset($row))echo $row['id'] ?>" type="hidden" />
  <input name="section" value="gal" type="hidden" />
</form>
</div>
