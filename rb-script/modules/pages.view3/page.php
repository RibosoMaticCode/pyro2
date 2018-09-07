<?php
/*if($Page['show_header']==1) rb_header(['header-allpages.php']);
else rb_header();*/
?>
<?php rb_header(array('header-allpages.php')) ?>
<div class="wrap-content">
<?php
$array_content = json_decode($Page['contenido'], true);
foreach ($array_content['boxes'] as $box) {
  rb_show_block($box);
}
?>
</div>
<?php
/*if($Page['show_footer']==1) rb_footer(['footer-allpages.php']);
else rb_footer();*/
?>
<?php rb_footer(array('footer-allpages.php')) ?>
