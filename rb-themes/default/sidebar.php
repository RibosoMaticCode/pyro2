<aside class="wrap-sidebar <?= class_col_2 ?>">
  <?php
  $SidebarId = rb_get_values_options('sidebar_id');
  if($SidebarId == 0):
  ?>
  <section class="box search clear">
    <form class="form" action="<?= G_SERVER ?>" method="get">
      <div class="cols-container">
        <div class="cols-8-md">
          <input type="text" name="s" />
        </div>
        <div class="cols-4-md">
          <button>Buscar</button>
        </div>
      </div>
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