<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname( dirname( dirname( dirname(__FILE__) ) ) ). '/' );

require_once ABSPATH.'global.php';
require_once ABSPATH.'rb-script/class/rb-database.class.php';
?>
<script>
	$( "#close" ).click(function( event ) {
		event.preventDefault();
		$('#img_loading').hide();
		$(".bg-opacity").hide();
		$(".explorer").hide();
   	$(".explorer").empty();
	});
</script>
<div class="explorer-header">
	<h3>Imagen seleccionada</h3>
	<a id="close" href="#">×</a>
</div>
<div class="explorer-body">
  <?php
  $q = $objDataBase->Ejecutar("SELECT src, type FROM ".G_PREFIX."files WHERE id=".$_GET['file_id']);
  $file = $q->fetch_assoc();
  if( substr($file['type'], 0, 5) != "image"){
	  ?>
	  <div class="file_msj">
	  	<p>Vista no disponible</p>
	  	<a target="_blank" href="<?= G_SERVER ?>/rb-media/gallery/<?= $file['src']?>">Clic aqui para ver archivo</a>
  		</div>
	  <?php
  }else{
	  ?>
	  <img class="preview" src="<?= G_SERVER ?>/rb-media/gallery/<?= $file['src']?>" alt="previa" />
	  <?php
  }
  ?>
</div>
