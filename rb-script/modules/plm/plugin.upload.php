<label>Imagenes (jpg, png, gif, jpeg permitidos)</label>
<div id="fileuploader"></div>
<div id="status"></div>
<!-- Load multiples imagenes -->
<link href="<?= G_SERVER ?>rb-admin/resource/jquery.file.upload/uploadfile.css" rel="stylesheet">
<script src="<?= G_SERVER ?>rb-admin/resource/jquery.file.upload/jquery.uploadfile.js"></script>
<script>
$(document).ready(function(){
	var settings = {
		url: "<?= G_SERVER ?>rb-admin/uploader.php",
		dragDrop:true,
		fileName: "myfile",
		formData: {"albumid":"0", "user_id" : "<?= G_USERID ?>"},
		showDone: false,
		allowedTypes:"jpeg,jpg,png,gif",
		returnType:"json", //json
		showStatusAfterSuccess: false,
		maxFileSize:2000*1024,
		onSuccess:function(files,data,xhr){
			$('#preview-imgs').append('<li id="previmg_'+data.last_id+'" data-id='+data.last_id+'><div style="background-image:url(<?= G_SERVER ?>rb-media/gallery/tn/'+data.filename+')"><a class="remove-img" href="#">Retirar</a></div></li>');
			//$("#status").append("Subido con exito");
		},
		showEdit:false,
		showDelete:true,
		deleteCallback: function(data,pd){
			$.get("<?= G_SERVER ?>rb-admin/core/files/file-del.php",{
				id:data.last_id
			},function(resp, textStatus, jqXHR){
				//$("#status").append("<div>Archivo borrado</div>");
			});
	    pd.statusbar.hide(); //You choice to hide/not.
		}
	}
	var uploadObj = $("#fileuploader").uploadFile(settings);
});
</script>
