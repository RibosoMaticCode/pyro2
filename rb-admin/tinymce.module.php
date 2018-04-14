<?php
include 'islogged.php';
?>
<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
<script type="text/javascript">
	tinymce.init({
		selector: '.mce_tiny',
		entity_encoding : "raw",
		convert_urls : false,
		extended_valid_elements: "i[class], span, span[class]",
		language_url : '<?= G_SERVER ?>/rb-admin/tinymce/langs/es_MX.js',
	  	height: 500,
	  	plugins: [
	    	'advlist autolink lists link image charmap print preview anchor',
	    	'searchreplace visualblocks code fullscreen',
	    	'insertdatetime media table contextmenu paste code'
	  	],
	  	toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
	  	content_css: '//www.tinymce.com/css/codepen.min.css',
	  	file_browser_callback   : function(field_name, url, type, win) {
	  		if (type == 'file') {
				var cmsURL       = 'gallery.explorer.tinymce.php?type=file';
			} else if (type == 'image') {
				var cmsURL       = 'gallery.explorer.tinymce.php?type=image';
			}

			tinymce.activeEditor.windowManager.open({
				file            : cmsURL,
				title           : 'Selecciona una imagen',
				width           : 860,
				height          : 600,
				resizable       : "yes",
				inline          : "yes",
				close_previous  : "yes"
			}, {
				window  : win,
				input   : field_name
			});
		}
	});
</script>
