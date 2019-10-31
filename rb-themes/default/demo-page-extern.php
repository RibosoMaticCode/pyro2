<?php
// Valores de cabecera de la pagina externa
define('rm_title', "Ejemplo de pagina externa | ". G_TITULO);
define('rm_title_page' , "Ejemplo de pagina externa");
define('rm_metadescription' , "Ejemplo de pagina externa");
define('rm_metaauthor' , G_TITULO);

rb_header(['header-allpages.php'], false) ?>
<div class="wrap-content">
  <div class="inner-content clear block-content">
    <p>Puedes añadir paginas externas con el formato de <em>demo-page-extern.php</em> </p>
    <p>Si tienes una plantilla ya diseñada puedes añadir tu plantilla al directorio <em>rb-temas</em>, y editar cada página para que incluya la cabecera y pie de pagina, mediante código.</p>
    <p>Si activas la opción de enlaces amigables, entonces para acceder a tus páginas externas lo harás con este formato: <em>www.misitio.com/nombre-de-la-pagina-externa/</em></p>
    <p>Por ejemplo. Si tu pagina externa se llama: <em>ventas-del-mes.php</em>, para acceder a ella con enlace amigable, seria: <em>www.misitio.com/ventas-del-mes/</em></p>

    <a id="hidden_link" href="<?= G_SERVER ?>/rb-script/modules/suscripciones/suscrip.frm.frontend.php" class="fancySuscrip fancybox.ajax">Suscripcion</a>
    <script type="text/javascript">
      $(document).ready(function() {
        $("#hidden_link").trigger("click");
      });
    </script>
  </div>
</div>
<?php rb_footer(['footer-allpages.php'], false) ?>
