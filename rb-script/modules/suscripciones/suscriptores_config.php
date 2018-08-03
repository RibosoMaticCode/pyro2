<section class="seccion">
  <div class="seccion-header">
    Instrucciones de uso
  </div>
  <div class="seccion-body">
    <p>Puedes invocar al formulario de suscripcion de diferentes maneras.</p>
    <p><strong>Modo obligatorio</strong></p>
    <p>Mediante código:</p>
    <pre>&lt;a id="hidden_link" href="&lt;?= G_SERVER ?&gt;/rb-script/modules/suscripciones/suscrip.frm.frontend.php" class="fancySuscrip fancybox.ajax"&gt;Suscripcion&lt;/a&gt;<br />&lt;script type="text/javascript"&gt;<br />$(document).ready(function() {<br />$("#hidden_link").trigger("click");<br />});<br />&lt;/script&gt;</pre>
    <p>Mediante shortcode:</p>
    <pre>[suscripform]</pre>
    <p>En ambos casos, carga el formulario de suscripcion cuando se carga la página en cuestión. Esta opción obliga al visitante a suscribirse. Si no desea, redirecciona a la pagina inicial.</p>
  </div>
</section>
