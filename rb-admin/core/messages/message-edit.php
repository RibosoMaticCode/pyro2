<?php
include_once("tinymce/tinymce.config.php");
?>
<div class="inside_contenedor_frm">
<form id="edit-form" name="edit-form" method="post" action="core/messages/message-save.php">
  <div id="toolbar">
    <div class="inside_toolbar">
      <div class="navigation">
        <a href="<?= G_SERVER ?>rb-admin/?pag=men">Mensajeria</a> <i class="fas fa-angle-right"></i>
        <?php if(isset($row)): ?>
          <span><?= $row['nombre'] ?></span>
        <?php else: ?>
          <span>Nuevo mensaje</span>
        <?php endif ?>
      </div>
      <input class="btn-primary" name="guardar" type="submit" value="Enviar" />
      <a class="button" href="<?= G_SERVER ?>rb-admin/?pag=men">Cancelar</a>
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
              $q_user = $objDataBase->Ejecutar("SELECT tipo, id, nickname, nombres, apellidos FROM ".G_PREFIX."users WHERE id<>".G_USERID);
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
    <input name="remitente_id" value="<?= G_USERID ?>" type="hidden" />
</form>
</div>
