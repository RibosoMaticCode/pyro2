<?php
if(isset($_GET['m']) && $_GET['m']=="ok") msgOk("Cambios guardados");
?>
<form name="options-form" method="post" action="option-save.php">
  <div id="toolbar">
    <div id="toolbar-buttons">
      <span class="post-submit">
        <input class="button" name="guardar" type="submit" value="Guardar" />
      </span>
    </div>
  </div>
  <div class="content-centered">
    <section class="seccion">
      <div class="seccion-body">
        <!-- bloque 1 -->
        <div class="cols-container">
          <h3 class="subtitle">Datos del sitio web</h3>
          <div class="cols-6-md col-padding">
            <label title="Nombre del sitio" for="nombresitio">Nombre del Sitio Web:
              <input  name="nombresitio" type="text" value="<?= rb_get_values_options('nombresitio') ?>" required />
            </label>
            <label title="Descripcion del sitio" for="descripcion">Descripcion Sitio Web:
              <input  name="descripcion" type="text" value="<?= rb_get_values_options('descripcion') ?>" />
            </label>
            <label title="Direccion URL" for="direccionurl">Direccion URL (incluir http://):
              <input  name="direccionurl" type="text" value="<?= rb_get_values_options('direccion_url') ?>" required />
            </label>
            <label>Directorio URL:
              <input name="directoriourl" type="text" value="<?= rb_get_values_options('directorio_url') ?>" readonly />
            </label>
          </div>
          <div class="cols-6-md col-padding">
            <label title="Keywords" for="keywords">Meta Keywords (para Buscadores):
              <input  name="keywords" type="text" value="<?= rb_get_values_options('meta_keywords') ?>" />
            </label>
            <label title="Description" for="description">Meta Description (para Buscadores):
              <input  name="description" type="text" value="<?= rb_get_values_options('meta_description') ?>" />
            </label>
            <label title="Author" for="author">Meta Author (para Buscadores):
              <input  name="author" type="text" value="<?= rb_get_values_options('meta_author') ?>" />
            </label>
            <label>Favicon:
              <script>
              $(document).ready(function() {
                $(".explorer-file").filexplorer({
                  inputHideValue: "<?=  rb_get_values_options('favicon') ?>"
                });
              });
              </script>
              <input name="favicon" type="text" class="explorer-file" readonly value="<?php $photos = rb_get_photo_from_id( rb_get_values_options('favicon') ); echo $photos['src']; ?>" />
            </label>
          </div>
        </div>
        <!-- revisar -->
        <div class="cols-container">
          <h3 class="subtitle">Manejo de correos</h3>
          <div class="cols-6-md col-padding">
            <label title="Corre(os) que reciben los formularios de contacto" for="style">Correo receptor:
              <span class="info">El correo que recibe los formularios de contacto. Puede especificar varios, separelo por coma.</span>
              <input  name="mails" type="text" value="<?= rb_get_values_options('mail_destination') ?>" />
            </label>
            <label>Nombre de quien emite correo:
              <span class="info">El nombre de quien envia alguna respuesta al usuario final, visitante, etc.</span>
              <input  name="namesender" type="text" value="<?= rb_get_values_options('name_sender') ?>" />
            </label>
            <label title="Correo que envia información de registro" for="style">Correo emisor:
              <span class="info">El correo que envia alguna respuesta al usuario final, visitante, etc.</span>
              <input  name="mailsender" type="text" value="<?= rb_get_values_options('mail_sender') ?>" />
            </label>
          </div>
          <div class="cols-6-md col-padding">
            <label>
              ¿Usar librería externa para enviar correos?:
              <input type="text" name="lib_mail_native" value="<?= rb_get_values_options('lib_mail_native') ?>" />
            </label>
            <label>
              Api key de librería externa:
              <input type="text" name="sendgridapikey" value="<?= rb_get_values_options('sendgridapikey') ?>" />
            </label>
          </div>
        </div>
        <!-- Apariencia -->
        <div class="cols-container">
          <h3 class="subtitle">Funciones avanzadas</h3>
          <div class="cols-6-md col-padding">
            <label title="Campos personalizados" for="style">Campos personalizados:
              <span class="info">Estos campos aparecerán en la seccion Publicaciones, permiten añadir valores adicionales a los pre-establecidos.</span>
              <input  name="objetos" type="text" value="<?= rb_get_values_options('objetos') ?>" />
            </label>
            <label title="Numero de Items por Página" for="style">Numero de Publicaciones por Página:
              <span class="info">Cantidad de publicaciones a mostrar en el index (por defecto) y por categoria.</span>
              <input  name="post_by_category" type="text" value="<?= rb_get_values_options('post_by_category') ?>" />
            </label>
            <label>Logo:
              <script>
              $(document).ready(function() {
                $(".explorer-file").filexplorer({
                  inputHideValue: "<?=  rb_get_values_options('logo') ?>" // establacer un valor por defecto al cammpo ocutlo
                });
              });
              </script>
              <input name="logo" type="text" class="explorer-file" readonly value="<?php $photos = rb_get_photo_from_id( rb_get_values_options('logo') ); echo $photos['src']; ?>" />
            </label>
            <label>Imagen de fondo login:
              <script>
              $(document).ready(function() {
                $(".explorer-bgimage").filexplorer({
                  inputHideValue: "<?=  rb_get_values_options('background-image') ?>" // establacer un valor por defecto al cammpo ocutlo
                });
              });
              </script>
              <input name="bgimage" type="text" class="explorer-bgimage" readonly value="<?php $photos = rb_get_photo_from_id( rb_get_values_options('background-image') ); echo $photos['src']; ?>" />
            </label>
            <label>URL terminos y condiciones:
              <span class="info">Esta se muestra en la seccion de registro de usuarios</span>
              <input  name="terms_url" type="text" value="<?= rb_get_values_options('terms_url') ?>" />
            </label>
            <label title="Menu Principal" for="menu">Menu Principal: <a class="btn-secundary" href="<?= G_SERVER ?>/rb-admin/?pag=menus">Nuevo menú</a>
              <span class="info">Dependiendo de la plantilla instalada, el menú que eliga figurara en la parte superior de la web.</span>
              <select name="menu">
                <option value="0">Ninguno</option>
                <?php
                $q = $objDataBase->Ejecutar("SELECT * FROM menus ORDER BY nombre");
                while($r = $q->fetch_assoc()):
                  ?><option <?php if( rb_get_values_options('mainmenu_id') == $r['id'] ) echo " selected " ?> value="<?= $r['id'] ?>"><?= $r['nombre'] ?></option><?php
                endwhile;
                ?>
              </select>
            </label>
            <label title="Tema" for="tema">Plantilla del Sitio Web:
              <span class="info">Las plantillas temas se guardan en la carpeta raiz <code>rb-temas</code></span>
              <select  name="tema">
                <option value="0">Ninguno</option>
                <?php rb_list_themes('../rb-temas/',rb_get_values_options('tema')) ?>
              </select>
            </label>
            <label title="Pagina Index" for="index">¿Con qué página inicia el sitio web? <a class="btn-secundary" href="<?= G_SERVER ?>/rb-admin/?pag=pages">Nueva página</a></label>
            <span class="info">Puede elegir una en particular ó dejar por defecto según el tema instalado</span>
            <select  name="inicial">
              <option value="0">Por defecto</option>
              <?php
              $q = $objDataBase->Ejecutar("SELECT * FROM paginas ORDER BY titulo");

              while($r = $q->fetch_assoc()):
                ?><option <?php if( rb_get_values_options('initial') == $r['id'] ) echo " selected " ?> value="<?= $r['id'] ?>"><?= $r['titulo'] ?></option><?php
              endwhile;
              ?>
            </select>

            <label>Slide/Galería de Página Inicial <a class="btn-secundary" href="<?= G_SERVER ?>/rb-admin/?pag=album">Nuevo slide</a></label>
            <span class="info">Esto dependerá si su plantilla incluye y/o permite cambiar Slide/Galería.</span>
            <select name="slide">
              <option value="0">Ninguno</option>
              <?php
              $q = $objDataBase->Ejecutar("SELECT * FROM albums ORDER BY nombre");
              while($r = $q->fetch_assoc()):
                ?><option <?php if( rb_get_values_options('slide_main') == $r['id'] ) echo " selected " ?> value="<?= $r['id'] ?>"><?= $r['nombre'] ?></option><?php
              endwhile;
              ?>
            </select>
            <label>Tamaño de miniatura de imagen</label>
            <div class="cols-container">
              <div class="cols-6-md">
                <div class="cols-container">
                  <div class="cols-6-md" style="padding:2px 5px">
                    <span>Ancho</span>
                    <input name="t_width" type="text" value="<?= rb_get_values_options('t_width'); ?>" />
                  </div>
                  <div class="cols-6-md" style="padding:2px 5px">
                    <span>Alto</span>
                    <input name="t_height" type="text" value="<?= rb_get_values_options('t_height') ?>" />
                  </div>
                </div>
              </div>
              <div class="cols-6-md"></div>
            </div>

          </div>
          <div class="cols-6-md col-padding">
            <label>Enlace amigable para el sitio web:</label>
            <span class="info">Asegúrese que el archivo <code>.htaccess</code> figure en la raíz del sitio.</span>
            <label class="lbl-listoptions">
              <input name="amigable" type="radio" value="1" <?php if(rb_get_values_options('enlaceamigable')=='1') echo "checked=\"checked\""?> />
              Enlace amigable. Ej. <code>/articulos/mi-post-sobre-web/</code>
            </label>
            <label class="lbl-listoptions">
              <input name="amigable" type="radio" value="0" <?php if(rb_get_values_options('enlaceamigable')=='0') echo "checked=\"checked\""?> />
              Enlace estandar. Ej. <code>/?art=mi-post-sobre-web</code>
            </label>
            <span class="info">Solo si activo la opción URL amigables podrá ver reflejados los cambios</span>
            <label>Base para publicaciones:
              <input type="text" name="base_pub" value="<?= rb_get_values_options('base_publication') ?>" />
            </label>
            <label>Base para categorias:
              <input type="text" name="base_cat" value="<?= rb_get_values_options('base_category') ?>" />
            </label>
            <label>Base para usuarios:
              <input type="text" name="base_usu" value="<?= rb_get_values_options('base_user') ?>" />
            </label>
            <label>Base para busquedas:
              <input type="text" name="base_bus" value="<?= rb_get_values_options('base_search') ?>" />
            </label>
            <label>Base para paginado:
              <input type="text" name="base_pag" value="<?= rb_get_values_options('base_page') ?>" />
            </label>
            <label>URL inicial por defecto del Gestor:
              <span class="info">Por defecto la pagina inicial es index.php, pero se puede modificar aqui. <code><?= G_SERVER ?>/rb-admin/</code></span>
              <input  name="index_custom" type="text" value="<?= rb_get_values_options('index_custom') ?>" />
            </label>
            <label>Alcance del sitio web:</label>
            <!--<span class="info"></span>-->
            <label class="lbl-listoptions">
              <input name="alcance" type="radio" value="0" <?php if(rb_get_values_options('alcance')=='0') echo "checked=\"checked\""?> />
              Publico - acceso directo al index y otras partes del sitio
            </label>
            <label class="lbl-listoptions">
              <input name="alcance" type="radio" value="1" <?php if(rb_get_values_options('alcance')=='1') echo "checked=\"checked\""?> />
              Privado - para acceder al index tendra que loguearse previamente
            </label>
            <label>Barra lateral de blog</label>
            <span class="info">Configuracion de visualizacion de la barra lateral.</span>
            <label class="lbl-listoptions">
              <input name="sidebar" type="radio" value="0" <?php if(rb_get_values_options('sidebar')=='0') echo "checked=\"checked\""?> />
              Ocultar
            </label>
            <label class="lbl-listoptions">
              <input name="sidebar" type="radio" value="1" <?php if(rb_get_values_options('sidebar')=='1') echo "checked=\"checked\""?> />
              Mostrar
            </label>
            <div style="padding-left:15px">
              <label class="lbl-listoptions">
                <input name="sidebar_pos" type="radio" value="right" <?php if(rb_get_values_options('sidebar_pos')=='right') echo "checked=\"checked\""?> />
                A la derecha
              </label>
              <label class="lbl-listoptions">
                <input name="sidebar_pos" type="radio" value="left" <?php if(rb_get_values_options('sidebar_pos')=='left') echo "checked=\"checked\""?> />
                A la izquierda
              </label>
            </div>
          </div>
        </div>
        <!-- gestion de usuarios -->
        <div class="cols-container">
          <h3 class="subtitle">Gestión de usuarios</h3>
          <div class="cols-6-md col-padding">
            <label>Nivel por defecto para usuarios nuevos: <a class="btn-secundary" href="<?= G_SERVER ?>/rb-admin/?pag=nivel">Nuevo nivel</a>
              <span class="info">Cuando se registra por primera vez, que nivel tendrá el usuario.</span>
              <select name="nivel_user_register">
                <?php
                $q = $objDataBase->Ejecutar("SELECT * FROM usuarios_niveles");
                while($r = $q->fetch_assoc()):
                ?>
                <option <?php if( rb_get_values_options('nivel_user_register') == $r['id'] ) echo " selected " ?> value="<?= $r['id'] ?>"><?= $r['nombre'] ?></option>
                <?php
                endwhile;
                ?>
              </select>
            </label>
            <label>Activar usuario:</label>
            <span class="info">Cuando el usuario se registra, es necesario que se active, como medida de seguridad y para evitar el SPAM.</span>
            <label class="lbl-listoptions">
              <input name="user_active_admin" type="radio" value="2" <?php if(rb_get_values_options('user_active_admin')=='2') echo "checked=\"checked\""?> />
              Solo el Administrador puede activar al usuario nuevo
            </label>
            <label class="lbl-listoptions">
              <input name="user_active_admin" type="radio" value="1" <?php if(rb_get_values_options('user_active_admin')=='1') echo "checked=\"checked\""?> />
              El usuario puede activar su cuenta a través de un e-mail
            </label>
            <label class="lbl-listoptions">
              <input name="user_active_admin" type="radio" value="0" <?php if(rb_get_values_options('user_active_admin')=='0') echo "checked=\"checked\""?> />
              El usuario nuevo no necesita activar su cuenta
            </label>
          </div>
          <div class="cols-6-md col-padding">
            <label>Permitir registrar nuevo usuario desde la página web</label>
            <span class="info">Puede incluir un link para registrarse en la página de inicio de sesión ó no.</span>
            <label class="lbl-listoptions">
              <input name="linkregister" type="radio" value="1" <?php if(rb_get_values_options('linkregister')=='1') echo "checked=\"checked\""?> />
              Permitir e incluir link en la página de Inicio de Sesión
            </label>
            <label class="lbl-listoptions">
              <input name="linkregister" type="radio" value="0" <?php if(rb_get_values_options('linkregister')=='0') echo "checked=\"checked\""?> />
              No permitir, solo crear Usuario Nuevo desde Panel Administrativo
            </label>
          </div>
        </div>
        <!-- redes sociales -->
        <div class="cols-container">
          <h3 class="subtitle">Redes sociales</h3>
          <div class="cols-6-md col-padding">
            <label>Facebook:
              <input  name="fb" type="text" value="<?= rb_get_values_options('fb') ?>" />
            </label>
            <label>Twitter:
              <input  name="tw" type="text" value="<?= rb_get_values_options('tw') ?>" />
            </label>
            <label>Google +:
              <input  name="gplus" type="text" value="<?= rb_get_values_options('gplus') ?>" />
            </label>
            <label>Pinterest:
              <input  name="pin" type="text" value="<?= rb_get_values_options('pin') ?>" />
            </label>
          </div>
          <div class="cols-6-md col-padding">
            <label>LinkedIn:
              <input  name="in" type="text" value="<?= rb_get_values_options('in') ?>" />
            </label>
            <label>Instagram:
              <input  name="insta" type="text" value="<?= rb_get_values_options('insta') ?>" />
            </label>
            <label>Youtube:
              <input  name="youtube" type="text" value="<?= rb_get_values_options('youtube') ?>" />
            </label>
            <label>Whatsapp:
              <input  name="whatsapp" type="text" value="<?= rb_get_values_options('whatsapp') ?>" />
            </label>
          </div>
        </div>
        <!-- fin - redes sociales -->
        <!-- maps -->
        <div class="cols-container">
          <h3 class="subtitle">Google Maps</h3>
          <div class="cols-6-md col-padding">
            <label>Coordenada X:
              <input name="map-x" type="text" value="<?= rb_get_values_options('map-x') ?>" />
            </label>
            <label>Coordenada Y:
              <input name="map-y" type="text" value="<?=rb_get_values_options('map-y') ?>" />
            </label>
            <label>Zoom:
              <input name="map-zoom" type="text" value="<?= rb_get_values_options('map-zoom') ?>" />
            </label>
            <label>Descripción:
              <textarea name="map-desc" rows="5"><?= rb_get_values_options('map-desc') ?></textarea>
            </label>
          </div>
          <div class="cols-6-md col-padding">
          </div>
        </div>
      </div>
      <?php
        // DESTRIPAR VALOR JSON DE modules_options
        $json_modules = rb_get_values_options('modules_options');
        $array_modules = json_decode($json_modules, true);
        //print_r($array_modules); // solo para verificar transformacion de json a array
        ?>
        <!--<label>Modulos visibles</label>
        <span class="info">Los módulos serán funcionales siempre y cuando esten configurado en la plantilla. Mas información consular a Soporte.</span>
        <div class="cols-container">
          <div class="cols-3-md">
            <label>
              <input type="checkbox" name="modules[post]" value="1" <?php if($array_modules['post']==1) echo "checked" ?> /> Publicaciones
            </label>
            <label>
              <input type="checkbox" name="modules[cat]" value="1" <?php if($array_modules['cat']==1) echo "checked" ?> /> Categorias
            </label>
            <label>
              <input type="checkbox" name="modules[pag]" value="1" <?php if($array_modules['pag']==1) echo "checked" ?> /> Páginas
            </label>
          </div>
          <div class="cols-3-md">
            <label>
              <input type="checkbox" name="modules[com]" value="1" <?php if($array_modules['com']==1) echo "checked" ?> /> Comentarios
            </label>
            <label>
              <input type="checkbox" name="modules[file]" value="1" <?php if($array_modules['file']==1) echo "checked" ?> /> Archivos
            </label>
            <label>
              <input type="checkbox" name="modules[gal]" value="1" <?php if($array_modules['gal']==1) echo "checked" ?> /> Galeria
            </label>
          </div>
            <div class="cols-3-md">
            <label>
              <input type="checkbox" name="modules[usu]" value="1" <?php if($array_modules['usu']==1) echo "checked" ?> /> Usuarios
            </label>
            <label>
              <input type="checkbox" name="modules[mess]" value="1" <?php if($array_modules['mess']==1) echo "checked" ?> /> Mensajes
            </label>
            <label>
              <input type="checkbox" name="modules[men]" value="1" <?php if($array_modules['men']==1) echo "checked" ?> /> Editor de menus
            </label>
          </div>
          <div class="cols-3-md">
          </div>
        </div>
                  <label>
                      Código de formulario de contacto <br />
                      <span class="info">
                        La ruta del archivo que procesa y envia el mail es <code><?= G_SERVER ?>/rb-script/mailer.v2.php</code>, copia y pega en la atributo <strong>action</strong> del codigo del formulario.
                      </span>
                      <textarea name="form_code" rows="10"><?= rb_get_values_options('form_code') ?></textarea>
                </label>-->
                <!-- redes -->
    </section>
  </div>
  <div id="sidebar"></div>
  <input name="section" value="opc" type="hidden" />
</form>
