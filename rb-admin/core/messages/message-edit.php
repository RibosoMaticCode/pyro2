<?php
include_once("tinymce/tinymce.config.php");
?>
<form id="edit-form" name="edit-form" method="post" action="core/messages/message-save.php">
  <div id="toolbar">
    <div id="toolbar-buttons">
      <span class="post-submit">
        <input class="submit" name="guardar" type="submit" value="Enviar" />
        <a href="../rb-admin/?pag=men"><input title="Volver al listado" class="button" name="cancelar" type="button" value="Cancelar" /></a>
      </span>
    </div>
  </div>
  <div class="content-edit">
    <section class="seccion">
      <div class="seccion-body">
        <div class="wrap-input form">
          <label title="Asunto del mensaje" for="web_nombre">Asunto:
            <input  name="asunto" type="text" id="asunto" required />
          </label>
        </div>
        <div class="wrap-input">
          <label title="Escribe tu mensaje" for="mensaje">Mensaje:
            <textarea class=" mceEditor" name="contenido" id="contenido"></textarea>
          </label>
        </div>
      </div>
    </section>
  </div>
  <div id="sidebar">
    <section class="seccion">
      <div class="seccion-body">
        <div class="edit-list form">
          <label title="Webmaster" for="webmaster">Destinatarios:</label>
            <div id="catlist">
              <?php
              $q_user = $objDataBase->Ejecutar("SELECT tipo, id, nickname, nombres, apellidos FROM usuarios WHERE id<>".G_USERID);
              while($r_user = $q_user->fetch_assoc()){
                ?>
                <label class="label_checkbox">
                  <input type="hidden" value="<?= $r_user['tipo'] ?>" name="users_nivel_id[<?= $r_user['id'] ?>]" />
                  <input type="checkbox" value="<?= $r_user['id'] ?>" name="users[]" /> <?= $r_user['nombres']." ".$r_user['apellidos'] ?> [<?= rb_shownivelname($r_user['tipo']) ?>]
                </label>
                <?php
              }
              ?>
            </div>
          </div>
        </div>
      </section>
    </div>
    <input name="section" value="men" type="hidden" />
    <input name="mode" value="new" type="hidden" />
    <!--<input name="id" value="<?php if(isset($row)) echo $row['id'] ?>" type="hidden" />-->
    <input name="remitente_id" value="<?= G_USERID ?>" type="hidden" />
</form>
