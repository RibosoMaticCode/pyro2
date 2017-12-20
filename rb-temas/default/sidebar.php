<aside class="wrap-sidebar <?= class_col_2 ?>">
  <section class="box-sidebar">
    <h3>Publicaciones</h3>
    <ul>
      <?php
      $Posts = rb_get_post_by_category('*', false, true);
      foreach ($Posts as $Post):
        ?>
        <li><a href="<?= $Post['url'] ?>"><?= $Post['titulo']  ?></a></li>
        <?php
      endforeach;
      ?>
    </ul>
  </section>
</aside>
