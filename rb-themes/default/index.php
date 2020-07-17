<?php rb_header(['header-allpages.php'], false) ?>
<div class="wrap-content parallax-window" data-parallax="scroll" data-image-src="<?= rm_urltheme ?>img/intro.jpg">
  <div class="inner-content bg-intro-inner clear">
    <nav class="menu">
      <?= rb_BBCodeToGlobalVariable("[LOGUEO]") ?>
    </nav>
    <div class="wrap-titles">
      <h1 class="title-intro"><?= rm_titlesite ?></h1>
      <h2 class="subtitle-intro"><?= rm_subtitle ?></h2>
      <h3 class="subtitle-intro">Sito web en construcción</h3>
    </div>
  </div>
</div>

<?php rb_footer(['footer-allpages.php'], false) ?>
