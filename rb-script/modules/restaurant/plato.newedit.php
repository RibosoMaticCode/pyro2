<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';

/* parametros inciales */
$file_prefix = "plato";
$table_name = "rest_plato";
$key = "rest_plato";
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
    Nombre
    <input type="text" name="nombre" required value="<?php if(isset($row)) echo $row['nombre'] ?>" />
  </label>
  <label>
    Categoria
    <input type="text" name="categoria" required value="<?php if(isset($row)) echo $row['categoria'] ?>" />
  </label>
  <label>
    Precio
    <input type="tel" name="precio" required value="<?php if(isset($row)) echo $row['precio'] ?>" />
  </label>
  <label>
    Foto
		<script>
			$(document).ready(function() {
				$(".foto_plato").filexplorer({
					inputHideValue: "<?php if(isset($row)) echo $row['foto_id']; else echo "0"; ?>"
				});
			});
		</script>
    <input type="text" readonly name="foto_id" class="foto_plato" value="<?php $photos = rb_get_photo_from_id( isset($row) ? $row['foto_id'] : 0 ); echo $photos['src']; ?>" />
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
