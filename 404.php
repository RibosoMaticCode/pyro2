<?php
require_once 'global.php';
?>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <title>No existe el contenido</title>
    <style>
      @font-face {
        font-family: condensed-regular;
        src: url('<?= G_SERVER ?>/rb-admin/fonts/RobotoCondensed-Regular.ttf');
      }
      *{
        padding: 0;
        margin: 0;
        box-sizing: border-box;
        font-family: condensed-regular;
      }
      body{
        background-image: url('<?= G_SERVER ?>/rb-script/images/bg-404.jpg');
      }
      .e404{
        position: absolute;
        top:50%;
        left: 50%;
        transform: translate(-50%, -50%);
      }
      .return_link{
        font-size: 1.2em;
        color:#6e89bf;
        padding: 15px 20px;
        display: inline-block;
        text-decoration: none;
      }
    </style>
  </head>
  <body>
    <img class="e404" src="<?= G_SERVER ?>/rb-script/images/404.png" alt="Error 404" />
    <a class="return_link" href="<?= G_SERVER ?>">Regresar a la página principal</a>
  </body>
</html>
