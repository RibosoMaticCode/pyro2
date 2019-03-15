<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';
require_once ABSPATH.'rb-script/class/rb-database.class.php';
require_once ABSPATH.'rb-script/funciones.php';

$id = $block_id;
$qb = $objDataBase->Ejecutar("SELECT * FROM bloques WHERE id=$id");
$row= $qb->fetch_assoc();
$widget = json_decode($row['contenido'], true);

switch ($widget['widget_type']) {
  case 'html':
    echo '<div class="'.$widget['widget_class'].'">';
    echo rb_shortcode(rb_BBCodeToGlobalVariable(html_entity_decode($widget['widget_content'])));
    echo '</div>';
    break;
  case 'htmlraw':
    echo '<div class="'.$widget['widget_class'].'">';
    echo rb_shortcode(rb_BBCodeToGlobalVariable(html_entity_decode($widget['widget_content'])));
    echo '</div>';
    break;
  case 'slide':
    echo '<div class="'.$widget['widget_class'].'">';
    $gallery_id = $widget['widget_values']['gallery_id'];
    $fotos = rb_get_images_from_gallery($gallery_id);
    foreach ($fotos as $foto) {
      ?>
      <div data-src="<?= $foto['url_max'] ?>" data-thumb="<?= $foto['url_min'] ?>">
        <?php if($widget['widget_values']['show_title']==1): ?>
          <div class="camera_caption"><?= $foto['title'] ?></div>
        <?php endif ?>
      </div>
      <?php
    }
    echo '</div>';
    break;
	case 'galleries':
		echo '<div class="'.$widget['widget_class'].'">';
		$show_by_file = $widget['widget_values']['quantity'];
		$Galleries = rb_list_galleries();
		echo 'Galerias';
		foreach ($Galleries as $Gallery) {
			echo $Gallery['nombre']."<br />";
		}
		echo '</div>';
		break;
  case 'post1':
    echo '<div class="'.$widget['widget_class'].'">';
    /*?>
    <div class="cols">
    <?php*/
    // Destripar configuracion
    $category_id = $widget['widget_values']['cat'];
    $num_posts = $widget['widget_values']['count'];
    $ord = $widget['widget_values']['ord'];
    $tit = $widget['widget_values']['tit'];
    $typ = $widget['widget_values']['typ'];

    if($tit!=""){
      ?>
      <h2><?= $tit ?></h2>
      <?php
    }
    if($typ==0 || $typ==1){
      ?>
      <div class="post-<?= $typ ?>">
      <?php
      $Posts = rb_get_post_by_category($category_id, false, true, $num_posts, 0, "fecha_creacion", $ord);
      foreach ($Posts as $PostRelated) {
        ?>
        <div>
          <img src="<?= $PostRelated['url_img_por_min']  ?>" alt="img" />
          <h3><a href="<?= $PostRelated['url']  ?>"><?= $PostRelated['titulo']  ?></a></h3>
          <!--<a href="<?= $PostRelated['url'] ?>">Leer mas</a>-->
        </div>
        <?php
      }
      ?>
      </div>
      <?php
    }
    if($typ==2 || $typ==3){
      ?>
      <div class="post-<?= $typ ?>">
      <?php
      $i=1;
      $Posts = rb_get_post_by_category($category_id, false, true, $num_posts, 0, "fecha_creacion", $ord);
      foreach ($Posts as $PostRelated) {
        if($i==1){
          ?>
          <div class="left">
            <div class="image" style="background-image:url(<?= $PostRelated['url_img_por_min']  ?>)">
            </div>
            <h2><a href="<?= $PostRelated['url']  ?>"><?= $PostRelated['titulo']  ?></a></h2>
            <!--<a href="<?= $PostRelated['url'] ?>">Leer mas</a>-->
          </div>
          <?php
        }else{
          ?>
          <div class="right">
            <div class="image" style="background-image:url(<?= $PostRelated['url_img_por_min']  ?>)">
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
    /*?>
    </div>
    <?php*/
    echo '</div>';
    break;
}
?>
