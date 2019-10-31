<?php
// Valores de cabecera de la pagina externa
define('rm_title', "Ejemplo de pagina externa | ". G_TITULO);
define('rm_title_page' , "Ejemplo de pagina externa");
define('rm_metadescription' , "Ejemplo de pagina externa");
define('rm_metaauthor' , G_TITULO);

rb_header(['header-allpages.php'], false) ?>
<div class="wrap-content"><?php rb_header(array('header-all.php')) ?>
  <div class="inner-content clear block-content">
    <h2>Descarga de archivo</h2>
    <a href="<?= G_SERVER ?>/rb-script/download.php?file=ITINERARIO_RUTAS.docx">Archivo importante</a>
  </div>
</div>
<?php rb_footer(['footer-allpages.php'], false) ?>
