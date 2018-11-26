<?php
if ( !defined('ABSPATH') )
define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';
require_once ABSPATH.'rb-script/class/rb-database.class.php';
require_once ABSPATH.'rb-script/funciones.php';
//include_once ABSPATH.'rb-admin/tinymce/tinymce.config.php';
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
<form class="form" enctype="multipart/form-data" id="form-edit-img" name="galery-form" method="post">
  <div id="toolbar">
    <div id="toolbar-buttons">
      <span class="post-submit">
        <input class="btn-primary" name="guardar" type="submit" value="Guardar" />
        <!--<input class="submit" name="guardar_volver" type="submit" value="Guardar y Volver" />
        <a href="../rb-admin/?pag=img&album_id=<?php echo $album_id ?>"><input title="Volver al listado" class="button" name="cancelar" type="button" value="Cancelar" /></a>-->
      </span>
    </div>
  </div>
  <section class="seccion" style="max-width:800px">
    <div class="cols-container">
      <div class="cols-6-md">
        <picture>
          <img src="<?= G_SERVER ?>/rb-media/gallery/<?= $row['src'] ?>" alt="previo" />
        </picture>
        <h3 class="subtitle">Nombre del archivo: <?php if(isset($row))echo $row['src'] ?></h3>
        <label style="display: none" title="Selecciona la imagen" for="nombre">Selecciona tu archivo:
          <input  name="fupload" type="file" />
        </label>
      </div>
      <div class="cols-6-md">
        <div class="subform">
          <label title="Descripcion de la foto">Descripcion (puede incluir HTML):
            <!-- class="mceEditor" -->
            <textarea name="title" class="mceEditor" id="title" style="width:100%;"><?php if(isset($row))echo $row['title'] ?></textarea>
          </label>
          <h3>Enlazar con:</h3>
          <label>
             <input <?php if(isset($row) && $row['tipo']=="") echo " checked " ?> type="radio" name="tipo" value="" /> <span>Ninguno</span><br/>
          </label>
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
              $q = $objDataBase->Ejecutar("SELECT * FROM paginas WHERE type=0");
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
            <input <?php if(isset($row) && $row['tipo']=="you") echo " checked " ?> type="radio" name="tipo" value="you" /> <span>Youtube (Colocar codigo del video)</span><br />
            <input <?php if(isset($row) && $row['tipo']=="you") echo " value='".$row['url']."'" ?> placeholder="D4dyPBJeTko" autocomplete="off"  name="youtubecode" type="text" />
          </label>
          <label>
            <input <?php if(isset($row) && $row['tipo']=="fac") echo " checked " ?> type="radio" name="tipo" value="fac" /> <span>Video de Facebook (Escribir URL completa del video)</span><br />
            <input <?php if(isset($row) && $row['tipo']=="fac") echo " value='".$row['url']."'" ?> placeholder="https://" autocomplete="off"  name="facebookcode" type="text" />
          </label>
          <!--<label>
            <input <?php if(isset($row) && $row['tipo']=="obj") echo " checked " ?> type="radio" name="tipo" value="obj" />
            <span>Objetos externos como videos (Youtube, Vimeo), presentaciones (Slidesahre), etc </span>
            <span class="info">Si seleccionas está opción pega el código proporcionado por estos servicios en este recuadro</span>
            <textarea name="descripcion" id="descripcion" style="width:100%;"><?php if(isset($row))echo $row['description'] ?></textarea>
          </label>-->
        </div>
      </div>
    </div>
  </section>
  <input type="hidden" name="MAX_FILE_SIZE" value="30000" />
  <input name="album_id" value="<?php echo $album_id ?>" type="hidden" />
  <input name="mode" value="<?php echo $mode ?>" type="hidden" />
  <input name="id" value="<?php if(isset($row))echo $row['id'] ?>" type="hidden" />
  <input name="section" value="img" type="hidden" />
</form>
<script>
$(document).ready(function() {
	$("#form-edit-img").submit(function (event) {
		event.preventDefault();

		$.ajax({
				url: "core/galleries/img-save.php",
				method: 'post',
				data: $(this).serialize(),
				beforeSend: function(){
					$('#img_loading, .bg-opacity').show();
				}
		})
		.done(function( data ) {
			$('#img_loading, .bg-opacity').hide();
			notify(data.message);
		});
	});
});
</script>