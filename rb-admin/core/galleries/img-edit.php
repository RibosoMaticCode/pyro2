<?php
include_once("tinymce.module.small.php");
if(isset($_GET['m']) && $_GET['m']=="ok") msgOk("Cambios guardados");

$mode;
$album_id=$_GET["album_id"];
if(isset($_GET["id"])){
  $id=$_GET["id"];
  $q = $objDataBase->Ejecutar("SELECT * FROM photo WHERE id=$id");
  $row=$q->fetch_assoc();
  $mode = "update";
}else{
  $mode = "new";
}
?>
<form enctype="multipart/form-data" id="galery-form" name="galery-form" method="post" action="core/galleries/img-save.php">
  <div id="toolbar">
    <div id="toolbar-buttons">
      <span class="post-submit">
      <input class="submit" name="guardar" type="submit" value="Guardar" />
      <input class="submit" name="guardar_volver" type="submit" value="Guardar y Volver" />
      <a href="../rb-admin/?pag=img&album_id=<?php echo $album_id ?>"><input title="Volver al listado" class="button" name="cancelar" type="button" value="Cancelar" /></a>
      </span>
    </div>
  </div>
  <div>
            <div class="content-edit">
              <section class="seccion">
                <div class="seccion-body">
                  <div class="wrap-input">
                    <picture>
                      <img src="<?= G_SERVER ?>/rb-media/gallery/<?= $row['src'] ?>" alt="previo" />
                    </picture>
                    <h3 class="subtitle">Nombre del archivo: <?php if(isset($row))echo $row['src'] ?></h3>
                    <div>
                        <label style="display: none" title="Selecciona la imagen" for="nombre">Selecciona tu archivo:
                        <input  name="fupload" type="file" />
                        </label>
                        <label title="Titulo de la foto">Titulo:
                          <!-- class="mceEditor" -->
                        <textarea name="title" id="title" style="width:100%;"><?php if(isset($row))echo $row['title'] ?></textarea>
                        </label>
                        <!--<label title="URL">URL:
                          <input type="text" name="url" id="url" value="<?php if(isset($row))echo $row['url'] ?>" />
                        </label>-->
                      </div>
                  </div>
                  <div class="wrap-input">
          <h3 class="subtitle">Enlazar imagen con:</h3>
          <div class="subform">
          <label>
            <input <?php if(isset($row) && $row['tipo']=="art") echo " checked " ?> type="radio" name="tipo" value="art" /> <span>Publicación</span><br/>
            <select name="articulo" >
                      <?php
                      $q = $objDataBase->Ejecutar("SELECT * FROM articulos");
            while($r = $q->fetch_assoc()):
                      ?>
                        <option <?php if(isset($row) && $row['tipo']=="art" && $row['url'] == $r['id']) echo " selected " ?> value="<?= $r['id'] ?>"><?= $r['titulo'] ?></option>
                      <?php
            endwhile;
                      ?>
                      </select>
          </label>
          <label>
            <input <?php if(isset($row) && $row['tipo']=="pag") echo " checked " ?> type="radio" name="tipo" value="pag" /> <span>Página</span><br/>
            <select name="pagina" >
                      <?php
                      $q = $objDataBase->Ejecutar("SELECT * FROM paginas");
            while($r = $q->fetch_assoc()):
                      ?>
                        <option <?php if(isset($row) && $row['tipo']=="pag" && $row['url'] == $r['id']) echo " selected " ?> value="<?= $r['id'] ?>"><?= $r['titulo'] ?></option>
                      <?php
            endwhile;
                      ?>
                      </select>
          </label>
          <label>
            <input <?php if(isset($row) && $row['tipo']=="cat") echo " checked " ?> type="radio" name="tipo" value="cat" /> <span>Categoría</span><br />
            <select name="categoria" >
                      <?php
                      $q = $objDataBase->Ejecutar("SELECT * FROM categorias");
            while($r = $q->fetch_assoc()):
                      ?>
                        <option <?php if(isset($row) && $row['tipo']=="cat" && $row['url'] == $r['id']) echo " selected " ?> value="<?= $r['id'] ?>"><?= $r['nombre'] ?></option>
                      <?php
            endwhile;
                      ?>
                      </select>
          </label>
          <label>
            <input <?php if(isset($row) && $row['tipo']=="per") echo " checked " ?> type="radio" name="tipo" value="per" /> <span>Personalizado (incluir <strong>http://</strong> para que sea válido)</span><br />
            <input <?php if(isset($row) && $row['tipo']=="per") echo " value='".$row['url']."'" ?> placeholder="http://" autocomplete="off"  name="url" type="text" />
          </label>
          <label>
            <input <?php if(isset($row) && $row['tipo']=="obj") echo " checked " ?> type="radio" name="tipo" value="obj" />
            <span>Objetos externos como videos (Youtube, Vimeo), presentaciones (Slidesahre), etc </span>
            <span class="info">Si seleccionas está opción pega el código proporcionado por estos servicios en este recuadro</span>
            <textarea name="descripcion" id="descripcion" style="width:100%;"><?php if(isset($row))echo $row['description'] ?></textarea>
          </label>
          </div>
        </div>
        </div>
                </section>
            <div id="sidebar">

            </div>
  </div>
  <input type="hidden" name="MAX_FILE_SIZE" value="30000" />
  <input name="album_id" value="<?php echo $album_id ?>" type="hidden" />
  <input name="mode" value="<?php echo $mode ?>" type="hidden" />
  <input name="id" value="<?php if(isset($row))echo $row['id'] ?>" type="hidden" />
  <input name="section" value="img" type="hidden" />
</form>
