<?php
if(isset($_GET['m']) && $_GET['m']=="ok") msgOk("Cambios guardados");

$mode;

if(isset($_GET["id"])){
  $mode = "update";
  $id=$_GET["id"];
  $q = $objDataBase->Ejecutar("SELECT * FROM photo WHERE id=$id");
  $row= $q->fetch_assoc();
}else{
  die("Usar otro metodo");
}
?>
<form enctype="multipart/form-data" id="galery-form" name="galery-form" method="post" action="save.php">
      <div id="toolbar">
          <div id="toolbar-buttons">
                <span class="post-submit">
      <input class="submit" name="guardar" type="submit" value="Guardar" />
      <a href="../rb-admin/?pag=files"><input title="Volver al listado" class="button" name="cancelar" type="button" value="Cancelar" /></a>
                </span>
            </div>
        </div>
  <div class="content-edit">
    <section class="seccion">
      <div class="seccion-body">
        <div class="files-container">
                    <picture>
                      <img src="<?= G_SERVER ?>/rb-media/gallery/<?= $row['src'] ?>" alt="previo" />
                    </picture>
                    <h3 class="subtitle">Nombre del archivo: <?php if(isset($row))echo $row['src'] ?></h3>

                    <div>
                        <label style="display: none" title="Selecciona la imagen" for="nombre">Selecciona tu archivo:
                          <input  name="fupload" type="file" />
                        </label>

                        <label title="Titulo de la foto">Titulo:
                          <textarea name="title" id="title" style="width:100%;"><?php if(isset($row))echo $row['title'] ?></textarea>
                        </label>
                      </div>
                  </div>
              </div>
    </section>
  </div>
        <input type="hidden" name="MAX_FILE_SIZE" value="30000" />
        <input name="album_id" value="0" type="hidden" />
        <input name="mode" value="<?php echo $mode ?>" type="hidden" />
  <input name="id" value="<?php if(isset($row))echo $row['id'] ?>" type="hidden" />
  <input name="section" value="files" type="hidden" />
</form>
