<?php
// Datos de este widget
$widget = [
  'link_action' => 'addImage',
  'dir' => 'image',
  'name' => 'Imagen',
  'desc' => 'Añade una image',
  'filejs' => '',
  'img' => 'gallery.png',
  'file' => 'widgets/image/w.image.php',
  'type' => 'image'
];
//Añadiendo al array principals widgets
array_push($widgets, $widget);
?>
<script>
$(".addImage").click (function (event) {
  event.preventDefault();
  var widgets = $(this).closest(".widgets");
  var widget_id = "widget"+uniqueId();
  $.ajax({
      url: "core/pages3/widgets/image/w.image.php?temp_id="+widget_id
  })
  .done(function( data ) {
    notify("Elemento <?= $widget['name'] ?> añadido");
    widgets.append(data);
  });
});
</script>
