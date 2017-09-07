<?php
// 24-06-17: Jiustus
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once(ABSPATH.'global.php');
?>
<div id="message_general"></div>
<form id="emo_formup" class="emo_formup" method="post" action="sendfile_mailer.php" style="width: 500px">
	<div id="links">
		<div class="link cols-container">
			<div class="cols-11-md">
				<input type="text" name="link[]" placeholder="Pegar vinculo http:// ..." required />
			</div>
			<div class="cols-1-md"></div>
		</div>
	</div>
	<span class="more">
		<a id="new_link" href="#">+ Añadir vínculo</a>
	</span>

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
</form>
<!--<script src="<?= G_SERVER ?>/rb-script/modules/mod_emocion/text-add.js"></script>-->
<script type="text/javascript">
$(document).ready(function(){
	/* P A R A   L I N K S */
  $( "#new_link" ).click(function(event) {
    event.preventDefault();
    $('#links .link:last').after(
    '<div class="link cols-container">'+
      '<div class="cols-11-md">'+
        '<input type="text" name="link[]" placeholder="Pegar vinculo http:// ..." required />'+
      '</div>'+
      '<div class="cols-1-md">'+
      '<a title="Quitar" class="linkdelete" href="#"><img height="12" width="12" src="<?= G_SERVER ?>/rb-script/modules/mod_emocion/img/delete.png" alt="Borrar" /></a>'+
      '</div>'+
    '</div>');
    $('.link input').focus();
  });

  $('#links').on("click", ".linkdelete", function (event) {
    event.preventDefault();
      $(this).closest(".link").remove();
      $('.link input').focus();
  });
	// E N V I A N D O  D A T O S
	$('#emo_formup').submit(function(event){
		// Validaciones
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

		$.ajax({
			url: "<?= G_SERVER ?>/rb-script/modules/mod_emocion/sendlink_mailer.php",
			data: $( this ).serialize(),
			method: 'post'
		}).done(function(data) {
			console.log(data);
			if(data=="1"){
				$('.emo_formup').hide();
				$('#message_general').html("<div style='text-align:center;padding:10px 0'><img src='<?= G_SERVER ?>/rb-script/modules/rb-uploadimg2/send.png' alt='send'></div><h3 style='text-align:center;padding:8px 0'>Los archivos fueron subidos y enviados a los destinatarios especificados.</h3>")
				setTimeout(function(){
					window.location.href = '<?= G_SERVER ?>/rb-admin/module.php?pag=emo_sendmailfile';
				}, 1500);
			}else{
				$('#message_general').html(data);
			}
		});
	});
});
</script>
