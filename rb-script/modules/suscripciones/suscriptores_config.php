<section class="seccion">
  <div class="seccion-header">
    <h2>Instrucciones de uso</h2>
  </div>
  <div class="seccion-body">
    <p>Puedes invocar al formulario de suscripcion de diferentes maneras.</p>
    <p><strong>Modo formulario</strong></p>
    <p>Mediante shortcode:</p>
    <pre>[suscripform]</pre>
    <p>Esto muestra un formulario con 2 campos: nombre y correo para que el visitante se registre</p>
    <br />
    <p><strong>Modo obligatorio</strong></p>
    <p>Mediante código:</p>
    <pre>&lt;a id="hidden_link" href="&lt;?= G_SERVER ?&gt;rb-script/modules/suscripciones/suscrip.frm.frontend.php" class="fancySuscrip fancybox.ajax"&gt;Suscripcion&lt;/a&gt;<br />&lt;script type="text/javascript"&gt;<br />$(document).ready(function() {<br />$("#hidden_link").trigger("click");<br />});<br />&lt;/script&gt;</pre>
    <p>Mediante shortcode:</p>
    <pre>[suscripformreq]</pre>
    <p>En ambos casos, carga el formulario de suscripcion cuando se carga la página en cuestión. Esta opción obliga al visitante a suscribirse. Si no desea, redirecciona a la pagina inicial.</p>
  </div>
</section>
<section class="seccion">
  <div class="seccion-header">
    <h2>Configuracion</h2>
  </div>
  <div class="seccion-body">
    <p>Puedes establecer que campos mostrar (en formato JSON). Por defecto son Nombres y Correo</p>
    <form class="form" id="suscriptores_config">
      <label>
        Configurar campos
        <?php
        global $objDataBase;
        $q = $objDataBase->Ejecutar("SELECT * FROM suscriptores_config WHERE opcion='campos'");
        echo $q->num_rows;
        if($q->num_rows > 0) :
          $row = $q->fetch_assoc();
          $campos = $row['valor'];
        else:
          $campos = '{"Nombres":"show", "Correo": "show", "Telefono": "hide"}'; // Por defecto
        endif;
        ?>
        <input type="text" name="campos" value='<?= $campos ?>' />
      </label>
      <button type="submit">Guardar</button>
    </form>
  </div>
</section>
<?php
$urlreload=G_SERVER.'rb-admin/module.php?pag=rb_sus_susc_config';
?>
<script>
// Boton Guardar
$('#suscriptores_config').submit(function(event){
      event.preventDefault();
  		$.ajax({
  			method: "post",
  			url: "<?= G_SERVER ?>rb-script/modules/suscripciones/save.suscriptor.config.php",
  			data: $( this ).serialize()
  		})
  		.done(function( data ) {
  			if(data.resultado){
					$.fancybox.close();
  				notify(data.contenido);
					setTimeout(function(){
	          window.location.href = '<?= $urlreload ?>';
	        }, 1000);
  	  	}else{
  				notify(data.contenido);
  	  	}
  		});
    });
</script>
