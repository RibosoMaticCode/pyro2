<span class="info">Archivos permitidos: jpg, png, gif, doc, docx, xls, xlsx, pdf. Tamaño máximo: 8 MB</span>
<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once(ABSPATH.'global.php');
?>
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
	    formData: {"albumid":"0", "user_id" : "<?= G_USERID ?>"},
	    urlimgedit: '<?= G_SERVER."/rb-admin/index.php?pag=file_edit&opc=edt&id=" ?>',
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
