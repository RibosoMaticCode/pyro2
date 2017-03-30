<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once(ABSPATH.'global.php');
require_once(ABSPATH."rb-script/class/rb-galerias.class.php");

$album_id = $_GET['album_id'];

if(G_USERTYPE==1):
	$q = $objGaleria->Consultar("SELECT * FROM photo WHERE album_id=$album_id AND type IN ('image/gif','image/png','image/jpeg')");
else:
	$q = $objGaleria->Consultar("SELECT * FROM photo WHERE album_id=$album_id AND type IN ('image/gif','image/png','image/jpeg') AND usuario_id=".G_USERID);
endif;

if(mysql_num_rows($q)):
?>			
<ul class="gallery pop_library">
	<?php						
	while($r=mysql_fetch_array($q)):
	?>
	<li>
		<img class="thumb" src="<?= G_SERVER ?>/rb-media/gallery/tn/<?= $r['src'] ?>" /><br />
		<span><?= $r['src'] ?></span>
	</li>
	<?php	
	endwhile;
	?>
</ul>
<div style="clear:both"></div>
<?php
endif;
?>