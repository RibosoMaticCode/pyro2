<?php rb_header(['header-allpages.php'], false) ?>
<div class="wrap-content">
  <div class="inner-content clear">
    <div class="cols-container product">
        <div class="cols-6-md product-image">
            <a class="fancy" data-fancybox-group="visor" href="<?= $photo['file_url'] ?>"><img src="<?= $photo['file_url'] ?>" alt="imagen" /></a>
            <?php
            if($product['galeria_id']>0){
                $fotos = rb_get_images_from_gallery($product['galeria_id']);
                foreach($fotos as $foto):
                    ?>
                    <a style="display:none" class="fancy" data-fancybox-group="visor" href="<?= $foto['url_max'] ?>">more</a>
                    <?php
                endforeach;
            }
            ?>
        </div>
        <div class="cols-6-md product-details">
            <h1><?= $product['nombre'] ?></h1>
            <div class="product-description">
                <?= $product['descripcion'] ?>
            </div>
            <?php if($product['precio_oferta']>0): ?>
              <div class="product-price-now">
                  <?= G_COIN ?> <?= number_format($product['precio_oferta'], 2) ?>
              </div>
              <span class="product-item-price-before">Antes: <?= G_COIN ?> <?= number_format($product['precio'], 2) ?></span>
            <?php else: ?>
              <div class="product-price-now">
                  <?= G_COIN ?> <?= number_format($product['precio'], 2) ?>
              </div>
            <?php endif ?>
            <div class="product-send">
                <?= $product['tipo_envio'] ?>
            </div>
            <form class="frm_cart" method="post" id="frm_cart">
              <input type="hidden" value="" id="variant_name" name="variant_name">
              <input type="hidden" value="" id="variant_id" name="variant_id">
              <input type="hidden" value="<?= $product['id'] ?>" name="product_id">
              <?php
              if($product['estado']==1):
              ?>
              <div class="cols-container block-cant">
                <div class="cols-7-md">
                  <p>
                    <span><a id="btnmas" class="cantidad-botton" href="#">+</a><input type="number" min="1" max="999" id="txtCantidad" value="1" name="cantidad">

											<a id="btnmenos" class="cantidad-botton" href="#">-</a>
                    </span>
                    <script>
                    $(document).ready(function() {
                      // Boton Mas
                      $('#btnmas').click( function(event){
                        event.preventDefault();
                        var cant = $('#txtCantidad').val();
                        if(cant.length==0) cant = 0;
                        cant++;
                        $('#txtCantidad').val(cant);
                      });
                      // Boton Menos
                      $('#btnmenos').click( function(event){
                        event.preventDefault();
                        var cant = $('#txtCantidad').val();
                        if(cant>0){
                          cant--;
                          $('#txtCantidad').val(cant);
                        }
                      });
                      // Boton añadir
                      $('.btnaddcart').click( function(event){
                        event.preventDefault();
                        $.ajax({
                    			method: "post",
                    			url: "<?= G_DIR_MODULES_URL ?>plm/cart.add.php",
                    			data: $( '#frm_cart' ).serialize()
                    		})
                    		.done(function( data ) {
                    			if(data.resultado){
                            alert(data.contenido);
                            // Actualizar contador de productos en carrito
                            if($('#cart_count').length>0){
                              $('#cart_count').html(data.cant_new);
                            }
                    	  	}else{
                    				alert(data.contenido);
                    	  	}
                    		});
                      });
                    });
                    </script>
									</p>
                </div>
                <div class="cols-5-md cantidad-boton">
                  <button class="btnaddcart" type="button">Añadir al carrito</button>
                </div>
							</div>
              <?php else: ?>
              <h3>Agotado</h3>
              <?php endif ?>
						</form>
        <p class="clear" style="text-align:right">
            <a href="<?= G_SERVER ?>products/" class="back-catalogue">Regresar al catálogo</a>
        </p>
    </div>
  </div>
</div>
<?php rb_footer(['footer-allpages.php'], false) ?>
