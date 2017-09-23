<?php
include 'islogged.php';
$mail=$_GET['mail'];
require("../rb-script/class/rb-usuarios.class.php");
$objUsuario->Consultar("UPDATE usuarios SET recovery=0 WHERE correo = '$mail'");
?>
