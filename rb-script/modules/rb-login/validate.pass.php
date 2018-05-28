<?php
//http://w3.unpocodetodo.info/utiles/regex-ejemplos.php?type=psw
$pass = $_GET['pass'];
$pass = mb_convert_encoding($pass, "UTF-8");
if (preg_match('/^(?=\w*\d)(?=\w*[A-Z])(?=\w*[a-z])\S{8,16}$/', $pass)){
  echo "1"; // Valido
}else{
  echo "0";
}
?>
