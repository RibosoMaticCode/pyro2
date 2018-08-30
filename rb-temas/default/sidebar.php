<aside class="wrap-sidebar <?= class_col_2 ?>">
  <?php
  $SidebarId = rb_get_values_options('sidebar_id');
  if($SidebarId == 0):
  ?>
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
  </section>
  <?php
  else:
    $Sidebar = rb_show_specific_page($SidebarId);
    $array_content = json_decode($Sidebar['contenido'], true);
    foreach ($array_content['boxes'] as $box) {
      rb_show_block($box, "sidebar");
    }
  endif;
  ?>
</aside>
