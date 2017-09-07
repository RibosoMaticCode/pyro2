<?php
// 24-06-17: Jiustus
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once(ABSPATH.'global.php');
?>
<div id="message_general"></div>
<link href="<?= G_SERVER ?>/rb-script/modules/rb-uploadimg2/uploadfile.css" rel="stylesheet">
<script src="<?= G_SERVER ?>/rb-script/modules/rb-uploadimg2/jquery.uploadfile.js"></script>
<form class="emo_formup" method="post" action="sendfile_mailer.php" style="width: 500px">
	<p>Nro maximo de archivos a subir: <strong>20</strong>. Tamaño maximo de carga: <strong>128Mb</strong></p>
	<div id="mulitplefileuploader"></div>
	<script type="text/javascript">
	$(document).ready(function(){
		var settings = {
			url: "<?= G_SERVER ?>/rb-script/modules/rb-uploadimg2/upload.php",
			urlplugin: "<?= G_SERVER ?>/rb-script/modules/rb-uploadimg2/",
			autoSubmit: false,
			dragDrop:true,
			maxFileCount: 20, //php config
			maxFileSize: 134217728, // htaccess php_value post_max_size  128M
			fileName: "myfile",
			formData: {"albumid":"0", "user_id" : "<?= G_USERID ?>"},
		  //allowedTypes:"jpg,png,gif,doc,docx,xls,xlsx,pdf",
		  returnType:"html",
			afterUploadAll:function(obj){
				console.log(JSON.stringify(uploadObj.getResponses()));
				// registrar los archivos subidos a la base de datos
				var des = $('#destinatarios').val();
				var send = $('#correo').val();
				var mess = $('#mensaje').val();
				$.ajax({
					url: "<?= G_SERVER ?>/rb-script/modules/mod_emocion/sendfile_mailer.php",
					data: {correo: send, destinatarios: des, mensaje : mess, files_id : JSON.stringify(uploadObj.getResponses())},
					method: 'post'
				}).done(function(data) {
					console.log(data);
					if(data.result=="1"){
						$('.emo_formup').hide();
						$('#message_general').html("<div style='text-align:center;padding:10px 0'><img src='"+settings.urlplugin+"send.png' alt='send'></div><h3 style='text-align:center;padding:8px 0'>Los archivos fueron subidos y enviados a los destinatarios especificados.</h3>")
						setTimeout(function(){
							window.location.href = '<?= G_SERVER ?>/rb-admin/module.php?pag=emo_sendmailfile';
						}, 1500);
					}else{
						if(data.result=="0"){
							// Mensaje de error mostrado
							$('#message_general').html(data.message);
						}
					}
				});
			},
		}
		var uploadObj = $("#mulitplefileuploader").uploadFile(settings);

		//Submit archivos, previamente verificamos valores en los campos
		$('#btnSend').click(function(event){
			event.preventDefault();
			if($('#destinatarios').val()==""){
				$('#destinatarios').addClass('border-red');
				$('#destinatarios').nextAll().remove();
				$('#destinatarios').after('<span class="error-notify">Falta este campo</span>');
				$('#destinatarios').focus();
				return false;
			}else{
				$('#destinatarios').removeClass('border-red');
				$('#destinatarios').nextAll().remove();
			}
			if($('#correo').val()==""){
				$('#correo').addClass('border-red');
				$('#correo').nextAll().remove();
				$('#correo').after('<span class="error-notify">Falta este campo</span>');
				$('#correo').focus();
				return false;
			}else{
				$('#correo').removeClass('border-red');
				$('#correo').nextAll().remove();
			}
			$('#mulitplefileuploader').hide();
			$('.wrap-inputs').hide();
			uploadObj.startUpload();
		});
	});
	</script>
	<div class="wrap-inputs">
		<label>
	    <input id="destinatarios" type="email" name="destinatarios" required placeholder="Enviar a" />
	  </label>
	  <label>
			<input id="correo" type="email" name="correo" required placeholder="Tu email" />
		</label>
		<label>
			<textarea id="mensaje" name="mensaje" placeholder="Mensaje" rows="2" />
		</label>
		<button id="btnSend" type="submit">Enviar</button>
	</div>
</form>
