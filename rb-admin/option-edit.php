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
        <!-- Datos generales -->
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
          </div>
        </div>
        <!-- Apariencia -->
        <div class="cols-container">
          <h3 class="subtitle">Apariencia</h3>
          <div class="cols-6-md col-padding">
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
            <label title="Tema" for="tema">Plantilla del Sitio Web:
              <span class="info">Las plantillas temas se guardan en la carpeta raiz <code>rb-temas</code></span>
              <select  name="tema">
                <option value="0">Ninguno</option>
                <?php rb_list_themes('../rb-temas/',rb_get_values_options('tema')) ?>
              </select>
            </label>
          </div>
          <div class="cols-6-md col-padding">
            <label title="Pagina Index" for="index">¿Con qué página inicia el sitio web? <a class="btn-secundary" href="<?= G_SERVER ?>/rb-admin/?pag=pages">Nueva página</a></label>
            <span class="info">Puede elegir una en particular ó dejar por defecto según el tema instalado</span>
            <select  name="inicial">
              <option value="0">Por defecto</option>
              <?php
              $q = $objDataBase->Ejecutar("SELECT * FROM paginas WHERE type=0 ORDER BY titulo");

              while($r = $q->fetch_assoc()):
                ?><option <?php if( rb_get_values_options('initial') == $r['id'] ) echo " selected " ?> value="<?= $r['id'] ?>"><?= $r['titulo'] ?></option><?php
              endwhile;
              ?>
            </select>
            <label>Bloque de cabecera personalizado</label>
            <!--<input type="text" name="block_header_id" value="<?= rb_get_values_options('block_header_ids') ?>" />-->
            <?php
  					$qh = $objDataBase->Ejecutar("SELECT * FROM paginas WHERE type=1 ORDER BY titulo");
  					?>
  					<select name="block_header_id">
  						<option value="0">Ninguno</option>
  						<?php while($header = $qh->fetch_assoc()): ?>
  						<option value="<?= $header['id'] ?>" <?php if($header['id']==rb_get_values_options('block_header_ids')) echo "selected" ?>><?= $header['titulo'] ?></option>
  						<?php endwhile ?>
  					</select>

            <label>Bloque de pie de pagina personalizado</label>
            <!--<input type="text" name="block_footer_id" value="<?= rb_get_values_options('block_footer_ids') ?>" />-->
            <?php
  					$qf = $objDataBase->Ejecutar("SELECT * FROM paginas WHERE type=2 ORDER BY titulo");
  					?>
            <select name="block_footer_id">
  						<option value="0">Ninguno</option>
  						<?php while($Footer = $qf->fetch_assoc()): ?>
  						<option value="<?= $Footer['id'] ?>" <?php if($Footer['id']==rb_get_values_options('block_footer_ids')) echo "selected" ?>><?= $Footer['titulo'] ?></option>
  						<?php endwhile ?>
  					</select>

            <label>Barra lateral de blog</label>
            <label>
              <select name="sidebar_id">
                <option value="0">Por defecto</option>
                <?php
                $q = $objDataBase->Ejecutar("SELECT * FROM paginas WHERE type=3 ORDER BY titulo");
                while($r = $q->fetch_assoc()):
                  ?><option <?php if( rb_get_values_options('sidebar_id') == $r['id'] ) echo " selected " ?> value="<?= $r['id'] ?>"><?= $r['titulo'] ?></option><?php
                endwhile;
                ?>
              </select>
            </label>
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
        <!-- Correos -->
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
          </div>
        </div>
        <!-- Funciones avanzadas -->
        <div class="cols-container">
          <h3 class="subtitle">Funciones avanzadas</h3>
          <div class="cols-6-md col-padding">
            <label title="Numero de Items por Página" for="style">Numero de Publicaciones por Página:
              <span class="info">Cantidad de publicaciones a mostrar en el index (por defecto) y por categoria.</span>
              <input  name="post_by_category" type="text" value="<?= rb_get_values_options('post_by_category') ?>" />
            </label>

            <label>URL terminos y condiciones:
              <span class="info">Esta se muestra en la seccion de registro de usuarios</span>
              <input  name="terms_url" type="text" value="<?= rb_get_values_options('terms_url') ?>" />
            </label>

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
            <label>Copia de seguridad DB:
              <a href="#" class="gen_backup_sql" download="Backup_database">Generar copia</a>
            </label>
            <script>
            //$(document).ready(function() {
              $('.gen_backup_sql').click(function(event){
                event.preventDefault();
                $.ajax({
        					type: 'GET',
        					url: '<?= G_SERVER ?>/rb-script/backup.php',
                  beforeSend: function(){
                    $('#img_loading, .bg-opacity').show();
                  }
        				})
        				.done( function (data){
                  $('#img_loading, .bg-opacity').hide();
        					console.log(data);
                  window.location.href = data.url_backup+data.filename;
        				});
              });
            //});
            </script>
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

            <span class="info">Mostrar link de terminos y condiciones en formulario de registro</span>
            <label class="lbl-listoptions">
              <input name="show_terms_register" type="radio" value="0" <?php if(rb_get_values_options('show_terms_register')==0) echo "checked=\"checked\""?> />
              No mostrar
            </label>
            <label class="lbl-listoptions">
              <input name="show_terms_register" type="radio" value="1" <?php if(rb_get_values_options('show_terms_register')==1) echo "checked=\"checked\""?> />
              Mostrar
            </label>

            <span class="info">Validar contraseña segura en formularios de registro de usuarios</span>
            <label class="lbl-listoptions">
              <input name="pass_security" type="radio" value="0" <?php if(rb_get_values_options('pass_security')==0) echo "checked=\"checked\""?> />
              Contraseñas no seguras
            </label>
            <label class="lbl-listoptions">
              <input name="pass_security" type="radio" value="1" <?php if(rb_get_values_options('pass_security')==1) echo "checked=\"checked\""?> />
              Contraseñas seguras
            </label>

            <label>Campos adicionales en formulario de registro:
              <span class="info">Se acepta formato JSON. Valor por defecto: {"nombres":"Nombres"}</span>
              <input name="more_fields_register" type="text" value='<?= rb_get_values_options('more_fields_register') ?>' />
            </label>
          </div>
          <div class="cols-6-md col-padding">
            <label>Permitir registrar nuevo usuario desde la página web</label>
            <span class="info">Puede incluir un link para registrarse en la página de inicio de sesión ó no.</span>
            <label class="lbl-listoptions">
              <input name="linkregister" type="radio" value="2" <?php if(rb_get_values_options('linkregister')=='2') echo "checked=\"checked\""?> />
              Permitir, pero ocultar link de registro en la página de Inicio de Sesión
            </label>
            <label class="lbl-listoptions">
              <input name="linkregister" type="radio" value="1" <?php if(rb_get_values_options('linkregister')=='1') echo "checked=\"checked\""?> />
              Permitir y mostrar link en la página de Inicio de Sesión
            </label>
            <label class="lbl-listoptions">
              <input name="linkregister" type="radio" value="0" <?php if(rb_get_values_options('linkregister')=='0') echo "checked=\"checked\""?> />
              No permitir, solo crear nuevos usuarios desde Panel Administrativo
            </label>
            <label>Usuarios admins que seran notificados de usuarios nuevos</label>
            <div class="cols-container">
              <div class="cols-6-md col-padding">
                <label>Lista de usuarios admin:</label>
                <?php
                $superadmins = json_decode(rb_get_values_options('user_superadmin'), true);
              	$array_admins_ids = explode(",", $superadmins['admin']);
                $qa = $objDataBase->Ejecutar("SELECT u.id, u.nombres, u.apellidos, un.nivel_enlace FROM usuarios_niveles un, usuarios u WHERE u.tipo = un.id AND un.nivel_enlace = 'admin'");
                while($ra = $qa->fetch_assoc()):
                  $checkbox = "";
                  if( in_array( $ra['id'] , $array_admins_ids) ){
                    $checkbox = " checked ";
                  }
                  ?>
                  <label><input type="checkbox" name="user_superadmin[]" value="<?= $ra['id'] ?>" <?= $checkbox ?> /> <?= $ra['nombres'] ?> <?= $ra['apellidos'] ?></label>
                  <?php
                endwhile;
                ?>
              </div>
            </div>
            <label>A donde dirigir al usuario final, luego de iniciar sesion:
              <input name="after_login_url" type="text" value='<?= rb_get_values_options('after_login_url') ?>' />
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
        <!-- fin maps -->
        <!-- config mensajes -->
        <div class="box-config">
          <h3 class="subtitle">Configuracion de mensajes internos</h3>
          <p>Puede establecer verificaciones previas entre niveles de usuarios.</p>
          <?php
          $message_config = json_decode(rb_get_values_options('message_config_restrict'), true);
          $array_senders_ids = explode(",", $message_config['send_users']);
          $array_receivers_ids = explode(",", $message_config['receive_users']);
          $array_admins_ids = explode(",", $message_config['admin_users']);
          $notify = $message_config['notify'];
          ?>
          <div class="cols-container">
            <label>Restricción</label>
            <div class="cols-6-md col-padding">
              <label>De:</label>
              <?php
              $q = $objDataBase->Ejecutar("SELECT * FROM usuarios_niveles WHERE nivel_enlace <> 'admin'");
              while($r = $q->fetch_assoc()):
                $checkbox = "";
                if( in_array( $r['id'] , $array_senders_ids) ){
                  $checkbox = " checked ";
                }
                ?>
                <label><input type="checkbox" name="user_send[]" value="<?= $r['id'] ?>" <?= $checkbox ?> /> <?= $r['nombre'] ?></label>
                <?php
              endwhile;
              ?>
            </div>
            <div class="cols-6-md col-padding">
              <label>A:</label>
              <?php
              $q = $objDataBase->Ejecutar("SELECT * FROM usuarios_niveles WHERE nivel_enlace <> 'admin'");
              while($r = $q->fetch_assoc()):
                $checkbox = "";
                if( in_array( $r['id'] , $array_receivers_ids) ){
                  $checkbox = " checked ";
                }
                ?>
                <label><input type="checkbox" name="user_receive[]" value="<?= $r['id'] ?>" <?= $checkbox ?> /> <?= $r['nombre'] ?></label>
                <?php
              endwhile;
              ?>
            </div>
          </div>
          <div class="cols-container">
            <label>Avisar / Aprobar</label>
            <div class="cols-6-md col-padding">
              <label>Lista de usuarios admin:</label>
              <?php
              $q = $objDataBase->Ejecutar("SELECT u.id, u.nombres, u.apellidos, un.nivel_enlace FROM usuarios_niveles un, usuarios u WHERE u.tipo = un.id AND un.nivel_enlace = 'admin'");
              while($r = $q->fetch_assoc()):
                $checkbox = "";
                if( in_array( $r['id'] , $array_admins_ids) ){
                  $checkbox = " checked ";
                }
                ?>
                <label><input type="checkbox" name="user_admin[]" value="<?= $r['id'] ?>" <?= $checkbox ?> /> <?= $r['nombres'] ?> <?= $r['apellidos'] ?></label>
                <?php
              endwhile;
              ?>
            </div>
            <div class="cols-6-md col-padding">
              <?php
              if( $notify == 1){
                $checkbox = " checked ";
              }
              ?>
              <label><input type="checkbox" name="sendcopy" <?= $checkbox ?>> Una vez aprobado, enviar notificacion al destinatario por correo electronico </label>
            </div>
          </div>
        </div>
      </div>
    <!--</div>-->
    </section>
  </div>
  <div id="sidebar"></div>
  <input name="section" value="opc" type="hidden" />
</form>
