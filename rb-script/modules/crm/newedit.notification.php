<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH."global.php";
$urlreload=G_SERVER.'rb-admin/module.php?pag=notifications';
require_once 'funcs.php';

if( isset($_GET['id']) ){
  $id=$_GET['id'];
  $q = $objDataBase->Ejecutar("SELECT * FROM crm_notification WHERE id=$id");
  $row = $q->fetch_assoc();
}else{
  $id = 0;
}
?>
<form id="frmnotification" class="col-padding">
  <div class="form">
	<input type="hidden" name="id" value="<?= $id ?>" required />
  <label>
    Para el cliente
    <select name="customer_id">
      <option value="0">Seleccionar</option>
      <?php
      $qc = $objDataBase->Ejecutar("SELECT * FROM crm_customers");
      while($rowc = $qc->fetch_assoc()){
        ?>
        <option value="<?= $rowc['id'] ?>" <?php if(isset($row) && $row['customer_id']==$rowc['id']) echo "selected" ?>><?= crm_customer_fullname($rowc['id'])?></option>
        <?php
      }
      ?>
    </select>
  </label>
  <label>Mensaje</label>
  </div>
  <textarea rows="25" id="editor1" name="mensaje" class="mceEditor" ><?php if(isset($row)) echo $row['mensaje'] ?></textarea>
  <div class="cols-container form">
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
    $('#frmnotification').submit(function(event){
      event.preventDefault();
  		tinyMCE.triggerSave(); //save first tinymce en textarea
  		$.ajax({
  			method: "post",
  			url: "<?= G_SERVER ?>rb-script/modules/crm/save.notification.php",
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
