<?php
// Datos de este widget
$widget = [
  'link_action' => 'addSidebar',
  'dir' => 'sidebar',
  'name' => 'Barra lateral',
  'desc' => 'Configurar la barra lateral',
  'filejs' => 'file.js',
  'img' => 'sidebar.png'
];
//Añadiendo al array principals widgets
array_push($widgets, $widget);
?>
<script>
$(".addSidebar").click (function (event) {
  event.preventDefault();
  var widgets = $(this).closest(".widgets");
  var widget_id = "widget"+uniqueId();
  $.ajax({
      url: "core/pages3/widgets/sidebar/w.sidebar.php?temp_id="+widget_id
  })
  .done(function( data ) {
    notify("Elemento <?= $widget['name'] ?> añadido");
    widgets.append(data);
  });
});
</script>
