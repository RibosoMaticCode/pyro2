<?php
echo '<div class="'.$widget['widget_class'].'">';
$SidebarId = $widget['widget_values']['name'];
$Sidebar = rb_show_specific_page($SidebarId);
$array_content = json_decode($Sidebar['contenido'], true);
foreach ($array_content['boxes'] as $box) {
  rb_show_block($box, "sidebar");
}
echo '</div>';
