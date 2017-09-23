<?php
include 'islogged.php';
?>
<ul class="images-gallery">
<?php
if(!isset($album_id)):
	$album_id = $_GET['album_id'];
	require_once("../rb-script/class/rb-galerias.class.php");
	require_once("../global.php");
endif;
//if(isset($row)):
	if($album_id >0):
		$gallery_id = $album_id;
       	if(G_USERTYPE == 1):
			$q = $objGaleria->Consultar("SELECT * FROM photo WHERE album_id=$gallery_id AND type IN ('image/gif','image/png','image/jpeg')");
		else:
			$q = $objGaleria->Consultar("SELECT * FROM photo WHERE album_id=$gallery_id AND type IN ('image/gif','image/png','image/jpeg') AND usuario_id=".G_USERID);
		endif;

		while($r=mysql_fetch_array($q)):
		?>
		<li data-id="<?= $r['id'] ?>">
			<span class="gallery-items-del">[X]</span>
			<label>
				<img class="thumb" src="<?= G_SERVER ?>/rb-media/gallery/tn/<?= $r['src'] ?>" /><br />
				<!--<span><?= $r['src'] ?></span>-->
			</label>
		</li>
		<?php
		endwhile;
	endif;
//endif;
?>
</ul>
<div style="clear: both"></div>
<script>
	$(document).ready(function() {
		$( '.gallery-items-del' ).click( function (event){
			alert("hola");
			//console.log($(this).closest("li").attr('data-id'));
			/*var img_id = $(this).closest("li").attr('data-id');
			var img_item = $(this).closest("li");

			$.ajax({
				method: "GET",
				url: "all.delete.php?id="+img_id+"&sec=img"
			}).done(function( html ) {
			    img_item.remove();
			});*/
		});
	});
</script>
