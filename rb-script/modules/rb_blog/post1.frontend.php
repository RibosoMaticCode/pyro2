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
$show_img = isset($widget['widget_values']['show_img']) ? $widget['widget_values']['show_img']: 0;
$show_cat = isset($widget['widget_values']['show_cat']) ? $widget['widget_values']['show_cat']: 0;
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
        <?php if($show_img==1): ?>
        <div class="post-img" style="background-image:url('<?= $PostRelated['url_img_pri_max']  ?>')"></div>
        <?php endif ?>
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
          <?php if($show_cat==1): ?>
            <ul class="post-categories">
              <?php
              $categorias = rb_show_category_from_post($PostRelated['id']);
              foreach ($categorias as $categoria) {
                ?>
                <li><a href="<?= $categoria['url'] ?>"><?= $categoria['nombre'] ?></a></li>
                <?php
              }
              ?>
            </ul>
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
