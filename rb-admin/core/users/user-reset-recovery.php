<?php
include 'islogged.php';
$mail=$_GET['mail'];
require("../rb-script/class/rb-users.class.php");
$objUsuario->Consultar("UPDATE ".G_PREFIX."users SET recovery=0 WHERE correo = '".$mail."'");
?>
