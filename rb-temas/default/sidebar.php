<aside class="wrap-sidebar <?= class_col_2 ?>">
  <!--
  <section class="box search clear">
    <form class="frmsearch" action="<?= G_SERVER ?>" method="get">
      <label>
        <input type="text" name="s" />
      </label>
      <button>Buscar</button>
    </form>
  </section>
  <section class="box box-sidebar">
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
  </section>-->
</aside>
