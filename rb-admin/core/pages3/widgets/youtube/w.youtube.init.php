<?php
// Datos de este widget
$widget = [
  'link_action' => 'addYoutube1',
  'dir' => 'youtube',
  'name' => 'Video de Youtube',
  'desc' => 'Lista de reprodución de Youtube',
  'filejs' => 'file.js'
];
//Añadiendo al array principals widgets
array_push($widgets, $widget);
?>
<script>
$(".addYoutube1").click (function (event) {
  event.preventDefault();
  var widgets = $(this).closest(".widgets");
  var widget_id = "widget"+uniqueId();
  $.ajax({
      url: "core/pages3/widgets/youtube/w.youtube.php?temp_id="+widget_id
  })
  .done(function( data ) {
    widgets.append(data);
  });
});
</script>
