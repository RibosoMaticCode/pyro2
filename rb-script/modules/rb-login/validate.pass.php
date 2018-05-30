<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once(ABSPATH."global.php");
require_once(ABSPATH."rb-script/funciones.php");

$pass = trim($_GET['pass']);
if ( rb_valid_pass($pass) ){
  echo "1"; // Valido
}else{
  echo "0";
}
?>
