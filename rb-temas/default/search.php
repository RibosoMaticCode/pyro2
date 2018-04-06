<?php rb_header(['header-all.php']) ?>
<div class="wrap-content">
  <div class="inner-content clear block-content">
    <h1><?= $CountPosts ?> resultados encontrados</h1>
    <div class="wrap-posts-list <?= class_col_1 ?>">
      <?php
      //$Posts = rb_get_post_by_category('*', false, true);
      while ($rows = $qs->fetch_assoc()):
      //foreach ($Posts as $Post):
        ?>
        <article>
          <div class="info">
            <span class="date"><?= $rows['fecha_creacion']  ?></span>
          </div>
          <h2><a href="#"><?= $rows['titulo']  ?></a></h2>
          <img class="image-star" src="#" alt="img" />
          <?= $rows['contenido'] ?>
        </article>
        <?php
      //endforeach;
      endwhile;
      ?>
    </div>
    <?php rb_sidebar() ?>
  </div>
</div>
<?php rb_footer(['footer-all.php']) ?>
