<?php rb_header(['header-allpages.php'], false) ?>
<div class="wrap-content">
  <div class="inner-content clear block-content">
    <h1>Ultimas publicaciones</h1>
    <div class="wrap-posts-list <?= class_col_1 ?>">
      <?php
      $Posts = rb_get_post_by_category('*');
      foreach ($Posts as $Post):
        ?>
        <article>
          <div class="info">
            <span class="date"><?= $Post['fec_dia']  ?> de <?= $Post['fec_mes_l']  ?>, <?= $Post['fec_anio']  ?></span>
          </div>
          <h2><a href="<?= $Post['url'] ?>"><?= $Post['titulo']  ?></a></h2>
          <div class="post-image" style="background-image:url('<?= $Post['url_img_pri_max']  ?>')"></div>
          <?= $Post['contenido'] ?>
          <a href="<?= $Post['url'] ?>">Leer mas</a>
        </article>
        <?php
      endforeach;
      ?>
    </div>
    <?php rb_sidebar() ?>
  </div>
</div>
<?php rb_footer(['footer-allpages.php'], false) ?>
