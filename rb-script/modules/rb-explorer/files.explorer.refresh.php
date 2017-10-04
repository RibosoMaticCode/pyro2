<?php
/*
 * Usando $_SERVER['DOCUMENT_ROOT'] para
 * ubicarse en la raiz del sitio
 *
 * Alternativamente se puede usar dirname
 * Ver el archivo files.explorer.php
 *
 * */

if ( !defined('ABSPATH') )
	define('ABSPATH', dirname( dirname( dirname( dirname(__FILE__) ) ) ). '/' );
	//define('ABSPATH', $_SERVER['DOCUMENT_ROOT']."/" );

require_once ABSPATH.'global.php';
require_once(ABSPATH.'rb-script/class/rb-database.class.php');
require_once(ABSPATH.'rb-script/funciones.php');

if(G_USERTYPE == 1):
	$q = $objDataBase->Ejecutar("SELECT * FROM photo ORDER BY id DESC");
else:
	$q = $objDataBase->Ejecutar("SELECT * FROM photo WHERE usuario_id=".G_USERID." ORDER BY id DESC");
endif;
if( $q->num_rows ):
?>
<ul class="gallery" style="overflow:hidden;margin-bottom:20px;">
	<?php
	while ( $row = $q->fetch_assoc() ):
	?>
	<li><a class="explorer-file" datafld="<?= utf8_encode($row['src']) ?>" datasrc="<?= $row['id'] ?>" href="#">
		<?php
		if(rb_file_type($row['type']) == "image"):
			echo "<img class='thumb' width=\"100\" src=\"../rb-media/gallery/tn/".utf8_encode($row['tn_src'])."\" />";
		else:
			if( rb_file_type( $row['type'] )=="pdf" ) echo "<img src=\"img/pdf.png\" alt=\"png\" />";
			if( rb_file_type( $row['type'] )=="word" ) echo "<img src=\"img/doc.png\" alt=\"png\" />";
			if( rb_file_type( $row['type'] )=="excel" ) echo "<img src=\"img/xls.png\" alt=\"png\" />";
		endif;
		?>
		<span><?= utf8_encode($row['tn_src']) ?></span>
	</a></li>
	<?php
	endwhile;
	?>
</ul>
<div style="clear:both"></div>
<?php
endif;
?>
