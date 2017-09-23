<?php
require_once(ABSPATH."rb-script/funciones.php");
require_once(ABSPATH."rb-script/class/rb-paginas.class.php");
require_once(ABSPATH."rb-script/class/rb-galerias.class.php");

if(isset($_GET['m']) && $_GET['m']=="ok") msgOk("Cambios guardados");

    $mode;
    if(isset($_GET["id"])){
        // if define realice the query
        $id=$_GET["id"];
        $cons_art = $objPagina->Consultar("SELECT * FROM paginas WHERE id=$id");
        $row=mysql_fetch_array($cons_art);
        $mode = "update";
    }else{
        $mode = "new";
    }
include_once("tinymce.module.small.php");
?>
    <form id="article-form" name="article-form" method="post" action="save.php">
        <div id="toolbar">
            <div id="toolbar-buttons">
                <span class="post-submit">
                <input class="submit" name="guardar" type="submit" value="Guardar" />
                <input class="submit" name="guardar_volver" type="submit" value="Guardar y volver" />
                <a href="../rb-admin/?pag=pages"><input title="Volver al listado" class="button" name="cancelar" type="button" value="Volver" /></a>

                </span>
            </div>
        </div>
        <div>
            <div class="content-edit">
              <section class="seccion">
                <div class="seccion-body">
                    <input class="titulo" placeholder="Escribe el titulo aqui"  name="titulo" type="text" id="titulo" value="<?php if(isset($row)) echo $row['titulo'] ?>" required />
                    <textarea class="mceEditor" name="contenido" id="contenido" style="width:100%;"><?php if(isset($row)) echo stripslashes(htmlspecialchars($row['contenido'])); ?></textarea>
                    <a href="#" class="desactivar">Desactivar editor</a>
                    <script>
                      $( ".desactivar" ).on( "click", function(event) {
                        $(this).addClass('activar');
                        $(this).removeClass('desactivar');
                        tinymce.remove();
                      });
                    </script>
                <?php if($mode=="update"):?>
                  <?php
                  $tipo = "pagn";
                  if($row['popup']==1) $tipo = "popup";
                  ?>
                  <label>URL: (Copia esta URL para asociarla con otra página)</label>
                    <input type="text" value="<?= rb_url_link('pag',$row['id']) ?>" readonly />
                <?php endif ?>
                </div>
                </section>
            </div>
            <div id="sidebar">
              <!--<a class="btn-primary" href="index.php?pag=design&page_id=<?php if(isset($row)) echo $row['id']; else echo "0" ?>">Editar Estructura</a>-->
              <a class="fancybox fancybox.iframe" href="preview.php?page_id=<?php if(isset($row)) echo $row['id'] ?>">Vista previa</a>
                <section class="seccion">
                  <div class="seccion-header">
                    <h3>Otras opciones</h3>
                  </div>
                <div class="seccion-body">
          <label title="Tipo de Pagina" for="tipo" >Tipo:
                      <select  name="tipo" id="tipo">
                        <option <?php if(isset($row) && $row['popup']==0) echo "selected=\"selected\"" ?> value="0">Pagina Entera</option>
                          <option <?php if(isset($row) && $row['popup']==1) echo "selected=\"selected\"" ?> value="1">Bloque</option>
                      </select>
                      </label>

          <div id="galeria_embed_box">
                      <label title="Si deseas que se muestre una Galería de imágenes, selecciona una de la lista." for="galeria">
                      Asociar con galeria:
                      <span class="info">La galería de imágenes se mostrará al final del texto.</span>
                      <select name="galeria">
                        <option value="0">[ninguna]</option>
                        <?php
                        $q = $objGaleria->Consultar("SELECT * FROM albums");
              while($r_albums = mysql_fetch_array($q)):
              ?>
                          <option <?php if(isset($row)){ $row['galeria_id']; if($row['galeria_id'] == $r_albums['id']){ echo " selected "; } }  ?> value="<?= $r_albums['id'] ?>"><?= $r_albums['nombre'] ?></option>
              <?php
              endwhile;
                        ?>
                      </select>
                      </label>
                    </div>

                    <!--<label>Video
                      <span class="info">Puedes mostrar videos de Youtube unicamente (para que aparezca en contenido escribe <strong>[VIDEO]</strong>)</span>
                      <textarea placeholder="http://www.youtube.com/embed/CODIGO" name="video" rows="3"></textarea>
                    </label>-->

                    <label>Incluir Columna Lateral</label>
                    <select name="sidebar">
                      <option <?php if(isset($row) && $row['sidebar']==0) echo "selected=\"selected\"" ?> value="0">No</option>
                      <option <?php if(isset($row) && $row['sidebar']==1) echo "selected=\"selected\"" ?> value="1">Si</option>
                    </select>

                    <label title="Nombre del Menu a Seleccionar" for="menu-select">Nombre del Menu a Seleccionar:
            <input name="addon" type="text" id="menu-select" value="<?php if(isset($row)) echo $row['addon'] ?>" />
          </label>
          <!-- MENU SELECTED
          <label title="Nombre del Menu a Seleccionar" for="menu-select">Nombre del Menu a Seleccionar:
            <input name="addon" type="text" id="menu-select" value="<?php if(isset($row)) echo $row['addon'] ?>" />
          </label> -->

                    <div class="post-link">
                        <a onclick="more('link-title')" style="cursor:pointer;text-decoration:underline;" title="Mas alternativas">Mas &raquo;</a>
                    </div>
                    <div class="post-more" id="link-title" style="display:none;">
            <label title="Editar enlace amigable" for="titulo-enlace">Enlace por defecto:</label>
            <input maxlength="200"  name="titulo_enlace" type="text" id="titulo-enlace" value="<?php if(isset($row)) echo $row['titulo_enlace'] ?>" />
                        <!--<label title="Editar palabras claves">Palabras para buscadores (separar por comas):</label>
                        <input maxlength="200"  name="claves" type="text" id="claves" value="<?php if(isset($row)) echo $row['tags'] ?>" />-->
                    </div>
                  </div>
                </section>

                <section class="seccion">
                  <div class="seccion-header">
          <h3>Subir imagenes</h3>
        </div>
        <div class="seccion-body">
        <?php
        include_once ABSPATH.'rb-script/modules/rb-uploadimg/mod.uploadimg.php';
        ?>
        </div>
      </section>

                <div class="help">
              <h4>Información</h4>
              <p>
                Hay valores predefinidos del sistema que se pueden usar en el contenido. Se deben usar tal y cual esta escrito, incluyendo los corchetes.
              </p>
              <p>
                <strong>[SERVER_URL]</strong>: Muestra la url del sitio web.
              </p>
              <p>
                <strong>[SERVER_THEME]</strong>: Muestra la url donde estan los archivos de la apariencia del sitio web.
              </p>
            </div>
            </div>
        </div>
        <input name="section" value="pages" type="hidden" />
        <input name="mode" value="<?php echo $mode ?>" type="hidden" />
        <input name="id" value="<?php if(isset($row)) echo $row['id'] ?>" type="hidden" />
        <input name="userid" value="<?php echo G_USERID ?>" type="hidden" />

    </form>
