<?php
$yt_list = explode(",", $widget['widget_values']['videos']);
$count_yt_list = count($yt_list);
$count_by_row = empty($widget['widget_values']['quantity']) ? 1 : $widget['widget_values']['quantity'];
?>
<div class="<?= $widget['widget_class'] ?> rb-youtube-grid">
  <?php
  $width = round(100 / $count_by_row, 2);
  $i=0;
  while($i<$count_yt_list):
    ?>
    <div style="width:<?= $width?>%">
      <iframe width="100%" height="275" src="https://www.youtube.com/embed/<?= $yt_list[$i] ?>?modestbranding=0&autohide=1&showinfo=0" frameborder="0" allow="encrypted-media" allowfullscreen></iframe>
    </div>
    <?php
    $i++;
  endwhile;
  ?>
</div>
