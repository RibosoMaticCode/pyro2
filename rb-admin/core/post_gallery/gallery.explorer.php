<?php
if(isset($_GET['album_id'])){
	$album_id = $_GET['album_id'];
}

if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once(ABSPATH.'global.php');
require_once(ABSPATH."rb-script/class/rb-database.class.php");
?>
<script>
	$( "#close" ).click(function( event ) {
		event.preventDefault();
		$(".bg-opacity").hide();
		$(".explorer").hide();
   		$(".explorer").empty();
	});
	$( ".explorer-file" ).click(function( event ) {
		$( "#close" ).click();
	});

	// Mostrar Uploader o Selector de imagenes
	$( '#btnShowUploader' ).click(function( event ) {
		$( "#examiner-photos" ).show();
		$( "#photos" ).hide();

		$.ajax({
			method: "GET",
			url: "<?= G_SERVER ?>/rb-admin/core/post_gallery/gallery.images.toselect.php?album_id=<?= $album_id ?>"
		}).done(function( msg ) {
		    $('#imagestoselect').html(msg);
		});

		$("#btnShowImages").removeClass('selected');
		$(this).addClass('selected');
	});

	// Refresca la lista de imagenes en la galeria
	$( '#btnShowImages' ).click(function( event ) {
		$( "#examiner-photos" ).hide();
		$( "#photos" ).show();

		$.ajax({
			method: "GET",
			url: "<?= G_SERVER ?>/rb-admin/core/post_gallery/gallery.explorer.refresh.php?album_id=<?= $album_id ?>"
		}).done(function( msg ) {
		    $('#imgsingallery').html(msg);
		});
		$("#btnShowUploader").removeClass('selected');
		$(this).addClass('selected');
	});

	// SUBMIT DE IMAGENES
	$( "#formselectimgs" ).submit(function( event ) {
		event.preventDefault();
		$.ajax({
			method: "POST",
			url: "<?= G_SERVER ?>/rb-admin/core/post_gallery/gallery.save.selectimages.php",
			data: $( "#formselectimgs" ).serialize()
		}).done(function( msg ) {
		   	if(msg=="ok"){
				$.ajax({
					method: "GET",
					url: "<?= G_SERVER ?>/rb-admin/core/post_gallery/gallery.explorer.refresh.php?album_id=<?= $album_id ?>"
				}).done(function( msg ) {
				    $('#imgsingallery').html(msg);
				});

		   		$( "#examiner-photos" ).hide();
				$( "#photos" ).show();

				$("#btnShowUploader").removeClass('selected');
				$( '#btnShowImages' ).addClass('selected');
		   	}
		});
	});
</script>
<?php

/* ACCESO A TRAVES DEL CODIGO DEL ALBUM/GALERIA */

if(G_USERTYPE==1):
	$qg = $objDataBase->Ejecutar("SELECT nombre FROM albums WHERE id=$album_id");
else:
	$qg = $objDataBase->Ejecutar("SELECT nombre FROM albums WHERE id=$album_id AND usuario_id = ".G_USERID);
endif;

$rg= $qg->fetch_assoc();
?>
<div class="explorer-header">
	<h3>Galería: <?= $rg['nombre']?></h3>
	<a id="close" href="#">×</a>
</div>
<div class="explorer-toolbar">
	<a href="#" id="btnShowImages" class="selected">Seleccionados</a>
	<a href="#" id="btnShowUploader">Subir / Seleccionar imágenes</a>
</div>
<div class="explorer-body">
	<!-- LISTADO DE ARCHIVOS -->
	<div id="photos">
		<div class="explorer-body-inner">
			<div id="imgsingallery" class="flibrary">
				<?php
				require_once 'gallery.explorer.refresh.php'
				?>
			</div>
		</div>
	</div>
	<!-- S U B I R   I M A G E N E S  -->
	<div id="examiner-photos" style="display:none">
		<div class="explorer-body-inner">
			<!--<h4>Subir imágenes</h4>-->
			<div id="mulitplefileuploader"></div>
			<div id="status"></div>
				<!-- Load multiples imagenes -->
			<link href="<?= G_SERVER ?>/rb-admin/resource/jquery.file.upload/uploadfile.css" rel="stylesheet">
			<script src="<?= G_SERVER ?>/rb-admin/resource/jquery.file.upload/jquery.uploadfile.js"></script>

			<script type="text/javascript">
			$(document).ready(function(){
				var settings = {
				    url: "<?= G_SERVER ?>/rb-admin/uploader.php",
				    dragDrop:true,
				    fileName: "myfile",
				    formData: {"albumid":"<?= $album_id ?>", "user_id" : "<?= G_USERID ?>"},
				    urlimgedit: '<?= G_SERVER ?>/rb-admin/index.php?pag=img&opc=edt&album_id=<?= $album_id ?>&id=',
				    allowedTypes:"jpg,png,gif,doc,pdf,zip",
				    returnType:"html", //json
					onSuccess:function(files,data,xhr){
				       //$("#status").append("Subido con exito");
				    },
				    //showDelete:true,
				    deleteCallback: function(data,pd){
				    	for(var i=0;i<data.length;i++){
					        $.post("delete.php",{op:"delete",name:data[i]},
					        function(resp, textStatus, jqXHR)
					        {
					            $("#status").append("<div>Archivo borrado</div>");
					        });
					     }
					     pd.statusbar.hide(); //You choice to hide/not.
					}
				}
				var uploadObj = $("#mulitplefileuploader").uploadFile(settings);
			});
			</script>
			<?php
			if(G_USERTYPE==1):
				$q = $objDataBase->Ejecutar("SELECT * FROM photo WHERE album_id=0 AND type IN ('image/gif','image/png','image/jpeg')");
			else:
				$q = $objDataBase->Ejecutar("SELECT * FROM photo WHERE album_id=0 AND type IN ('image/gif','image/png','image/jpeg') AND usuario_id = ".G_USERID);
			endif;
			if( $q->num_rows ):
			?>
			<h4>Imagenes sin galería</h4>
			<div class="flibrary">
				<form id="formselectimgs" action="save.php" method="POST" name="library">
					<input type="hidden" name="album_id" value="<?= $album_id ?>" />
					<input type="hidden" name="section" value="imgnew" />
					<ul id="imagestoselect" class="gallery pop_library">

					</ul>
					<div style="clear:both"></div>
					<p style="text-align: center;"><input type="submit" value="Guardar seleccion" /></p>
				</form>
			</div>
			<?php
			endif;
			?>
		</div>
	</div>
</div>
