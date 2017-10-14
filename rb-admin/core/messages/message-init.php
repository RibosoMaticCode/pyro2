<?php if (!in_array("men", $array_help_close)): ?>
  <div class="help" data-name="men">
    <h4>Información</h4>
    <p>Puede enviar y recibir notificaciones de otros usuario del sistema. Funciona similar a una bandeja de correo electrónico, muy básica</p>
  </div>
  <?php endif ?>
  <div id="sidebar-left">
          <ul class="buttons-edition">
    <li><a class="btn-primary" <?= $style_btn_default ?>href="<?= G_SERVER ?>/rb-admin/?pag=men">Recibidos</a></li>
          <li><a class="btn-primary" <?= $style_btn_1 ?>href="<?= G_SERVER ?>/rb-admin/?pag=men&opc=send">Enviados</a></li>
    <li><a class="btn-primary" href="<?= G_SERVER ?>/rb-admin/?pag=men&amp;opc=nvo"><img src="img/add-white-16.png" alt="Nuevo" /> Nuevo</a></li>
          </ul>
  </div>
  <div class="wrap-content-list">
    <section class="seccion">
        <div id="content-list">
              <div id="resultado">
              <table id="t-enlaces" class="tables" border="0" cellpadding="0" cellspacing="0">
              <thead>
                <tr>
                  <th><h3>Asunto</h3></th>
                  <?php if(isset($_GET['opc']) && $_GET['opc'] =="send"){ ?> <th><h3>Destinatarios</h3></th>
                  <?php }else{ ?> <th><h3>Remitente</h3></th><?php } ?>

                  <th><h3>Fecha</h3></th>
                  <th><h3>Acciones</h3></th>
                </tr>
              </thead>
              <tbody>
              <?php
                  include('message-list.php');
              ?>
              </tbody>
              </table>
              </div>
    </div>
    </section>
  </div>
