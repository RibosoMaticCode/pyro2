<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once(ABSPATH.'global.php');
require_once(ABSPATH."rb-script/class/rb-galerias.class.php");

if(isset($_GET['album_id'])){
	$album_id = $_GET['album_id'];
}
if(G_USERTYPE == 1):
	$q = $objGaleria->Consultar("SELECT * FROM photo WHERE album_id=0 AND type IN ('image/gif','image/png','image/jpeg')");
else:
	$q = $objGaleria->Consultar("SELECT * FROM photo WHERE album_id=0 AND type IN ('image/gif','image/png','image/jpeg') AND usuario_id=".G_USERID);
endif;

while($r=mysql_fetch_array($q)):
?>
<li>
	<label>
		<input type="checkbox" name="items[]" value="<?= $r['id']?>" /> <br />
		<img class="thumb" src="<?= G_SERVER ?>/rb-media/gallery/tn/<?= $r['src'] ?>" /><br />
		<span><?= $r['src'] ?></span>
	</label>
</li>
<?php	
endwhile;
?>