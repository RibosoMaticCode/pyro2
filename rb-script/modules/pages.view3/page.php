<?php rb_header(array('header-allpages.php')) ?>
<div class="wrap-content">
<?php
$array_content = json_decode($Page['contenido'], true);
foreach ($array_content['boxes'] as $box) {
  rb_show_block($box);
}
?>
</div>
<?php rb_footer(array('footer-allpages.php')) ?>
