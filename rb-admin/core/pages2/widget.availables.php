<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';
require_once ABSPATH.'rb-script/class/rb-database.class.php';
require_once ABSPATH.'rb-script/funciones.php';
?>
<div id="editor-widget" class="editor-window">
  <script>
  $(function() {
    // Aceptar cambios
    $('#widget-btn-accept').click(function() {
      $('.bg-opacity, #editor-widget').hide();
      $('#editor-widget').remove();
    });
    // Cancelar
    $('#widget-btn-cancel').click(function() {
      $('.bg-opacity, #editor-widget').hide();
      $('#editor-widget').remove();
    });
  });
  </script>
	<div class="editor-header">
		<strong>Seleccione widget a agregar</strong>
	</div>
	<div class="editor-body">
  <ul class="_box-options-list">
    <li>
      <a class="addSlide" href="#">Slide</a>
    </li>
    <li>
      <a class="addHtml" href="#">HTML - Editor</a>
    </li>
    <li>
      <a class="addHtmlRaw" href="#">HTML - Código</a>
    </li>
    <li>
      <a class="addPost1" href="#">Publicaciones</a>
    </li>
    <?php
    $q = $objDataBase->Ejecutar("SELECT * FROM bloques");
    while($r = $q->fetch_assoc()):
    ?>
    <li>
      <a class="addCustom" href="#" data-id="<?= $r['id'] ?>"><?= $r['nombre'] ?></a>
    </li>
    <?php
    endwhile;
    ?>
  </ul>
	</div>
	<div class="editor-footer">
		<button class="btn-primary" id="widget-btn-accept">Cambiar</button>
		<button class="button" id="widget-btn-cancel">Cancelar</button>
	</div>
</div>
