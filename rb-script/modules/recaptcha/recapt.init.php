<?php
$sitekey = rb_get_values_options('sitekey');
$secretkey = rb_get_values_options('secretkey');
if($sitekey==""){
  $sitekeydemo = "site-key";
}else{
  $sitekeydemo = $sitekey;
}
?>
<div class="cols-container">
  <div class="cols-6-md">
    <section class="seccion">
      <div class="seccion-body">
        <h2>Configuración</h2>
        <form class="form" id="frmConfigCaptcha">
          <label>
            Clave del sitio
            <input type="text" name="sitekey" value="<?= $sitekey ?>" required />
          </label>
          <label>
            Clave secreta
            <input type="text" name="secretkey" value="<?= $secretkey ?>" required />
          </label>
          <button type="submit">Guardar</button>
        </form>
      </div>
    </section>
  </div>
  <div class="cols-6-md">
    <section class="seccion">
      <div class="seccion-body">
        <h2>Modo de uso</h2>
        <p>Copia y pegar este codigo, dentro de tu formulario</p>
        <pre>&lt;div class="g-recaptcha" data-sitekey="<?= $sitekeydemo ?>" data-callback="enableBtn"&gt; &lt;/div&gt;
        </pre>
        <p>Al boton que realiza el envio puedes añadirle <code>id="btnSend"</code>, para que no se active hasta que el captcha responda valido. Deberia quedar asi en tu html</p>
        <pre>&lt;button id="btnSend" type="submit"&gt;Enviar&lt;/button&gt;</pre>
      </div>
    </section>
  </div>
</div>
<script>
$(document).ready(function() {
	$('#frmConfigCaptcha').submit(function (event){
		event.preventDefault();
		$.ajax({
			method: "post",
			url: "<?= G_SERVER ?>/rb-script/modules/recaptcha/recapt.saveconfig.php",
			data: $( this ).serialize()
		})
		.done(function( data ) {
			if(data.result){
				notify(data.contenido);
        notify(data.contenido);
				setTimeout(function(){
					window.location.href = '<?= G_SERVER ?>/rb-admin/module.php?pag=recaptcha_google';
				}, 800);
	  	}else{
				notify(data.contenido);
	  	}
		});
	});
})
</script>
