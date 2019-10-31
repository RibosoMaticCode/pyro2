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
    <a class="fancy fancybox.iframe" href="https://www.youtube.com/embed/<?= trim($yt_list[$i]) ?>" style="width:<?= $width?>%;background-image:url('https://img.youtube.com/vi/<?= trim($yt_list[$i]) ?>/mqdefault.jpg')">
      <img src="<?= G_SERVER ?>rb-admin/core/pages3/widgets/youtube/play.png" class="rb-youtube-play-icon" alt="play" />
    </a>
    <?php
    $i++;
  endwhile;
  ?>
</div>
