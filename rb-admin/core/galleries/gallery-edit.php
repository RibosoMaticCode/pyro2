<?php
if(isset($_GET['m']) && $_GET['m']=="ok") msgOk("Cambios guardados");

$mode;
if(isset($_GET["id"])){
  // if define realice the query
  $id=$_GET["id"];
  $cons_art = $objDataBase->Ejecutar("SELECT * FROM albums WHERE id=$id");
  $row=$cons_art->fetch_assoc();
  $mode = "update";
}else{
  $mode = "new";
}
?>
<form id="galery-form" name="galery-form" method="post" action="core/galleries/gallery-save.php">
  <input type="hidden" name="user_id" value="<?= G_USERID ?>" />
      <div id="toolbar">
          <div id="toolbar-buttons">
                <span class="post-submit">
      <input class="submit" name="guardar" type="submit" value="Guardar" />
      <a href="../rb-admin/?pag=gal"><input title="Volver al listado" class="button" name="cancelar" type="button" value="Cancelar" /></a>

                </span>
            </div>
        </div>
        <div>
            <div class="content-edit">
              <section class="seccion">
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
                      <input maxlength="200"  name="grupo" type="text" value="<?php if(isset($row)) echo $row['galeria_grupo'] ?>" />
                    </label>

                    <label>Imagen de fondo:
                      <script>
                      $(document).ready(function() {
                        $(".explorer-file").filexplorer({
                          inputHideValue : "<?= isset($row) ? $row['photo_id'] : "0" ?>"
                        });
                      });
                      </script>
<!--													<input readonly name="imagen-categoria" type="text" class="explorer-file" value="<?php if(isset($row)): $photos = rb_get_photo_from_id($row['photo_id']); echo $photos['src']; endif ?>" />-->
                      <input name="imgfondo" type="text" class="explorer-file" readonly value="<?php if(isset($row)): $photos = rb_get_photo_from_id($row['photo_id']); echo $photos['src']; endif ?>" />
                    </label>
                  </div>
                </section>
            </div>
            <div id="sidebar">
              <?php if(isset($row)): ?>
                <section class="seccion">
                  <div class="seccion-body">
                    <a class="btn-primary" href="index.php?pag=imgnew&opc=nvo&album_id=<?php echo $row['id'] ?>">Subir imágenes</a>
                  </div>
                </section>
              <?php endif ?>
            </div>
  </div>
        <input name="mode" value="<?php echo $mode ?>" type="hidden" />
  <input name="id" value="<?php if(isset($row))echo $row['id'] ?>" type="hidden" />
  <input name="section" value="gal" type="hidden" />
</form>
