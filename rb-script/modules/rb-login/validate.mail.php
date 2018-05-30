<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once(ABSPATH."global.php");
require_once(ABSPATH."rb-script/funciones.php");
require_once(ABSPATH."rb-script/class/rb-usuarios.class.php");

$mail = trim($_GET['mail']);

if(rb_validar_mail($mail)):
  if($objUsuario->existe('correo',$mail)==0):
    echo "0"; //valido
  else:
    echo "1"; // Mail existente
  endif;
else:
  echo "2"; // Mail invalido
endif;
?>
