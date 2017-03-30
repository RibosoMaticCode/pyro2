<?php
include 'islogged.php';
require_once("../rb-script/funciones.php");
require_once("../rb-script/class/rb-categorias.class.php");

$nomVis=$_POST['categoria_nombre'];
$nomOcul = rb_cambiar_nombre(utf8_encode($_POST['categoria_nombre']));
$des="";
$catpadre = 0;
$nivel = 0;

if($objCategoria->Insertar(array($nomOcul,$nomVis,$des,$catpadre,$nivel,0))){
	$ultimo_id=mysql_insert_id();
	echo "<label class=\"label_checkbox\">";
	echo "<input type=\"checkbox\" value=\"$ultimo_id\" name=\"categoria[]\" /> $nomVis \n";
	echo "</label>";
}else{
	die("error");
}
