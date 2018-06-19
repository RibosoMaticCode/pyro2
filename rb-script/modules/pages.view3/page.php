<?php
if($Page['show_header']==1) rb_header(['header-all.php']);
else rb_header();
?>
<div class="wrap-content">
<?php
$array_content = json_decode($Page['contenido'], true);
/*echo "<pre>"; // test
print_r($array_content);
echo "</pre>";*/

foreach ($array_content['boxes'] as $box) {
  //Bloque externo
  $ext_class = isset($box['boxext_class']) ? $box['boxext_class'] : "";
  $ext_parallax = isset($box['boxext_values']['extparallax']) ? $box['boxext_values']['extparallax'] : "";
  $style_extbgcolor = isset($box['boxext_values']['bgcolor']) ? "background-color:".$box['boxext_values']['bgcolor'].";" : "";
  $style_extbgimage = isset($box['boxext_values']['bgimage']) ? "background-image:url(".rb_BBCodeToGlobalVariable($box['boxext_values']['bgimage']).");background-position:center;background-size:cover;" : "";
  $style_extpaddingtop = isset($box['boxext_values']['paddingtop']) ? "padding-top:".$box['boxext_values']['paddingtop'].";" : "";
  $style_extpaddingright = isset($box['boxext_values']['paddingright']) ? "padding-right:".$box['boxext_values']['paddingright'].";" : "";
  $style_extpaddingbottom = isset($box['boxext_values']['paddingbottom']) ? "padding-bottom:".$box['boxext_values']['paddingbottom'].";" : "";
  $style_extpaddingleft = isset($box['boxext_values']['paddingleft']) ? "padding-left:".$box['boxext_values']['paddingleft'].";" : "";

  //Parallax
  if($ext_parallax==1){
    $ext_class .= " parallax-window";
    $addons = ' data-parallax="scroll" data-image-src="'.rb_BBCodeToGlobalVariable($box['boxext_values']['bgimage']).'" ';
    $styles_ext = $style_extbgcolor.$style_extpaddingtop.$style_extpaddingright.$style_extpaddingbottom.$style_extpaddingleft;
  //Estilos
  }elseif($ext_parallax==0){
    $styles_ext = $style_extbgcolor.$style_extbgimage.$style_extpaddingtop.$style_extpaddingright.$style_extpaddingbottom.$style_extpaddingleft;
    $addons = '';
  }

  echo '<div class="'.$ext_class.' clear" style="'.$styles_ext.'" '.$addons.'>';
  //BLoque interno
  if(isset($box['boxin_values']['width']) && $box['boxin_values']['width']=="yes"){
    $default_class = "full-content ";
    $style_inwidth = "";
  }elseif(isset($box['boxin_values']['width']) && $box['boxin_values']['width']!="yes" && $box['boxin_values']['width']!=""){
    $default_class = "inner-content";
    $style_inwidth = "width:".$box['boxin_values']['width'].";margin:0 auto;";
  }elseif(isset($box['boxin_values']['width']) && $box['boxin_values']['width']==""){
    $default_class = "inner-content ";
    $style_inwidth = "";
  }
  $in_class = isset($box['boxin_class']) ? $box['boxin_class'] : "";
  $style_inbgcolor = isset($box['boxin_values']['bgcolor']) ? "background-color:".$box['boxin_values']['bgcolor'].";" : "";
  $style_inbgimage = isset($box['boxin_values']['bgimage']) ? "background-image:url(".rb_BBCodeToGlobalVariable($box['boxin_values']['bgimage']).");background-position:center;background-size:cover;" : "";
  $style_inheight = isset($box['boxin_values']['height']) ? "height:".$box['boxin_values']['height'].";" : "";
  $style_inpaddingtop = isset($box['boxin_values']['paddingtop']) ? "padding-top:".$box['boxin_values']['paddingtop'].";" : "";
  $style_inpaddingright = isset($box['boxin_values']['paddingright']) ? "padding-right:".$box['boxin_values']['paddingright'].";" : "";
  $style_inpaddingbottom = isset($box['boxin_values']['paddingbottom']) ? "padding-bottom:".$box['boxin_values']['paddingbottom'].";" : "";
  $style_inpaddingleft = isset($box['boxin_values']['paddingleft']) ? "padding-left:".$box['boxin_values']['paddingleft'].";" : "";

  $styles_in = $style_inheight.$style_inbgcolor.$style_inbgimage.$style_inpaddingtop.$style_inpaddingright.$style_inpaddingbottom.$style_inpaddingleft.$style_inwidth;

  echo '<div class="'.$default_class.' '.$in_class.' clear" style="'.$styles_in.'">';
  echo '<div class="cols">';
  $array_cols =$box['columns'];
  foreach ($array_cols as $col):
    echo '<div class="col">';
    // Widgets
    $array_widgets =$col['widgets'];
    foreach ($array_widgets as $widget) {
      if(isset($widget['widget_save_id']) && $widget['widget_save_id']!="0"){
        $block_id = $widget['widget_save_id'];
        include 'widgets.customs.php'; //
      }else{
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
                  <div class="camera_caption"><?= rb_BBCodeToGlobalVariable($foto['title']) ?></div>
                <?php endif ?>
              </div>
              <?php
            }
            echo '</div>';
            break;
          case 'youtube1':
            $yt_list = explode(",", $widget['widget_values']['videos']);
            $count_yt_list = count($yt_list);
            $count_by_row = $widget['widget_values']['quantity'];
            ?>
            <div class="<?= $widget['widget_class'] ?> rb-youtube-grid">
              <?php
              $width = round(100 / $count_by_row, 2);
              $i=0;
              while($i<$count_yt_list):
                ?>
                <div style="width:<?= $width?>%">
                  <iframe width="100%" height="275" src="https://www.youtube.com/embed/<?= $yt_list[$i] ?>?modestbranding=0&autohide=1&showinfo=0" frameborder="0" allow="encrypted-media" allowfullscreen></iframe>
                </div>
                <?php
                $i++;
              endwhile;
              ?>
            </div>
            <?php
            break;
          case 'galleries':
            ?>
            <script>
            $(document).ready(function() {
              $('.rb-cover-galleries').on('click', '.back_gallery',function() {
                $('.rb-cover-galleries').show();
                $('.rb-gallery-photos').hide();
              });

              $('.gallery_show').click(function(event){
                event.preventDefault();
                var gallery_id = $(this).attr('data-galleryid');

                $.ajax({
                    method: "GET",
                    url: "<?= G_SERVER ?>/rb-script/modules/pages.view/show.gallery.ajax.php?gallery_id="+gallery_id,
                }).done(function( data ) {
                  $('.rb-cover-galleries').hide();
                  $('.rb-gallery-photos').html(data);
                  $('.rb-gallery-photos').show();
                });
              });
            });
            </script>
            <?php
            echo '<div class="rb-cover-galleries '.$widget['widget_class'].'">';
            $show_by_file = $widget['widget_values']['quantity'];
            $Galleries = rb_list_galleries();
            $CountGalleries = count($Galleries);
            $porcent_width = round(100/$show_by_file,2);
            $i=1;
            foreach ($Galleries as $Gallery) {
              if($i==1){
                echo '<div class="rb-gallery-container">';
              }
              echo '<div class="rb-gallery" style="width:'.$porcent_width.'%">';
              echo '<img src="'.$Gallery['url_bgimagetn'].'" alt="Portada Galeria" />';
              echo '<h2>'.$Gallery['nombre']."</h2>";
              echo '<a data-galleryid="'.$Gallery['id'].'" href="#" class="gallery_show">Ver galeria</a>';
              echo '</div>';
              if($i==$CountGalleries || $i==$show_by_file){
                echo '</div>';
                $i=1;
              }else{
                $i++;
              }
            }
            echo '</div>';
            ?>
            <div class="rb-gallery-photos">
            </div>
            <?php
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
      }
    }
    echo '</div>';// end col or coverwidgets
  endforeach; // end columns
  echo '</div>'; //end cols
  echo '</div>'; //end inner box
  echo '</div>'; //end outer box
}
?>
</div>
<?php
if($Page['show_footer']==1) rb_footer(['footer-all.php']);
else rb_footer();
?>
