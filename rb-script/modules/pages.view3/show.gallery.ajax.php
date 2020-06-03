<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';
require_once ABSPATH.'rb-script/class/rb-database.class.php';
require_once ABSPATH.'rb-script/funcs.php';

$gallery_id = $_GET['gallery_id'];
$redirect = $_GET['redirect'];
$gallery = rb_get_info_gallery($gallery_id);
$fotos = rb_get_images_from_gallery($gallery_id);
?>
<script>
$(document).ready(function() {
  $('.back_gallery').on('click',function(event) {
    event.preventDefault();
    $('.rb-cover-galleries').show();
    $('.rb-gallery-photos').hide();
  });
});
</script>
<h2><?= $gallery['nombre']?></h2>
<a href="#" class="back_gallery">Volver</a>
<?php
if($gallery['private']==1 && G_ACCESOUSUARIO==0){
  ?>
  <div class="rb_gallery_cover_private">
    <h3>El contenido es privado</h3>
    <p>
      <a href="<?= G_SERVER ?>/login.php?redirect=<?= G_SERVER ?><?= $redirect ?>">Inicia sesión para ver</a>
    </p>
  </div>
  <?php
}else{
  ?>
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
  <?php
}
?>
