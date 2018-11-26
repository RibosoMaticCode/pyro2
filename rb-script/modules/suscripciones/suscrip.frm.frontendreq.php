<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';
?>
<form id="frm_suscrip" class="form_sus">
	<p>Escribe tu nombre y correo. Si ya te suscribiste antes, solo vuelve a colocarlos para continuar</p>
	<input type="hidden" name="id" value="0" />
  <input type="text" name="nombres" placeholder="Nombres" required />
  <input type="text" name="correo" placeholder="Email" required />
	<div class="cols-container">
		<div class="cols-6-md form_sus_left">
			<button type="submit">Enviar</button>
		</div>
		<div class="cols-6-md form_sus_right">
			<button class="btnCancel">Cancelar</button>
		</div>
	</div>
</form>
<script>
$(document).ready(function() {
	$(".btnCancel").click(function(event){
			location.href = "<?= G_SERVER ?>";
	});

  $("#frm_suscrip").submit(function( event ){
    event.preventDefault();

    $.ajax({
      method: "post",
      url: "<?= G_SERVER ?>/rb-script/modules/suscripciones/save.suscriptor.php",
      data: $( this ).serialize()
    })
    .done(function( data ) {
      if(data.resultado){
        $.fancybox.close();
        alert(data.contenido);
      }else{
				if(data.continue){
					alert("Ya estas suscrito. Puedes continuar");
					$.fancybox.close();
				}
      }
    });
  });
});
</script>
