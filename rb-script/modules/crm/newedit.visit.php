<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH."global.php";
$urlreload=G_SERVER.'rb-admin/module.php?pag=visits';

if( isset($_GET['id']) ){
  $id=$_GET['id'];
  $q = $objDataBase->Ejecutar("SELECT * FROM crm_visits WHERE id=$id");
  $row = $q->fetch_assoc();
}else{
  $id = 0;
}
?>
<form id="frmcustomer" class="form" style="max-width:400px">
    <input type="hidden" name="id" value="<?= $id ?>" required />
    <label>
        Cliente:
        <select name="customer_id">
            <option value=0>[Seleccionar]</option>
            <?php
            $qc = $objDataBase->Ejecutar("SELECT * FROM crm_customers");
            while($customer = $qc->fetch_assoc()):
                ?>
                <option <?php if(isset($row) && $row['customer_id']== $customer['id']) echo "selected" ?> value="<?= $customer['id'] ?>"><?= $customer['nombres'] ?> <?= $customer['apellidos'] ?></option>
                <?php
            endwhile;
            ?>
        </select>
    </label>
    <label>
        Fecha de visita / atención
        <input type="date" name="fecha_visita" placeholder="Apellidos" required value="<?php if(isset($row)) echo rb_sqldate_to($row['fecha_visita'], 'Y-m-d') ?>" />
    </label>
    <label>
        Observaciones
        <textarea name="observaciones" placeholder="Observaciones"><?php if(isset($row)) echo $row['observaciones'] ?></textarea>
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
  			url: "<?= G_SERVER ?>rb-script/modules/crm/save.visit.php",
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
