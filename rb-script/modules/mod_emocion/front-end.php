<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once(ABSPATH."global.php");
require_once(ABSPATH."rb-script/class/rb-database.class.php");
?>
<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<title>Branding Emocion - Archivos adjuntos</title>
		<meta name="description" content="Branding Emocion - Archivo adjuntos">
		<meta name="author" content="Yustus Liñan">
		<meta name="contact" content="jesusvld@gmail.com">
		<meta name="viewport" content="width=device-width,initial-scale=1.0">
		<link rel="stylesheet" href="<?= G_SERVER ?>/rb-script/modules/mod_emocion/css/front-end.css">
		<link rel="shortcut icon" href="favicon.ico">
		<link rel="apple-touch-icon" href="apple-touch-icon.jpg">
	</head>
	<body>
    <div class="header">
      <div class="inner-content">
      <a href="#"><img src="http://emocion.pe/img/bg-logo.png" alt="logo" /></a>
      </div>
    </div>
    <div class="content">
      <div class="inner-content files_list">
        <ul>
          <?php
          if(isset($_GET['uid'])):
            $q = $objDataBase->Ejecutar("SELECT * FROM emo_sendfile WHERE vinculo_usuario='".trim($_GET['uid']."'"));
            $files_array = mysql_fetch_array($q);

						if(strlen($files_array['archivos'])>0){
							$files = json_decode($files_array['archivos']);
	      			foreach ($files as $key => $value) {
	      				$qf = $objDataBase->Ejecutar("SELECT * FROM photo WHERE id =".$value);
	      				$file = mysql_fetch_array($qf);
	              ?>
	              <li><a href="<?= G_SERVER ?>/rb-media/gallery/<?= utf8_encode($file['src']) ?>" download><?= utf8_encode($file['src']) ?></a></li>
	              <?php
	      			}
						}elseif(strlen($files_array['vinculos'])>0){
							$arr = json_decode($files_array['vinculos']);
							foreach ($arr as $key => $value) {
								?><li><a href="<?= $value ?>" download><?= $value ?></li><?php
							}
						}
          endif;
          ?>
        </ul>
      </div>
    </div>
  </body>
</html>
