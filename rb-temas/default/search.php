<?php rb_header(['header-allpages.php'], false) ?>
<div class="wrap-content">
  <div class="inner-content clear block-content">
    <h1><?= $CountPosts ?> resultados encontrados</h1>
    <div class="wrap-posts-list <?= class_col_1 ?>">
      <?php
      while ($rows = $qs->fetch_assoc()):
        ?>
        <article>
          <div class="info">
            <span class="date"><?= $rows['fecha_creacion']  ?></span>
          </div>
          <h2><a href="<?= rb_url_link( 'art' , $rows['id'] ); ?>"><?= $rows['titulo']  ?></a></h2>
          <?= rb_fragment_text($rows['contenido'], 30) ?>
        </article>
        <?php
      endwhile;
      ?>
    </div>
    <?php rb_sidebar() ?>
  </div>
</div>
<?php rb_footer(['footer-allpages.php'], false) ?>
