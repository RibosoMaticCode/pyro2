<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once(ABSPATH.'global.php');
require_once(ABSPATH."rb-script/class/rb-database.class.php");

$album_id = $_GET['album_id'];

if(G_USERTYPE==1):
	$q = $objDataBase->Ejecutar("SELECT * FROM ".G_PREFIX."files WHERE album_id=$album_id AND type IN ('image/gif','image/png','image/jpeg')");
else:
	$q = $objDataBase->Ejecutar("SELECT * FROM ".G_PREFIX."files WHERE album_id=$album_id AND type IN ('image/gif','image/png','image/jpeg') AND usuario_id=".G_USERID);
endif;

if( $q->num_rows ):
?>
<ul class="gallery pop_library">
	<?php
	while( $r= $q->fetch_assoc() ):
	?>
	<li>
		<img class="thumb" src="<?= G_SERVER ?>rb-media/gallery/tn/<?= utf8_encode($r['src']) ?>" /><br />
		<span><?= utf8_encode($r['src']) ?></span>
	</li>
	<?php
	endwhile;
	?>
</ul>
<div style="clear:both"></div>
<?php
endif;
?>
