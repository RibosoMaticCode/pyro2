<?php
$album_id=$_GET["album_id"];
$qg = $objDataBase->Ejecutar("SELECT nombre FROM albums WHERE id=$album_id");
$rg= $qg->fetch_assoc();
?>
<h2 class="title"><?= $rg['nombre'] ?></h2>
<?php if (!in_array("imgnew", $array_help_close)): ?>
<div class="help" data-name="imgnew">
  <p>Puedes agregar nuevos elementos a tu Galería:</p>
  <ul>
    <li>Subir directamente tu imagen</li>
    <li>Seleccionar imágenes desde las que ya tienes subidas</li>
          <!--<li>O también agregar un video, presentación, etc. Solo tendrás que copiar el código que te proporciona tu servicio de medios favorito.</li>-->
  </ul>
</div>
<?php endif ?>
<div id="sidebar-left">
</div>
<div class="content">
  <!--<div class="wrap-home">-->
    <ul class="buttons-edition">
      <li><a class="btn-primary" href="<?= G_SERVER ?>/rb-admin/index.php?pag=img&album_id=<?= $album_id ?>">Volver</a></li>
    </ul>
    <section class="seccion">
      <div class="seccion-header">
        <h3>Subir archivos al albúm</h3>
      </div>
      <div class="seccion-body">
      <div id="mulitplefileuploader"></div>
      <div id="status"></div>
      <!-- Load multiples imagenes -->
      <link href="<?= G_SERVER ?>/rb-admin/resource/jquery.file.upload/uploadfile.css" rel="stylesheet">
      <script src="<?= G_SERVER ?>/rb-admin/resource/jquery.file.upload/jquery.uploadfile.js"></script>

      <script type="text/javascript">
      $(document).ready(function(){
        var settings = {
            url: "<?= G_SERVER ?>/rb-admin/uploader.php",
            dragDrop:true,
            fileName: "myfile",
            formData: {"albumid":"<?= $album_id ?>" , "user_id" : "<?= G_USERID ?>"},
            urlimgedit: '<?= G_SERVER."/rb-admin/index.php?pag=img&opc=edt&album_id=".$album_id."&id=" ?>',
            allowedTypes:"jpg,png,gif,doc,pdf,zip",
            returnType:"html", //json
          onSuccess:function(files,data,xhr)
            {
               //$("#status").append("Subido con exito");
            },
            //showDelete:true,
            deleteCallback: function(data,pd)
          {
            for(var i=0;i<data.length;i++)
            {
                $.post("delete.php",{op:"delete",name:data[i]},
                function(resp, textStatus, jqXHR)
                {
                    $("#status").append("<div>Archivo borrado</div>");
                });
             }
            pd.statusbar.hide(); //You choice to hide/not.

          }
        }

        var uploadObj = $("#mulitplefileuploader").uploadFile(settings);
      });
      </script>
      </div>
    </section>

    <?php
    if($userType == "user-panel"):
      $q = $objDataBase->Ejecutar("SELECT * FROM photo WHERE album_id=0 AND type IN ('image/gif','image/png','image/jpeg') AND usuario_id = ".G_USERID);
    else:
      $q = $objDataBase->Ejecutar("SELECT * FROM photo WHERE album_id=0 AND type IN ('image/gif','image/png','image/jpeg')");
    endif;
    if($q->num_rows):
    ?>
    <section class="seccion">
      <div class="seccion-header">
        <h3>Seleccionar imagenes de Biblioteca de medios</h3>
      </div>
      <div class="seccion-body">
        <div class="flibrary">
          <form action="core/galleries/img-add.php" method="POST" name="library">
            <input type="hidden" name="album_id" value="<?= $album_id ?>" />
            <input type="hidden" name="section" value="imgnew" />
            <ul class="wrap-grid">
            <?php

            while($r= $q->fetch_assoc()):
            ?>
            <li class="grid-1">
            <label>
              <div class="cover-img">
              <input class="checkbox" type="checkbox" name="items[]" value="<?= $r['id']?>" /> <br />
              <img class="thumb" src="<?= G_SERVER ?>/rb-media/gallery/tn/<?= $r['src'] ?>" /><br />
              </div>
            </label>
            </li>
            <?php
            endwhile;
            ?>
            </ul>

            <p style="text-align: center;"><input type="submit" value="Guardar seleccion" /></p>
          </form>
        </div>
      </div>
    </section>
    <?php
    endif;
    ?>
</div>
