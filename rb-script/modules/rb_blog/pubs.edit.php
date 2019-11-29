<?php
require_once 'funcs.php';
function SelectObject($nombre, $articulo_id, $tipo = 'image'){
  global $objDataBase;
  $result = $objDataBase->Ejecutar("SELECT contenido FROM blog_fields WHERE articulo_id=".$articulo_id." and tipo = '".$tipo."' and nombre = '".$nombre."' LIMIT 1");
  if($result->num_rows > 0){
    $row = $result->fetch_assoc();
    return $row['contenido'];
  }else{
    return false;
  }
}

$json_post_options = blog_get_option('post_options');
$array_post_options = json_decode($json_post_options, true);

if(isset($_GET['m']) && $_GET['m']=="ok") msgOk("Cambios guardados");
$mode;
if(isset($_GET["pub_id"]) && $_GET["pub_id"] > 0){
  $id=$_GET["pub_id"];
  $cons_art = $objDataBase->Ejecutar("SELECT *, DATE_FORMAT(fecha_creacion, '%Y-%m-%d') as fechamod, DATE_FORMAT(fecha_creacion, '%d-%m-%Y') as fechadmY FROM blog_posts WHERE id=$id");
  $row= $cons_art->fetch_assoc();
  $mode = "update";
  //$new_button = '<a href="'.G_SERVER.'/rb-admin/?pag=art&opc=nvo"><input title="Nuevo" class="button_new" name="nuevo" type="button" value="Nuevo" /></a>';
  $new_button = '<a class="button" href="'.G_SERVER.'rb-admin/module.php?pag=rb_blog_pubs&pub_id=0">Nuevo</a>';
  $qattr = $objDataBase->Ejecutar("SELECT * FROM blog_posts_posts WHERE articulo_id_padre =". $row['id']);
  $count_attr = $qattr->num_rows;
}
if(isset($_GET["pub_id"]) && $_GET["pub_id"] == 0){
  $mode = "new";
  $new_button = '';
  $count_attr = 0;
}
include_once("../rb-admin/tinymce/tinymce.config.php");

//Obtener cantidad de atributos
?>
<!-- JAVASCRIPT FUNCIONS -->
<script type="text/javascript" src="<?= G_SERVER ?>rb-script/modules/rb_blog/atributos.js.php?attrs=<?= $count_attr ?>"></script>
<script src="<?= G_SERVER ?>rb-admin/resource/ui/jquery-ui.js"></script>
<script>
  $.datepicker.regional['es'] = {
     closeText: 'Cerrar',
     prevText: '<Ant',
     nextText: 'Sig>',
     currentText: 'Hoy',
     monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
     monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
     dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
     dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
     dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
     weekHeader: 'Sm',
     dateFormat: 'dd/mm/yy',
     firstDay: 1,
     isRTL: false,
     showMonthAfterYear: false,
     yearSuffix: ''
   };
  $.datepicker.setDefaults($.datepicker.regional['es']);

  $(document).ready(function() {
    //Abre el cuadro de dialogo para mas extras para editar el post
    $( '#edit-config' ).click(function( event ) {
      event.preventDefault();
      $.post( "<?= G_SERVER ?>rb-script/modules/rb_blog/pubs.edit.options.php?s=posts" , function( data ) {
        $('.explorer').html(data);
        $(".bg-opacity").show();
          $(".explorer").fadeIn(500);
      });
    });
    // Validando AJAX antes de enviar datos
    $('#article-form').submit(function() {
      // Contenido
      var editorContent = tinyMCE.get('contenido').getContent();
      if (editorContent == '' || editorContent == null){
        notify("No hay contenido para guardar");
        return false;
      }
      // Categorias
      if( $('#article-form input[name="categoria[]"]:checked').length == 0 ){
        notify("Debe seleccionar al menos una categoria");
        return false;
      }
    });
    //Mostrar/ocultar editar la fecha del post
    $('#btnshowDateTimeCover').click( function (event){
      event.preventDefault();
      $('#coverFechaPublicacion').slideDown();
    });
    $('#btnhideDateTimeCover').click( function (event){
      event.preventDefault();
      $('#coverFechaPublicacion').slideUp();
    });
    //Asociar clase CSS para mostrar el explorador de archivos
    $(document).ready(function() {
      $(".explorer-file").filexplorer({
        inputHideValue : ""
      });
    });
    //Nueva categoria insitu
    $( ".popup" ).click(function( event ) {
      event.preventDefault();
      $( ".categoria_nueva" ).toggle();
      $( "#categoria_nombre" ).focus();
    });
    $( "#formcat" ).submit(function( event ) {
      event.preventDefault();
      $.ajax({
          method: "POST",
          url: "<?= G_SERVER ?>rb-script/modules/rb_blog/pubs.add.cat.php",
          data: $( "#formcat" ).serialize()
      }).done(function( msg ) {
          $('#catlist').append( msg );
          $( ".categoria_nueva" ).toggle();
          $( "#categoria_nombre" ).val("");
      });
    });
    $( "#cancel" ).click(function( event ) {
      event.preventDefault();
      $( ".categoria_nueva" ).toggle();
      $( "#categoria_nombre" ).val("");
    });
    // Agregar galeria y añadir fotos y situ
    $( ".popup_galeria" ).click(function( event ) {
      event.preventDefault();
      $( ".galeria_nueva" ).toggle();
      $( "#galeria_nombre" ).focus();
    });

    $( "#formgaleria" ).submit(function( event ) {
      event.preventDefault();
      $.ajax({
        method: "POST",
        url: "<?= G_SERVER ?>rb-script/modules/rb_blog/pubs.add.gallery.php",
        data: $( "#formgaleria" ).serialize()
      }).
      done(function( msg ) {
        $('#alblist').append( msg );
        $( ".galeria_nueva" ).toggle();
        $( "#galeria_nombre" ).val("");
      });
    });

    $( "#cancel_galeria" ).click(function( event ) {
      event.preventDefault();
      $( ".galeria_nueva" ).toggle();
      $( "#categoria_nombre" ).val("");
    });
    //Datapicker para fecha de actividades
    $('.fecha_actividad').datepicker();
    $('.fecha_actividad').datepicker('option', {
      minDate: 0,
      dateFormat: 'dd-mm-yy'
    });
    <?php
    if(isset($row) && $row['actividad']=='1'):
    ?>
    $('.fecha_actividad').datepicker('setDate', '<?= rb_a_ddmmyyyy($row['fecha_actividad']) ?>');
    <?php
    endif;
    ?>
    // Mostrar la galeria
    $( '#alblist' ).on("click", ".galleries", function( event ){
      event.preventDefault();
  		var albumId = $(this).attr('data-id');
  		$.post( "<?= rb_get_values_options('direccion_url') ?>/rb-script/modules/rb_blog/gallery.explorer.php?album_id="+albumId , function( data ) {
  		 	$('.explorer').html(data);
  		 	$(".bg-opacity").show();
  	   		$(".explorer").fadeIn(500);
  		});
  	});
  });
</script>
<div class="inside_contenedor_frm">
<form name="formcat" action="category.minisave.php" method="post" id="formcat"></form>
<form name="formgaleria" action="album.minisave.php" method="post" id="formgaleria"></form>
<form enctype="multipart/form-data" id="article-form" name="article-form" method="post" action="<?= G_SERVER ?>rb-script/modules/rb_blog/pubs.save.php">
  <div id="toolbar">
    <div class="inside_toolbar">
      <div class="navigation">
        <a href="<?= G_SERVER ?>rb-admin/module.php?pag=rb_blog_pubs">Publicaciones</a> > <span>Nuevo producto</span>
      </div>
      <input class="btn-primary" name="guardar" type="submit" value="Guardar" />
      <input class="btn-primary" name="guardar_volver" type="submit" value="Guardar y Volver" />
      <a href="<?= G_SERVER ?>rb-admin/module.php?pag=rb_blog_pubs" class="button">Cancelar</a>
      <?php
      if(isset($_GET["id"])){
        ?>
        <a class="button fancybox fancybox.iframe" href="<?= G_SERVER ?>?art=<?= $row['id'] ?>" target="_blank">Vista Preliminar</a>
        <?php
      }
      ?>
      <?= $new_button ?>
      <a id="edit-config" class="button edit-config" href="#">Configurar editor</a>
    </div>
  </div>
  <div class="content-edit">
    <!-- SECCION EDITOR -- POR DEFECTO VISIBLE -->
    <section class="seccion">
      <div class="seccion-body">
        <div class="form">
          <input autocomplete="off" placeholder="Escribe el titulo aqui" class="titulo" name="titulo" type="text" id="titulo" value="<?php if(isset($row)) echo $row['titulo'] ?>" required />
        </div>
        <textarea class=" mceEditor" name="contenido" id="contenido" style="width:100%;"><?php if(isset($row)) echo stripslashes(htmlspecialchars($row['contenido'])); ?></textarea>
        <a href="#" id="btnshowDateTimeCover">Establecer fecha de publicación</a>
        <div id="coverFechaPublicacion" class="form">
          <label title="Editar fecha publicacion">Fecha de Publicacion:
            <span class="info">El gestor establece la fecha y hora de publicación en el momento que se guardan los datos, si desea establecerlos manualmente, siga este formato: YYYY-MM-DD HH:MM:SS Ejemplo: <?= date("Y-m-d H:i:s") ?></span>
            <input maxlength="200"  name="fechamod" type="text" id="fechamod" value="<?php if(isset($row)) echo $row['fecha_creacion'] ?>" />
          </label>
          <a href="#" id="btnhideDateTimeCover">Cancelar</a>
        </div>
        <div class="form">
          <label>
            Estado publicación:
            <select name="estado">
              <option value="D" <?php if(isset($row) && $row['activo']=="D") echo "selected" ?>>Borrador</option>
              <option value="A" <?php if(isset($row) && $row['activo']=="A") echo "selected" ?>>Publicado</option>
            </select>
          </label>
        </div>
      </div>
    </section>
    <!-- SECCION ENLAZAR -->
    <section id="post-enl" class="seccion" <?php if($array_post_options['enl']==1) echo ' style="display:block" '; else echo ' style="display:none" ' ?>>
      <div class="seccion-header">
        <h3>Enlazar con otras Publicaciones</h3>
        <a class="more" href="#"><span class="arrow-up">&#9650;</span><span class="arrow-down">&#9660;</span></a>
      </div>
      <div class="seccion-body">
        <?php if(isset($row)):?>
          <table class="tables form" id="t_atributo" width="100%">
            <tr>
              <th>Nombre de Atributo</th>
              <th>Publicación</th>
              <th></th>
            </tr>
          <?php
          $qAll = $objDataBase->Ejecutar("SELECT titulo, id FROM blog_posts");
          $qo = $objDataBase->Ejecutar("SELECT * FROM blog_posts_posts WHERE articulo_id_padre =". $row['id']);
          while($Atributo = $qo->fetch_assoc()):
          ?>
            <tr>
              <td><input id="input_<?= $Atributo['id']?>" type="text" name="atributo[<?= $Atributo['id']?>][nombre]" value="<?= $Atributo['nombre_atributo'] ?>" /> </td>
              <td>
                <select class="select" data-id="<?= $Atributo['id']?>" id="select_<?= $Atributo['id']?>" required name="atributo[<?= $Atributo['id']?>][id]">
                <?php
                while($Posts = $qAll->fetch_assoc()):
                ?>
                  <option title="<?= $Posts['titulo'] ?>" value="<?= $Posts['id'] ?>" <?php if($Posts['id']==$Atributo['articulo_id_hijo']) echo " selected " ?>><?= $Posts['id'] ?>-<?= $Posts['titulo'] ?></option>
                <?php
                endwhile;
                $qAll->data_seek(0);
                //mysql_data_seek($qAll, 0)
                ?>
                </select>
              </td>
              <td><a title="Borrar" class="deleteAtributo" href="#"><img src="img/del-red-16.png" alt="delete" /></a></td>
            </tr>
          <?php
          endwhile;
          ?>
          </table>
          <a class="add" id="newAtributo" href="#">Añadir atributo</a>
        <?php else: ?>
          <table class="tables form" id="t_atributo" width="100%">
            <tr>
              <th>Nombre de Atributo</th>
              <th>Publicación</th>
              <th></th>
            </tr>
          </table>
          <a class="add" id="newAtributo" href="#">Añadir atributo</a>
        <?php endif; ?>
      </div>
    </section>
    <!-- SECCIONES ADJUNTOS -->
    <section id="post-adj" class="seccion" <?php if($array_post_options['adj']==1) echo ' style="display:block" '; else echo ' style="display:none" ' ?>>
      <div class="seccion-header">
        <h3>Adjuntos</h3>
        <a class="more" href="#"><span class="arrow-up">&#9650;</span><span class="arrow-down">&#9660;</span></a>
      </div>
      <div class="seccion-body form">
        <div id="featured-image">
          <!-- A C T U A L I Z A R -->
          <?php // if(isset($row)):?>
            <table id="t_imagen" class="tables form">
              <tr>
                <td width="40%"><strong>Imagen de Portada</strong>
                  <span class="info">Sirve como imagen de fondo, para slideshow, por lo general una imagen grande.</span>
                </td>
                <td>
                  <script>
                  $(document).ready(function() {
                    $(".explorer-back").filexplorer({
                      inputHideValue: "<?= isset($row) ? $row['img_back'] : 0 ?>"
                    });
                  });
                  </script>
                  <input name="img_back" type="text" id="img_back" class="explorer-back" readonly value="<?php $photos = rb_get_photo_from_id( isset($row) ? $row['img_back'] : 0 ); echo $photos['src']; ?>" />
                </td>
              </tr>
              <tr>
                <td><strong>Imagen Perfil</strong>
                  <span class="info">Sirve como imagen que identifica a la publicación o artículo.</span>
                </td>
                <td>
                  <script>
                  $(document).ready(function() {
                    $(".explorer-profile").filexplorer({
                      inputHideValue: "<?= isset($row) ? $row['img_profile'] : 0 ?>"
                    });
                  });
                  </script>
                  <input name="img_profile" type="text" id="img_profile" class="explorer-profile" readonly value="<?php $photos = rb_get_photo_from_id( isset($row) ? $row['img_profile'] : 0 ); echo $photos['src']; ?>" />
                </td>
              </tr>
            </table>
        </div>
      </div>
    </section>
    <!-- SECCIONES OTRAS OPCIONES -->
    <section id="post-edi" class="seccion" <?php if($array_post_options['edi']==1) echo ' style="display:block" '; else echo ' style="display:none" ' ?>>
      <div class="seccion-header">
        <h3>Opciones de Edición</h3>
        <a class="more" href="#"><span class="arrow-up">&#9650;</span><span class="arrow-down">&#9660;</span></a>
      </div>
      <div class="seccion-body form">
        <label>Enlace por defecto:
          <input maxlength="200"  name="titulo_enlace" type="text" id="titulo-enlace" value="<?php if(isset($row)) echo $row['titulo_enlace'] ?>" />
        </label>
        <label>Etiquetas <span class="info">palabras claves relacionadas con la Publicacion. Ej. viajes, caribe, ofertas</span>
          <input maxlength="200"  name="claves" type="text" id="claves" value="<?php if(isset($row)) echo $row['tags'] ?>" />
        </label>
      </div>
    </section>
  </div>
  <div id="sidebar">
    <!-- SECCION CATEGORIAS -- POR DEFECTO VISIBLE -->
    <section class="seccion">
      <div class="seccion-header">
        <h3>Categoria</h3>
        <a class="more" href="#"><span class="arrow-up">&#9650;</span><span class="arrow-down">&#9660;</span></a>
      </div>
      <div class="seccion-body form">
        <div class="post-categories">
          <?php if($userType == "admin"): ?>
          <a href="#" class="popup" title="Nueva Categoría">+</a>
          <?php endif ?>
          <div class="categoria_nueva" style="display:none">
            <input type="text" name="categoria_nombre" form="formcat" id="categoria_nombre" required value="" />
            <input type="submit" form="formcat" value="Guardar" /> <input type="button" form="formcat" value="Cancelar" id="cancel" />
          </div>
          <div id="catlist">
            <?php
              $cons_cat = $objDataBase->Ejecutar("SELECT * FROM blog_categories ORDER BY nombre ASC");
              while( $row_c = $cons_cat->fetch_assoc() ){
                $categoria_id=$row_c['id'];
                if(isset($row)){ // si esta definida variable con datos cargados para actualizar
                  //buscar las coincidencias articulos-categorias
                  $result = $objDataBase->Ejecutar("SELECT * FROM blog_posts_categories WHERE articulo_id=$id AND categoria_id=$categoria_id");
                  $coincidencia = $result->num_rows;
                }else{
                  $coincidencia = 0;
                }
                echo "<label class=\"label_checkbox\">";
                if($coincidencia>0){
                  echo "<input type=\"checkbox\" value=\"$row_c[id]\" checked=\"checked\" name=\"categoria[]\" /> $row_c[nombre] \n";
                }else{
                  echo "<input type=\"checkbox\" value=\"$row_c[id]\" name=\"categoria[]\" /> $row_c[nombre] \n";
                }
                echo "</label>";
              }
              ?>
          </div>
        </div>
      </div>
    </section>

    <!-- SECCION CAMPOS ADICIONALES -->
    <section id="post-adi" class="seccion" <?php if($array_post_options['adi']==1) echo ' style="display:block" '; else echo ' style="display:none" ' ?>>
      <div class="seccion-header">
        <h3>Campos adicionales</h3>
        <a class="more" href="#"><span class="arrow-up">&#9650;</span><span class="arrow-down">&#9660;</span></a>
      </div>
      <div class="seccion-body form">
      <div id="objects-extern" class="inseccion">
        <!-- actualizar -->
        <?php if(isset($row)):?>
        <table class="tables form" id="t_externo" width="100%">
            <tr>
              <th>Tipo</th>
              <th>Contenido</th>
            </tr>
          <?php
          $i=0;
          $objetos = blog_get_option('objetos');
          $array = explode(",",$objetos);
          $array_count = count($array);
          while($i<$array_count):
          ?>
            <tr>
              <td>
                <input name="externo[<?= trim($array[$i]) ?>][tipo]" type="hidden" value="<?= trim($array[$i]) ?>" />
                <?php echo trim($array[$i]) ?>
              </td>
              <td>
                <input name="externo[<?= trim($array[$i]) ?>][contenido]" type="text" value="<?= SelectObject(trim($array[$i]),$row['id'],'objeto') ?>"/>
              </td>
            </tr>
          <?php
          $i++;
          endwhile;
          ?>
        </table>
        <!-- nuevo -->
        <?php else: ?>
          <table class="tables form" id="t_externo" width="100%">
                      <tr>
                        <th>Tipo</th>
                        <th>Contenido</th>
                      </tr>
                      <?php
                      $i=0;
                      $objetos = blog_get_option('objetos');
            $array = explode(",",$objetos);
            $array_count = count($array);
                      while($i<$array_count):
                      ?>
                      <tr>
                        <td>
                          <input name="externo[<?= trim($array[$i]) ?>][tipo]" type="hidden" value="<?= trim($array[$i]) ?>" />
                          <?php echo trim($array[$i]) ?>
                        </td>
                        <td>
                          <input name="externo[<?= trim($array[$i]) ?>][contenido]" type="text" />
                        </td>
                      </tr>
                      <?php
                      $i++;
            endwhile;
                      ?>
                    </table>
                  <?php endif; ?>
      </div>
      </div>
      </section>

                <!-- SECCION GALERIAS / IMAGENES -->
                <section id="post-gal" class="seccion" <?php if($array_post_options['gal']==1) echo ' style="display:block" '; else echo ' style="display:none" ' ?>>
                  <div class="seccion-header">
                    <h3>Galerías e imágenes</h3>
                    <a class="more" href="#"><span class="arrow-up">&#9650;</span><span class="arrow-down">&#9660;</span></a>
                  </div>
                  <div class="seccion-body form">
                  <!--<div class="mitad">-->
          <div id="alblist">
          <?php
          if($userType == "user-panel"):
            $cons_cat = $objDataBase->Ejecutar("SELECT * FROM ".G_PREFIX."galleries WHERE usuario_id = ".G_USERID." ORDER BY nombre ASC");
          else:
            $cons_cat = $objDataBase->Ejecutar("SELECT * FROM ".G_PREFIX."galleries ORDER BY nombre ASC");
          endif;

          while($row_c = $cons_cat->fetch_assoc()){
            $album_id=$row_c['id'];
            /*if(isset($row)){ // si esta definida variable con datos cargados para actualizar
                //buscar las coincidencias articulos-categorias
                $result = $objDataBase->Ejecutar("SELECT * FROM articulos_albums WHERE articulo_id=$id AND album_id=$album_id");
              $coincidencia=$result->num_rows;
            }else{
                $coincidencia=0;
              }*/

                            echo "<label class=\"label_checkbox\">";
                            if(isset($row) && $row['gallery_id']==$album_id){
                              echo "<input type=\"radio\" value=\"$row_c[id]\" checked=\"checked\" name=\"albums\" /> $row_c[nombre]  (<a data-id='".$row_c['id']."' class='galleries' href='#'>Ver</a>) \n";
                            }else{
                                echo "<input type=\"radio\" value=\"$row_c[id]\" name=\"albums\" /> $row_c[nombre]  (<a data-id='".$row_c['id']."' class='galleries' href='#'>Ver</a>) \n";
                            }
                            echo "</label>";
                      }
          ?>
          </div>
          <a href="#" class="popup_galeria add" title="Nueva Galería">Nueva Galería</a>
                      <div class="galeria_nueva" style="display:none">
                        <input type="text" name="galeria_nombre" form="formgaleria" id="galeria_nombre" required value="" />
                        <input type="submit" form="formgaleria" value="Guardar" /> <input type="button" form="formgaleria" value="Cancelar" id="cancel_galeria" />
                      </div>
                  </div>
                  <div style="clear: both"></div>
              </section>

    <!-- SECCION VIDEO -->

    <!-- SECCION CALENDARIO -->

    <!-- SECCION OTRAS OPCIONES -->
    <section id="post-otr" class="seccion" <?php if($array_post_options['otr']==1) echo ' style="display:block" '; else echo ' style="display:none" ' ?>>
      <div class="seccion-header">
        <h3>Otras opciones</h3>
        <a class="more" href="#"><span class="arrow-up">&#9650;</span><span class="arrow-down">&#9660;</span></a>
      </div>
      <div class="seccion-body form">
        <span class="info">Estas opciones afectan las publicaciones dependiendo de la plantilla usada.</span>
        <label class="label_checkbox" for="featured">
          <?php $chektext = "Destacar <img src='img/star-16.png' alt='starred' />"?>
          <?php if(isset($row)):
          $check ="";
          if($row['portada']==1) $check = " checked=\"checked\" ";
          ?>
          <input type="checkbox" name="featured" id="featured" value="1" <?php echo $check ?> /> <?=$chektext?>
          <?php else: ?>
          <input type="checkbox" name="featured" id="featured" value="1" /> <?=$chektext?>
          <?php endif; ?>
        </label>
      </div>
    </section>

    <!-- SECCION SUBIR IMAGENES -->
    <section id="post-sub" class="seccion" <?php if($array_post_options['sub']==1) echo ' style="display:block" '; else echo ' style="display:none" ' ?>>
      <div class="seccion-header">
        <h3>Subir imagenes</h3>
        <a class="more" href="#"><span class="arrow-up">&#9650;</span><span class="arrow-down">&#9660;</span></a>
      </div>
      <div class="seccion-body form">
      <?php
      include_once ABSPATH.'rb-admin/plugin-form-uploader.php';
      ?>
      </div>
    </section>
  </div>

  <input name="section" value="art" type="hidden" />
  <input name="mode" value="<?php echo $mode ?>" type="hidden" />
  <input name="id" value="<?php if(isset($row)) echo $row['id'] ?>" type="hidden" />
  <input name="userid" value="<?php echo G_USERID ?>" type="hidden" />
</form>
</div>
