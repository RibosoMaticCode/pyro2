<?php
include 'islogged.php';
/*
 *
 * AGREGA UNA NUEVA GALERIA DE FOTOS AL POST ACTUAL
 *
 * */
require_once("../rb-script/funciones.php");
require_once("../rb-script/class/rb-galerias.class.php");

// definiendo valores

$nomVis=$_POST['galeria_nombre'];
$nomOcul = rb_cambiar_nombre(utf8_encode($_POST['galeria_nombre']));
$des="";
$catpadre = 0;
$nivel = 0;

if($objGaleria->Insertar(array($nomVis,"",0,"NOW()",$nomOcul))){
	$ultimo_id=mysql_insert_id();
	echo "<label class=\"label_checkbox\">";
	echo "<input type=\"checkbox\" value=\"$ultimo_id\" name=\"albums[]\" /> $nomVis (<a data-id='".$ultimo_id."' class='galleries' href='#'>Editar</a>) \n";
	echo "</label>";
}else{
	die("error");
}
