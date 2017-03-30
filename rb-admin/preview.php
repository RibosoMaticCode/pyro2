<?php
include 'islogged.php';
require_once '../rb-script/funciones.php';
require_once '../global.php';

$css = rb_list_files('../rb-temas/'.G_ESTILO.'/css/');
$num_files = count($css);
$css_files = "";
$coma = "";
$i=0;
while($i<$num_files):
	echo '<link rel="stylesheet" href="../rb-temas/'.G_ESTILO.'/css/'.$css[$i].'">';
	$i++;
endwhile;


$id = $_GET['page_id'];

$Page = rb_show_specific_page($id);
echo BBCodeToGlobalVariable($Page['contenido']);
?>
