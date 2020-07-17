<?php rb_header(['header-allpages.php'], false) ?>
<div class="wrap-content">
  <div class="inner-content clear block-content">
    <div class="wrap-posts-list <?= class_col_1 ?>">
      <article>
        <div class="info">
          <span class="date"><?= $Post['fec_dia']  ?> de <?= $Post['fec_mes_l']  ?>, <?= $Post['fec_anio']  ?></span>
          <a class="back" href="javascript:history.back()" class="back_gallery">Volver</a>
        </div>
        <h2><a href="<?= $Post['url'] ?>"><?= $Post['titulo']  ?></a></h2>
        <?php if($Post['url_img_pri_max']!=""): ?>
        <div class="post-image" style="background-image:url('<?= $Post['url_img_pri_max']  ?>')"></div>
        <?php endif ?>
        <?= rb_shortcode(rb_BBCodeToGlobalVariable($Post['contenido'])) ?>
      </article>
    </div>
    <?php rb_sidebar() ?>
  </div>
</div>
<?php rb_footer(['footer-allpages.php'], false) ?>
