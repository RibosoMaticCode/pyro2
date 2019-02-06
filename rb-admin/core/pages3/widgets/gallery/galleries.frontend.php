<img style="display:none" src='<?= G_SERVER ?>/rb-script/modules/pages.view3/spinner.gif' alt="spinner" />
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
        url: "<?= G_SERVER ?>/rb-script/modules/pages.view3/show.gallery.ajax.php?gallery_id="+gallery_id,
        beforeSend: function() {
          $('.rb-cover-galleries').hide();
          $('.rb-gallery-photos').show();
          $('.rb-gallery-photos').html("<img src='<?= G_SERVER ?>/rb-script/modules/pages.view3/spinner.gif' />");
        },
    }).done(function( data ) {
      $('.rb-gallery-photos').html(data);
    });
  });
});
</script>
<div class="rb-wrap-galleries">
<?php
echo '<div class="rb-cover-galleries '.$widget['widget_class'].'">';
$show_by_file = $widget['widget_values']['quantity'];
$groupname = $widget['widget_values']['group'];
$limit = $widget['widget_values']['limit'];
$link = $widget['widget_values']['link'];
$Galleries = rb_list_galleries($limit, $groupname);
$CountGalleries = count($Galleries);
$porcent_width = round(100/$show_by_file,2);
$i=1; // contador por fila
$j=1; // contador general
foreach ($Galleries as $Gallery) {
  if($i==1){
    echo '<div class="rb-gallery-container">'; // open rb-gallery-container
  }
  echo '<div class="rb-gallery" style="width:'.$porcent_width.'%">'; // open rb-gallery
    if($link==0)
    echo '<a data-galleryid="'.$Gallery['id'].'" href="'.G_SERVER.'/?gallery='.$Gallery['id'].'">';

    if($link==1)
    echo '<a data-galleryid="'.$Gallery['id'].'" href="#" class="gallery_show">';

    echo '<div>'; // open div (no name)

    echo '<div class="rb-bg-gallery" style="background-image:url(\''.$Gallery['url_bgimagetn'].'\')" />'; // open rb-bg-gallery
    echo '</div>'; // close rb-bg-gallery

    echo '<div class="rb-gallery-info">'; // open rb-gallery-info
      echo '<span class="rb-gallery-title">'.$Gallery['nombre'].'</span>';
      echo '<span class="rb-gallery-desc">'.$Gallery['descripcion'].'</title>';
    echo '</div>'; // close rb-gallery-info

    echo '</div>'; // close div

    echo '</a>';

  echo '</div>'; // close rb-gallery
  if($j==$CountGalleries || $i==$show_by_file){
    echo '</div>'; // Close rb-gallery-container
    $i=1;
  }else{
    $i++;
  }
  $j++;
}
echo '</div>'; // close rb-cover-galleries
?>
</div>
<div class="rb-gallery-photos">
</div>
