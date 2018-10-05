<?php rb_header(['header-allpages.php'], false) ?>
<div class="wrap-content">
  <div class="inner-content clear block-content">
    <div class="wrap-posts-list <?= class_col_1 ?>">
      <div class="rb-gallery-photos">
        <h2><?= $gallery['nombre']?></h2>
        <a href="javascript:history.back()" class="back_gallery">Volver</a>
        <div class="cols-container">
        <?php
        foreach ($fotos as $foto) {
          ?>
          <div class="cols-3-md">
            <a href="<?= $foto['goto_url'] ?>" class="fancy <?= $foto['class'] ?>" data-fancybox-group="gallery">
              <img src="<?= $foto['url_min'] ?>" alt="imagen de galeria" />
            </a>
          </div>
          <?php
        }
        ?>
        </div>
      </div>
    </div>
    <?php rb_sidebar() ?>
  </div>
</div>
<?php rb_footer(['footer-allpages.php'], false) ?>
