<?php
//include 'islogged.php';
require("../rb-script/class/rb-articulos.class.php");
$article_id	= $_GET['article_id'];

$sql = $objArticulo->Consultar("SELECT activo FROM articulos WHERE id=$article_id");
$row = mysql_fetch_array($sql);

if($row['activo']=='D'){
	$objArticulo->EditarPorCampo("activo","A",$article_id);
}else{
	$objArticulo->EditarPorCampo("activo","D",$article_id);
}

$result = $objArticulo->Consultar("SELECT activo FROM articulos WHERE id=$article_id");
$row = mysql_fetch_array($result);

header( "Expires: Mon, 26 Jul 1997 05:00:00 GMT" );
header( "Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT" );
header( "Cache-Control: no-cache, must-revalidate" );
header( "Pragma: no-cache" );
header('Content-type: text/xml; charset=UTF-8', true);
echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
echo "<xml>";

if(!empty($row['activo'])){
	echo "<elemento> \n";
	echo "	<estado>1</estado>";
	echo "	<condicion>".$row['activo']."</condicion> \n";
	echo "</elemento> \n";
}else{
	echo "<elemento> \n";
	echo "	<estado>0</estado> \n";
	echo "</elemento> \n";
}
echo "</xml>";
?>
