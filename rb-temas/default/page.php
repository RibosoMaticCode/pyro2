<?php rb_header(array('header-allpages.php')) ?>
<div class="wrap-content">
<?php
$array_content = json_decode($Page['contenido'], true);
foreach ($array_content['boxes'] as $box) {
  //Bloque externo
  $ext_class = $box['boxext_class']!="" ? $box['boxext_class'] : "";
  $style_extbgcolor = $box['boxext_bgcolor']!="" ? "background-color:".$box['boxext_bgcolor'].";" : "";
  $style_extbgimage = $box['boxext_bgimage']!="" ? "background-image:url(".$box['boxext_bgimage'].");background-position:center;background-size:cover;" : "";
  $style_extpaddingtop = $box['boxext_paddingtop']!="" ? "padding-top:".$box['boxext_paddingtop'].";" : "";
  $style_extpaddingright = $box['boxext_paddingright']!="" ? "padding-right:".$box['boxext_paddingright'].";" : "";
  $style_extpaddingbottom = $box['boxext_paddingbottom']!="" ? "padding-bottom:".$box['boxext_paddingbottom'].";" : "";
  $style_extpaddingleft = $box['boxext_paddingleft']!="" ? "padding-left:".$box['boxext_paddingleft'].";" : "";

  $styles_ext = $style_extbgcolor.$style_extbgimage.$style_extpaddingtop.$style_extpaddingright.$style_extpaddingbottom.$style_extpaddingleft;
  echo '<div class="'.$ext_class.' clear" style="'.$styles_ext.'">';
  //BLoque interno
  if($box['boxin_width']=="yes"){
    $in_class = "full-content ";
    $style_inwidth = "";
  }elseif($box['boxin_width']!="yes" && $box['boxin_width']!=""){
    $in_class = "";
    $style_inwidth = "width:".$box['boxin_width'].";margin:0 auto;";
  }elseif($box['boxin_width']==""){
    $in_class = "inner-content ";
    $style_inwidth = "";
  }
  $style_inbgcolor = $box['boxin_bgcolor']!="" ? "background-color:".$box['boxin_bgcolor'].";" : "";
  $style_inbgimage = $box['boxin_bgimage']!="" ? "background-image:url(".$box['boxin_bgimage'].");background-position:center;background-size:cover;" : "";
  $style_inheight = $box['boxin_height']!="" ? "height:".$box['boxin_height'].";" : "";
  $style_inpaddingtop = $box['boxin_paddingtop']!="" ? "padding-top:".$box['boxin_paddingtop'].";" : "";
  $style_inpaddingright = $box['boxin_paddingright']!="" ? "padding-right:".$box['boxin_paddingright'].";" : "";
  $style_inpaddingbottom = $box['boxin_paddingbottom']!="" ? "padding-bottom:".$box['boxin_paddingbottom'].";" : "";
  $style_inpaddingleft = $box['boxin_paddingleft']!="" ? "padding-left:".$box['boxin_paddingleft'].";" : "";

  $styles_in = $style_inheight.$style_inbgcolor.$style_inbgimage.$style_inpaddingtop.$style_inpaddingright.$style_inpaddingbottom.$style_inpaddingleft.$style_inwidth;

  echo '<div class="'.$in_class.' clear" style="'.$styles_in.'">';
  echo '<div class="cols">';
  $array_cols =$box['columns'];
  foreach ($array_cols as $col) {
    switch ($col['col_type']) {
      case 'html':
        echo '<div class="'.$col['col_css'].'">';
        echo html_entity_decode($col['col_content']);
        echo '</div>';
        break;
      case 'slide':
        echo '<div class="'.$col['col_css'].'">';
        $fotos = rb_get_images_from_gallery($col['col_content']);
        foreach ($fotos as $foto) {
          echo '<div data-src="'.$foto['url_max'].'" data-thumb="'.$foto['url_min'].'"></div>';
        }
        echo '</div>';
        break;
    }
  }
  echo '</div>'; //end cols
  echo '</div>'; //end inner box
  echo '</div>'; //end outer box
}
?>
</div>
<?php rb_footer() ?>
