<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH."global.php";
require_once ABSPATH."rb-script/class/rb-database.class.php";
$urlreload=G_SERVER.'rb-admin/module.php?pag=rb_sus_susc';
$objDataBase = new DataBase;
$mode = "new";
$suscriptor_id = 0;
if(isset($_GET['id']) && $_GET['id'] > 0):
	$suscriptor_id = $_GET['id'];
	$r = $objDataBase->Ejecutar("SELECT * FROM suscriptores WHERE id=".$suscriptor_id);
	$row = $r->fetch_assoc();
	$mode = "upd";
endif;
?>
<form id="frmcomunica" class="form">
	<input type="hidden" name="mode" value="<?= $mode ?>" required />
	<input type="hidden" name="id" value="<?= $suscriptor_id ?>" required />
	<label>
		DNI:
    <input type="text" name="dni" required value="<?php if(isset($row)) echo $row['dni']; ?>" />
  </label>
  <label>
		Nombres:
    <input type="text" name="nombres" required value="<?php if(isset($row)) echo $row['nombres']; ?>" />
  </label>
	<label>
		Correo:
    <input type="email" name="correo" value="<?php if(isset($row)) echo $row['correo']; ?>" />
  </label>
	<label>
		Telefono:
    <input type="tel" name="telefono" value="<?php if(isset($row)) echo $row['telefono']; ?>" />
  </label>
  <div class="cols-container">
    <div class="cols-6-md cols-content-left">
      <button type="submit" class="button btn-primary">Guardar</button>
    </div>
    <div class="cols-6-md cols-content-right">
      <button type="button" class="button CancelFancyBox">Cancelar</button>
    </div>
  </div>
</form>
<script>
	$(document).ready(function() {
    // Boton Cancelar
    $('.CancelFancyBox').on('click',function(event){
			$.fancybox.close();
		});

    // Boton Guardar
    $('#frmcomunica').submit(function(event){
      event.preventDefault();
  		//tinyMCE.triggerSave(); //save first tinymce en textarea
  		$.ajax({
  			method: "post",
  			url: "<?= G_SERVER ?>rb-script/modules/suscripciones/save.suscriptor.php",
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
  });
</script>
