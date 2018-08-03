<div class="wrap-content parallax-window" data-parallax="scroll" data-image-src="<?= rm_urltheme ?>img/intro.jpg">
  <div class="inner-content bg-intro-inner clear">
    <nav class="menu">
      <ul>
        <?php if(G_ACCESOUSUARIO): ?>
        <li>
          <a href="<?= G_SERVER ?>/?pa=panel">Panel de Usuario</a>
        </li>
        <?php else: ?>
        <li>
          <a href="<?= G_SERVER ?>/login.php">Ingresar</a>
        </li>
        <?php endif ?>
      </ul>
    </nav>
    <div class="wrap-titles">
      <h1 class="title-intro"><?= rm_titlesite ?></h1>
      <h3 class="subtitle-intro"><?= rm_subtitle ?></h3>
    </div>
  </div>
</div>
