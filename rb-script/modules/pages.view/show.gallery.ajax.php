<script>
$(document).ready(function() {
  $('.back_gallery').on('click',function() {
    $('.rb-cover-galleries').show();
    $('.rb-gallery-photos').hide();
  });
});
</script>
<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';
require_once ABSPATH.'rb-script/class/rb-database.class.php';
require_once ABSPATH.'rb-script/funciones.php';

$gallery_id = $_GET['gallery_id'];
$gallery = rb_get_info_gallery($gallery_id);
$fotos = rb_get_images_from_gallery($gallery_id);
?>
<h2><?= $gallery['nombre']?></h2>
<a href="#" class="back_gallery">Volver</a>
<div class="cols-container">
<?php
foreach ($fotos as $foto) {
  ?>
  <div class="cols-3-md">
    <a href="<?= $foto['url_max'] ?>" class="fancy" data-fancybox-group="gallery">
      <img src="<?= $foto['url_min'] ?>" alt="imagen de galeria" />
    </a>
  </div>
  <?php
}
?>
</div>
