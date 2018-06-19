<?php
// Datos de este widget
$widget = [
  'link_action' => 'addGalleries',
  'dir' => 'gallery',
  'name' => 'Galerias',
  'desc' => 'Mostrar diferentes galerias del sistema',
  'filejs' => 'file.js'
];
//Añadiendo al array principals widgets
array_push($widgets, $widget);
?>
<script>
$(".addGalleries").click (function (event) {
  event.preventDefault();
  var widgets = $(this).closest(".widgets");
  var widget_id = "widget"+uniqueId();
  $.ajax({
      url: "core/pages3/widgets/gallery/w.gallery.php?temp_id="+widget_id
  })
  .done(function( data ) {
    widgets.append(data);
  });
});
</script>
