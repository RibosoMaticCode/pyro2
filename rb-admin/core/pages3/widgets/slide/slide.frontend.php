<?php
echo '<div class="clear '.$widget['widget_class'].'">';
$gallery_id = $widget['widget_values']['gallery_id'];
$typegallery = $widget['widget_values']['type'];
$quantity = $widget['widget_values']['quantity'];
$limit = $widget['widget_values']['limit'];
$activelink = $widget['widget_values']['activelink'];
$fotos = rb_get_images_from_gallery($gallery_id, $limit);
if( !$fotos ){
  print 'No hay galeria seleccionada';
}else{
  foreach ($fotos as $foto) {
    if($typegallery==2){ // slide
      ?>
      <div data-src="<?= $foto['url_max'] ?>" data-thumb="<?= $foto['url_min'] ?>" <?php if($widget['widget_values']['activelink']==1): ?> data-link="<?= $foto['goto_url'] ?>" <?php endif ?>>
        <?php if($widget['widget_values']['show_title']==1): ?>
          <div class="camera_caption"><?= $foto['title'] ?></div>
        <?php endif ?>
      </div>
      <?php
    }
    if($typegallery==1){ // simple galeria
      if($quantity>0){
        $width = 100/$quantity;
      }else{
        $width = 100/4; // default
      }
      $style = 'style="width:'.$width.'%"';
      ?>
      <div class="rb-cover-img" <?= $style ?>>
        <?php if($widget['widget_values']['activelink']==1): ?>
          <a class="rb-img-link fancy <?= $foto['class'] ?>" href="<?= $foto['goto_url'] ?>">
        <?php else: ?>
          <a class="rb-img-link fancy" data-fancybox-group="gallery<?= $gallery_id?>" href="<?= $foto['goto_url'] ?>">
        <?php endif ?>
          <div class="rb-img" style="background-image:url('<?= $foto['url_max'] ?>')"></div>
          </a>
          <div class="shadow"></div>
          <?php if($widget['widget_values']['show_title']==1): ?>
            <div class="rb-img-desc">
            <?= $foto['title'] ?>
            </div>
          <?php endif ?>          
      </div>
      <?php
    }
  }
}
echo '</div>';
?>
