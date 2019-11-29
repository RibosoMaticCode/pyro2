<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';
require_once ABSPATH.'rb-script/class/rb-database.class.php';
require_once ABSPATH.'rb-script/funcs.php';
require_once ABSPATH.'rb-script/hook.php';
// Carga formato js de la base de datos
$modules_prev = rb_get_values_options('modules_load');

// Convierte json a array
$array_modules = json_decode($modules_prev, true);

// Incluir los modulos externos desde la base de datos
require_once ABSPATH.'rb-script/modules.list.php';

/* INCLUDE WIDGETS DISPONIBLES */

include_once ABSPATH.'rb-admin/core/pages3/widgets/editor/w.editor.init.php';
include_once ABSPATH.'rb-admin/core/pages3/widgets/slide/w.slide.init.php';
include_once ABSPATH.'rb-admin/core/pages3/widgets/gallery/w.gallery.init.php';
include_once ABSPATH.'rb-admin/core/pages3/widgets/code/w.code.init.php';
include_once ABSPATH.'rb-admin/core/pages3/widgets/youtube/w.youtube.init.php';
include_once ABSPATH.'rb-admin/core/pages3/widgets/sidebar/w.sidebar.init.php';
include_once ABSPATH.'rb-admin/core/pages3/widgets/image/w.image.init.php';

//print_r($widgets);
?>
<div id="editor-widget" class="editor-window">
  <script>
  $(function() {
    // Cerrar
    $('#widget-btn-accept').click(function() {
      $('.bg-opacity, #editor-widget').hide();
      $('#editor-widget').remove();
    });
    // Cancelar
    /*$('#widget-btn-cancel').click(function() {
      $('.bg-opacity, #editor-widget').hide();
      $('#editor-widget').remove();
    });*/
  });
  </script>
	<div class="editor-header">
		<strong>Seleccione componente a agregar</strong>
	</div>
	<div class="editor-body">
  <ul class="_box-options-list">
		<?php
		foreach ($widgets as $widget => $data) {
			if(isset($data['img_abs'])){
				$url_img = $data['img_abs'];
			}else{
				$url_img = G_SERVER.'rb-admin/core/pages3/widgets/'.$data['dir'].'/'.$data['img'];
			}
			?>
			<li>
	      <a class="<?= $data['link_action'] ?>" href="#">
					<img src="<?= $url_img ?>" alt="icon" />
					<h4><?= $data['name'] ?></h4>
					<?= $data['desc'] ?>
				</a>
	    </li>
			<?php
		}
    $q = $objDataBase->Ejecutar("SELECT * FROM ".G_PREFIX."pages_blocks WHERE tipo=0");
    while($r = $q->fetch_assoc()):
    ?>
    <li>
      <a class="addCustom" href="#" data-id="<?= $r['id'] ?>">
				<img src="<?= G_SERVER ?>rb-admin/core/pages3/save.png" alt="icon" />
				<h4><?= $r['nombre'] ?></h4>
				Elemento personalizado
			</a>
    </li>
    <?php
    endwhile;
    ?>
  </ul>
	</div>
	<div class="editor-footer">
		<button class="button" id="widget-btn-accept">Cerrar</button>
		<!--<button class="button" id="widget-btn-cancel">Cancelar</button>-->
	</div>
</div>
