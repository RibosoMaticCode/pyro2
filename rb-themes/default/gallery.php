<?php rb_header(['header-allpages.php'], false) ?>
<div class="wrap-content">
  <div class="inner-content clear block-content">
    <div class="wrap-posts-list <?= class_col_1 ?>">
      <div class="rb-gallery-photos">
        <h2><?= $gallery['nombre']?></h2>
        <a href="javascript:history.back()" class="back_gallery">Volver</a>
        <div class="cols-container">
        <?php
        if($gallery['private']==1 && G_ACCESOUSUARIO==0){
          ?>
          <div>
            <h3>El contenido es privado</h3>
            <p>
              <a href="<?= G_SERVER ?>login.php?redirect=<?= G_SERVER ?><?= $_SERVER['REQUEST_URI'] ?>">Inicia sesión para ver</a>
            </p>
          </div>
          <?php
        }else{
          foreach ($fotos as $foto) {
            ?>
            <div class="cols-3-md">
              <a href="<?= $foto['goto_url'] ?>" class="fancy <?= $foto['class'] ?>" data-fancybox-group="gallery">
                <img src="<?= $foto['url_min'] ?>" alt="imagen de galeria" />
              </a>
            </div>
            <?php
          }
        }
        ?>
        </div>
      </div>
    </div>
    <?php rb_sidebar() ?>
  </div>
</div>
<?php rb_footer(['footer-allpages.php'], false) ?>
