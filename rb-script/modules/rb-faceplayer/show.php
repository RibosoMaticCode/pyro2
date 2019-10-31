<style>
    iframe{
        min-height:230px;
    }
</style>
<?php
$fb_url_video = $_GET['fbUrlVideo'];
?>
<iframe src="https://www.facebook.com/plugins/video.php?href=<?= $fb_url_video?>&show_text=0&width=560" width="800" height="600" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true" allowFullScreen="true"></iframe>
