<?php
echo '<div class="'.$widget['widget_class'].'">';
echo rb_shortcode(rb_BBCodeToGlobalVariable(html_entity_decode($widget['widget_content'])));
echo '</div>';
?>
