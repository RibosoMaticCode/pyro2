<?php
if($Page['show_header']==1) rb_header(['header-all.php']);
else rb_header();
?>
<div class="wrap-content">
<?php
$array_content = json_decode($Page['contenido'], true);
foreach ($array_content['boxes'] as $box) {
  //Bloque externo
  $ext_class = $box['boxext_class']!="" ? $box['boxext_class'] : "";
  $ext_parallax = $box['boxext_parallax']!="" ? $box['boxext_parallax'] : "";
  $style_extbgcolor = $box['boxext_bgcolor']!="" ? "background-color:".$box['boxext_bgcolor'].";" : "";
  $style_extbgimage = $box['boxext_bgimage']!="" ? "background-image:url(".rb_BBCodeToGlobalVariable($box['boxext_bgimage']).");background-position:center;background-size:cover;" : "";
  $style_extpaddingtop = $box['boxext_paddingtop']!="" ? "padding-top:".$box['boxext_paddingtop'].";" : "";
  $style_extpaddingright = $box['boxext_paddingright']!="" ? "padding-right:".$box['boxext_paddingright'].";" : "";
  $style_extpaddingbottom = $box['boxext_paddingbottom']!="" ? "padding-bottom:".$box['boxext_paddingbottom'].";" : "";
  $style_extpaddingleft = $box['boxext_paddingleft']!="" ? "padding-left:".$box['boxext_paddingleft'].";" : "";

  //Parallax
  if($ext_parallax==1){
    $ext_class .= " parallax-window";
    $addons = ' data-parallax="scroll" data-image-src="'.rb_BBCodeToGlobalVariable($box['boxext_bgimage']).'" ';
    $styles_ext = $style_extbgcolor.$style_extpaddingtop.$style_extpaddingright.$style_extpaddingbottom.$style_extpaddingleft;
  //Estilos
  }elseif($ext_parallax==0){
    $styles_ext = $style_extbgcolor.$style_extbgimage.$style_extpaddingtop.$style_extpaddingright.$style_extpaddingbottom.$style_extpaddingleft;
    $addons = '';
  }

  echo '<div class="'.$ext_class.' clear" style="'.$styles_ext.'" '.$addons.'>';
  //BLoque interno
  if($box['boxin_width']=="yes"){
    $default_class = "full-content ";
    $style_inwidth = "";
  }elseif($box['boxin_width']!="yes" && $box['boxin_width']!=""){
    $default_class = "inner-content";
    $style_inwidth = "width:".$box['boxin_width'].";margin:0 auto;";
  }elseif($box['boxin_width']==""){
    $default_class = "inner-content ";
    $style_inwidth = "";
  }
  $in_class = $box['boxin_class']!="" ? $box['boxin_class'] : "";
  $style_inbgcolor = $box['boxin_bgcolor']!="" ? "background-color:".$box['boxin_bgcolor'].";" : "";
  $style_inbgimage = $box['boxin_bgimage']!="" ? "background-image:url(".rb_BBCodeToGlobalVariable($box['boxin_bgimage']).");background-position:center;background-size:cover;" : "";
  $style_inheight = $box['boxin_height']!="" ? "height:".$box['boxin_height'].";" : "";
  $style_inpaddingtop = $box['boxin_paddingtop']!="" ? "padding-top:".$box['boxin_paddingtop'].";" : "";
  $style_inpaddingright = $box['boxin_paddingright']!="" ? "padding-right:".$box['boxin_paddingright'].";" : "";
  $style_inpaddingbottom = $box['boxin_paddingbottom']!="" ? "padding-bottom:".$box['boxin_paddingbottom'].";" : "";
  $style_inpaddingleft = $box['boxin_paddingleft']!="" ? "padding-left:".$box['boxin_paddingleft'].";" : "";

  $styles_in = $style_inheight.$style_inbgcolor.$style_inbgimage.$style_inpaddingtop.$style_inpaddingright.$style_inpaddingbottom.$style_inpaddingleft.$style_inwidth;

  echo '<div class="'.$default_class.' '.$in_class.' clear" style="'.$styles_in.'">';
  echo '<div class="cols">';
  $array_cols =$box['columns'];
  foreach ($array_cols as $col) {
    if(isset($col['col_save_id']) && $col['col_save_id']!="0"){
      $block_id = $col['col_save_id'];
      include 'page.blocks.php'; //
    }else{
      switch ($col['col_type']) {
        case 'html':
          echo '<div class="'.$col['col_css'].'">';
          echo rb_BBCodeToGlobalVariable(html_entity_decode($col['col_content']));
          echo '</div>';
          break;
        case 'htmlraw':
          echo '<div class="'.$col['col_css'].'">';
          echo rb_BBCodeToGlobalVariable(html_entity_decode($col['col_content']));
          echo '</div>';
          break;
        case 'slide':
          echo '<div class="'.$col['col_css'].'">';
          $gallery_id = $col['col_values']['gallery_id'];
          $fotos = rb_get_images_from_gallery($gallery_id);
          foreach ($fotos as $foto) {
            ?>
            <div data-src="<?= $foto['url_max'] ?>" data-thumb="<?= $foto['url_min'] ?>">
              <?php if($col['col_values']['show_title']==1): ?>
                <div class="camera_caption"><?= rb_BBCodeToGlobalVariable($foto['title']) ?></div>
              <?php endif ?>
            </div>
            <?php
          }
          echo '</div>';
          break;
        case 'youtube1':
          $yt_list = explode(",", $col['col_values']['videos']);
          $count_yt_list = count($yt_list);
          $count_by_row = $col['col_values']['quantity'];
          ?>
          <div class="<?= $col['col_css'] ?> rb-youtube-grid">
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
          echo '<div class="rb-cover-galleries '.$col['col_css'].'">';
          $show_by_file = $col['col_values']['quantity'];
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
          echo '<div class="'.$col['col_css'].'">';
          /*?>
          <div class="cols">
          <?php*/
          // Destripar configuracion
          $category_id = $col['col_values']['cat'];
          $num_posts = $col['col_values']['count'];
          $ord = $col['col_values']['ord'];
          $tit = $col['col_values']['tit'];
          $typ = $col['col_values']['typ'];

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
