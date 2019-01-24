<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'rb-script/class/rb-database.class.php';
require_once ABSPATH.'global.php';

$product_id = $_GET['product_id'];
$qp = $objDataBase->Ejecutar("SELECT * FROM plm_products WHERE id=".$product_id);
$product = $qp->fetch_assoc();
?>
<script>
$('#next1').click(function(event){
    var seguir = true;
    $('#s1').find('input').each(function(){
        if($(this).prop('required') && $(this).val()===""){
            alert('Falta ingresar el valor de '+$(this).prop('placeholder'));
            seguir = false;
        }
    });
    if(seguir){
        $('#s1').hide();
        $('#s2').show();
    }
});
$('#next2').click(function(event){
    var seguir2 = true;
    $('#s2').find('input').each(function(){
        if($(this).prop('required') && $(this).val()===""){
            alert('Falta ingresar el valor de '+$(this).prop('placeholder'));
            seguir2 = false;
        }
    });
    console.log(seguir2);
    if(seguir2){
        $('#s2').hide();
        $('#s3').show();
    }
});
$('#ciudad').change(function(event){
    console.log(  $(this).children("option:selected").val() );
    switch(  $(this).children("option:selected").val() ){
        case 'Trujillo':
            $('.delivery').html("Gratis");
            break;
        case 'Otra':
            $('.delivery').html("Acordar con la tienda");
            break;
    }
});
// Send mail
$('#product_request_form').submit(function(event){
    event.preventDefault();
  	$.ajax({
  		method: "post",
  		url: "<?= G_DIR_MODULES_URL ?>plm/product.request.mail.php",
  		data: $( this ).serialize()
  	})
  	.done(function( data ) {
  		if(data.result){
            alert(data.msg);
			$.fancybox.close();
  	  	}else{
  			alert(data.msg);
  	  	}
  	});
});
</script>
<form id="product_request_form" class="form" style="width:100%;">
    <div class="sections">
        <input type="hidden" name="id" value="<?= $product['id'] ?>" />
				<input type="hidden" name="producto_nombre" value="<?= $product['nombre'] ?>" />
        <input type="hidden" name="url" value="<?= $product['nombre_key'] ?>" />
        <input type="hidden" name="precio" value="<?= $product['precio_oferta'] ?>" />
        <div id="s1" class="section">
            <h3>Datos del comprador</h3>
            <label>
                <input name="nombres" type="text" placeholder="Nombre y apellidos *" required />
            </label>
            <label>
                <input name="dni" type="text" placeholder="DNI *" required />
            </label>
            <label>
                <input name="email" type="email" placeholder="Email *" required />
            </label>
            <label>
                <input name="celular" type="tel" placeholder="Celular *" required />
            </label>
            <a id="next1" class="next" href="#">Siguiente</a>
        </div>
        <div id="s2" class="section">
            <h3>Datos de envio</h3>
            <label>
                <input name="direccion" type="text" placeholder="Direccion de entrega *" required />
            </label>
            <label>
                <select id="ciudad" name="ciudad">
                    <option value="Trujillo">Trujillo</a>
                    <option value="Otra">Otra ciudad</a>
                </select>
            </label>
            <label>
                <input name="referencia" type="text" placeholder="Referencia para llegar" />
            </label>
            <a id="next2" class="next" href="#">Siguiente</a>
        </div>
        <div id="s3" class="section" style="text-align:center">
            <h3>¡Felicidades el producto ya casi es tuyo!</h3>
            <p>
                Costo: S/. <span class="precio"><?= $product['precio_oferta'] ?></span><br />
                Delivery: <span class="delivery">Gratis</span>
            </p>
            <h4>Metodo de pago</h4>
            <p>Deposito a Cuenta BCP: Trama Perú SAC. Soles</p>
            <p>Cta. Cte. BCP 570-2280857-0-32</p>
            <p>CCI. 002-570-002280857032-03</p>
            <p>Envio de Voucher a:</p>
            <p>sales@tramaperu.com <br />
            o a nuestro whatsapp <br />
            964 349 783</p>
            <p>Nos contactaremos con usted<br /> para confirmarle el envio</p>
            <button>Finalizar</button>
        </div>
    </div>
</form>
