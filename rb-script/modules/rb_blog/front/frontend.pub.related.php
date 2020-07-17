<aside class="wrap-sidebar">
  <section class="box box-sidebar <?= class_col_2 ?>">
    <h3>Publicaciones relacionadas</h3>
    <ul>
      <?php
      foreach ($Posts_related as $Post):
      ?>
        <li><a href="<?= $Post['url'] ?>"><?= $Post['titulo']  ?></a></li>
      <?php
      endforeach;
      ?>
    </ul>
  </section>
</aside>