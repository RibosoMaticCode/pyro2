<?php
/*
 * Usando dirname para retroceder
 * 4 niveles arriba y ubicarse
 * en la raiz del sitio
 *
 * Alternativamente se puede usar $_SERVER['DOCUMENT_ROOT']
 * Ver el archivo files.explorer.refresh.php
 *
 * */

if ( !defined('ABSPATH') )
	define('ABSPATH', dirname( dirname( dirname( dirname(__FILE__) ) ) ). '/' );

require_once ABSPATH.'global.php';
require_once ABSPATH.'rb-script/funciones.php';

$controlShowId = $_GET['controlShowId'];
$controlHideId = $_GET['controlHideId'];
?>
<script>
	$( "#close" ).click(function( event ) {
		event.preventDefault();
		$(".bg-opacity").hide();
		$(".explorer").hide();
   	$(".explorer").empty();
	});

	$("#imgsingallery").on("click", ".explorer-file", function (event) { // on(). Para contenido generado dinamicamente
		event.preventDefault();
		$( "#<?= $controlShowId ?>" ).val( $(this).attr("datafld") );
		$( "#<?= $controlHideId ?>" ).val( $(this).attr("datasrc") );
		$( "#close" ).click();
	});

	// Mostrar Uploader de archivos
	$( '#btnShowUploader' ).click(function( event ) {
		event.preventDefault();
		$( ".explorer-body-inner" ).show();
		$( ".gallery-list" ).hide();

		$("#btnShowImages").removeClass('selected');
		$(this).addClass('selected');
	});

	// Refresca la lista de archivos
	$( '#btnShowImages' ).click(function( event ) {
		event.preventDefault();
		$( ".explorer-body-inner" ).hide();
		$( ".gallery-list" ).show();

		$("#btnShowUploader").removeClass('selected');
		$(this).addClass('selected');

		$.ajax({
			method: "GET",
			url: "<?= G_SERVER ?>/rb-script/modules/rb-explorer/files.explorer.refresh.php?album_id=0"
		}).done(function( html_response ) {
		    $('#imgsingallery').html(html_response);
		});
	});
</script>
<div class="explorer-header">
	<h3>Explorar archivos</h3>
	<a id="close" href="#">×</a>
</div>
<div class="explorer-toolbar">
	<a href="#" id="btnShowImages" class="selected">Seleccionar</a>
	<a href="#" id="btnShowUploader">Subir archivo</a>
</div>
<div class="explorer-body">
	<!-- L I S T A D O   I M A G E N E S  -->
	<!--<div class="search-bar">
		<input type="text" placeholder="Archivo a buscar" />
	</div>-->
	<div class="gallery-list">
		<div id="imgsingallery" class="flibrary">
			<?php
			require_once 'files.explorer.refresh.php'
			?>
		</div>
	</div>
	<!-- S U B I R   I M A G E N E S  -->
	<div class="explorer-body-inner" id="examiner-photos" style="display: none">
		<div id="mulitplefileuploader"></div> <!-- aqui aparecen el form -->
		<div id="status"></div>
		<link href="<?= G_SERVER ?>/rb-admin/resource/jquery.file.upload/uploadfile.css" rel="stylesheet">
		<script src="<?= G_SERVER ?>/rb-admin/resource/jquery.file.upload/jquery.uploadfile.js"></script>

		<script type="text/javascript">
		$(document).ready(function(){
			var settings = {
			    url: "<?= G_SERVER ?>/rb-script/modules/rb-uploadimg/upload.php",
			    dragDrop:true,
			    fileName: "myfile",
			    formData: {"albumid":"0" , "user_id" : "<?= G_USERID ?>"},
			    //urlimgedit: '<?= G_SERVER ?>/rb-admin/index.php?pag=img&opc=edt&album_id=0&id=',
			    urlimgedit: '<?= G_SERVER ?>/rb-admin/index.php?pag=file_edit&opc=edt&id=',
			    target: '_blank',
			    allowedTypes:"jpg,png,gif,doc,docx,xls,xlsx,pdf",
			    returnType:"html", //json
				onSuccess:function(files,data,xhr)
			    {
			       //$("#status").append("Subido con exito");
			    },
			    //showDelete:true,
			    deleteCallback: function(data,pd)
				{
			    for(var i=0;i<data.length;i++)
			    {
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
	</div>
</div>
