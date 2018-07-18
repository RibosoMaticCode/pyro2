<?php
if(!isset($_GET['file'])):
  return false;
else:
  require_once "../global.php";
  $file = $_GET['file'];
  $dir_download = "/download";
  if(G_ACCESOUSUARIO):
    header('Location: '.G_SERVER.$dir_download.'/'.$file);
  else:
    $url_to_redirect = "http://".G_HOSTNAME.$_SERVER['REQUEST_URI']; // Link para volver --revisar
    header('Location: '.G_SERVER.'/login.php');
  endif;
endif;
?>
