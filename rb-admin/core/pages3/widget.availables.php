<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';
require_once ABSPATH.'rb-script/class/rb-database.class.php';
require_once ABSPATH.'rb-script/funciones.php';

/* INCLUDE WIDGETS DISPONIBLES */
$widgets=[];
include_once ABSPATH.'rb-admin/core/pages3/widgets/slide/w.slide.init.php';
include_once ABSPATH.'rb-admin/core/pages3/widgets/code/w.code.init.php';
include_once ABSPATH.'rb-admin/core/pages3/widgets/editor/w.editor.init.php';
include_once ABSPATH.'rb-admin/core/pages3/widgets/gallery/w.gallery.init.php';
include_once ABSPATH.'rb-admin/core/pages3/widgets/pubs/w.pubs.init.php';
include_once ABSPATH.'rb-admin/core/pages3/widgets/youtube/w.youtube.init.php';
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
		<?php
		foreach ($widgets as $widget => $data) {
			?>
			<li>
	      <a class="<?= $data['link_action'] ?>" href="#"><?= $data['name'] ?></a>
	    </li>
			<?php
		}
    $q = $objDataBase->Ejecutar("SELECT * FROM bloques WHERE tipo=0");
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
