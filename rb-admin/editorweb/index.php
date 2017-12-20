<?php
if ( !defined('ABSPATH') )
  define('ABSPATH', dirname(dirname(dirname(__FILE__))) . '/');

require_once ABSPATH."global.php";
$url_editor = G_SERVER.'/rb-admin/editorweb/';
?>
<html>
  <head>
    <title>Editor Web</title>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <link rel="stylesheet" type="text/css" href="<?= $url_editor ?>css/styles.css" />
    <script src="<?= $url_editor ?>js/func.js"></script>
  </head>
  <body>
    <?php include_once 'tools.php' ?>
    <div class="main">
      <div id="wrapper_header" class="wrapper wrapper_header">
        <div id="inner_header" class="inner inner_header">
        </div>
      </div>
      <div id="wrapper_content" class="wrapper wrapper_content">
        <div class="inner inner_content">
        </div>
      </div>
      <div id="wrapper_footer" class="wrapper wrapper_footer">
        <div class="inner inner_footer">
        </div>
      </div>
    </div>
  </body>
</html>
