<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH."global.php";
$urlreload=G_SERVER.'rb-admin/module.php?pag=customers';

if( isset($_GET['id']) ){
  $id=$_GET['id'];
  $q = $objDataBase->Ejecutar("SELECT * FROM crm_customers WHERE id=$id");
  $row = $q->fetch_assoc();
}else{
  $id = 0;
}
?>
<form id="frmcustomer" class="form" style="max-width:400px">
	<input type="hidden" name="id" value="<?= $id ?>" required />
  <label>
    Nombres *
    <input type="text" name="nombres" required value="<?php if(isset($row)) echo $row['nombres'] ?>" />
  </label>
  <label>
    Apellidos *
    <input type="text" name="apellidos" required value="<?php if(isset($row)) echo $row['apellidos'] ?>" />
  </label>
  <label>
    Telefono *
    <input type="tel" name="telefono" required value="<?php if(isset($row)) echo $row['telefono'] ?>" />
  </label>
  <label>
    Correo
    <input type="email" name="correo" value="<?php if(isset($row)) echo $row['correo'] ?>" />
  </label>
  <label>
    Direccion
    <input type="text" name="direccion" value="<?php if(isset($row)) echo $row['direccion'] ?>" />
  </label>
  <label>Redes sociales</label>
  <label>
    <input type="email" name="face" placeholder="Facebook" value="<?php if(isset($row)) echo $row['face'] ?>" />
  </label>
  <label>
    <input type="email" name="insta" placeholder="Instagram" value="<?php if(isset($row)) echo $row['insta'] ?>" />
  </label>
  <label>
    <input type="email" name="twitter" placeholder="Twitter" value="<?php if(isset($row)) echo $row['twitter'] ?>" />
  </label>
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
    $('#frmcustomer').submit(function(event){
      event.preventDefault();
  		//tinyMCE.triggerSave(); //save first tinymce en textarea
  		$.ajax({
  			method: "post",
  			url: "<?= G_SERVER ?>rb-script/modules/crm/save.customer.php",
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
