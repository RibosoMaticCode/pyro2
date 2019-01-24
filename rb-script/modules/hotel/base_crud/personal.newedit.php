<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';

/* parametros inciales */
$file_prefix = "personal";
$table_name = "rest_personal";
$key = "rest_personal";
$module_dir = "restaurant";
$save_path = G_DIR_MODULES_URL.$module_dir."/".$file_prefix.".save.php";
$urlreload=G_SERVER.'/rb-admin/module.php?pag='.$key;

/* start */
if( isset($_GET['id']) ){
  $id=$_GET['id'];
  $q = $objDataBase->Ejecutar("SELECT * FROM $table_name WHERE id=$id");
  $row = $q->fetch_assoc();
}else{
  $id = 0;
}
?>
<form id="frmNewEdit" class="form" style="max-width:400px">
	<input type="hidden" name="id" value="<?= $id ?>" required />
	<!-- campos inicio -->
  <label>
    Nombres
    <input type="text" name="nombres" required value="<?php if(isset($row)) echo $row['nombres'] ?>" />
  </label>
  <label>
    Apellidos
    <input type="text" name="apellidos" required value="<?php if(isset($row)) echo $row['apellidos'] ?>" />
  </label>
  <label>
    Telefono
    <input type="tel" name="telefono" required value="<?php if(isset($row)) echo $row['telefono'] ?>" />
  </label>
  <label>
    Correo
    <input type="email" name="correo" required value="<?php if(isset($row)) echo $row['correo'] ?>" />
  </label>
  <label>
    Foto
    <input type="text" name="foto_id" value="<?php if(isset($row)) echo $row['foto_id'] ?>" />
  </label>
	<!-- campos final -->
  <div class="cols-container">
    <div class="cols-6-md cols-content-left">
      <button type="submit">Guardar</button>
    </div>
    <div class="cols-6-md cols-content-right">
      <button type="button" class="CancelFancyBox">Cancelar</button>
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
    $('#frmNewEdit').submit(function(event){
      event.preventDefault();
  		//tinyMCE.triggerSave(); //save first tinymce en textarea
  		$.ajax({
  			method: "post",
  			url: "<?= $save_path ?>",
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
