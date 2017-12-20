<?php include_once 'header.php' ?>
<div class="wrap-content">
  <div class="inner-content clear">
    <div class="">
      <ul class="posts-list">
        <?php
        $Posts = rb_get_post_by_category('articulos', false, true);
        foreach ($Posts as $PostRelated) {
          ?>
          <li>
          <h3><?= $PostRelated['titulo']  ?></h3>
          <img src="<?= $PostRelated['url_img_pri_min']  ?>" alt="img" /> <?= rb_fragment_text($PostRelated['contenido'], 12, false) ?>
          <a href="<?= $PostRelated['url'] ?>">Leer mas</a>
          </li>
          <?php
        }
        ?>
      </ul>
    </div>
  </div>
</div>
<?php include_once 'footer.php' ?>
