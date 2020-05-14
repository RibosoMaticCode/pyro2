<?php
// xxxxxxx.fron.php
// where xxxxxxx es nombre del tipo de widget

echo '<div class="'.$widget['widget_class'].'">';
// Destripar configuracion
$category_id = $widget['widget_values']['cat'];
$num_posts = $widget['widget_values']['count'];
$ord = $widget['widget_values']['ord'];
$tit = $widget['widget_values']['tit'];
$typ = $widget['widget_values']['typ'];
$desc = $widget['widget_values']['desc'];
$link = $widget['widget_values']['link'];
$byrow = $widget['widget_values']['byrow'];
$width_post = 100;
if($typ==0){
  $width_post = round(100/$byrow,2);
}

if($tit!=""){
  ?>
  <h2><?= $tit ?></h2>
  <?php
}
// Horizontal y vertical
if($typ==0 || $typ==1){
  ?>
  <div class="post-<?= $typ ?>">
  <?php
  if($category_id==0) $category_id="*";
  $Posts = rb_get_post_by_category($category_id, $num_posts, 0, "fecha_creacion", $ord);
  $i=1;
  $j=1;
  foreach ($Posts as $PostRelated) {
    if($i==1){
      ?>
      <div class="post-wrap clear">
      <?php
    }
    ?>
    <div class="post-list clear" style="width:<?= $width_post?>%">
      <div class="post">
        <div class="post-img" style="background-image:url('<?= $PostRelated['url_img_pri_max']  ?>')"></div>
        <!--<span class="post-category"></span>-->
        <div class="post-desc <?php if($typ==1) print "clear" ?>">
        <h2><a title="<?= $PostRelated['titulo'] ?>" href="<?= $PostRelated['url'] ?>"><?= $PostRelated['titulo'] ?></a></h2>
        <?php if($desc==1): ?>
          <?= rb_fragment_text($PostRelated['contenido'],30, false)  ?>
        <?php endif ?>
        <?php if($link==1): ?>
          <br />
          <a class="post-more" href="<?= $PostRelated['url'] ?>">Leer mas</a>
        <?php endif ?>
        </div>
      </div>
    </div>
    <?php
    if($j==$num_posts || $i==$byrow){
      ?>
      </div>
      <?php
      $i=1;
    }else{
      $i++;
    }
    $j++;
    ?>
    <?php
  }
  ?>
  </div>
  <?php
}

// Destacado  derecha e izquierda
if($typ==2 || $typ==3){
  ?>
  <div class="clear post-<?= $typ ?>">
  <?php
  $i=1;
  if($category_id==0) $category_id="*";
  $Posts = rb_get_post_by_category($category_id, $num_posts, 0, "fecha_creacion", $ord);
  foreach ($Posts as $PostRelated) {
    if($i==1){
      ?>
      <div class="left">
        <div class="image" style="background-image:url(<?= $PostRelated['url_img_pri_max']  ?>)">
        </div>
        <h2><a href="<?= $PostRelated['url']  ?>"><?= $PostRelated['titulo']  ?></a></h2>
        <!--<a href="<?= $PostRelated['url'] ?>">Leer mas</a>-->
      </div>
      <?php
    }else{
      ?>
      <div class="right">
        <div class="image" style="background-image:url(<?= $PostRelated['url_img_pri_max']  ?>)">
        </div>
        <h3><a href="<?= $PostRelated['url']  ?>"><?= $PostRelated['titulo']  ?></a></h3>
        <!--<a href="<?= $PostRelated['url'] ?>">Leer mas</a>-->
      </div>
      <?php
    }
    $i++;
  }
  ?>
  </div>
  <?php
}
echo '</div>';
