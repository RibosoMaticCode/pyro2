<?php
// Datos de este widget
$widget = [
  'link_action' => 'addHtmlRaw',
  'dir' => 'code',
  'name' => 'Código',
  'desc' => 'Editor de HTML',
  'filejs' => 'file.js'
];
//Añadiendo al array principals widgets
array_push($widgets, $widget);
?>
<script>
$(".addHtmlRaw").click (function (event) {
  event.preventDefault();
  var widgets = $(this).closest(".widgets");
  var widget_id = "widget"+uniqueId();
  $.ajax({
      url: "core/pages3/widgets/code/w.code.php?temp_id="+widget_id
  })
  .done(function( data ) {
    widgets.append(data);
  });
});
</script>
