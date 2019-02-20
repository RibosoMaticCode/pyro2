<?php rb_header(['header-allpages.php'], false) ?>
<div class="wrap-content">
  <div class="inner-content clear">
    <div class="product-nav">
      <a href="<?= G_SERVER ?>">Inicio</a> > <a href="<?= $category['url']?>"><?= $category['nombre']?></a> > <?= rb_fragment_letters($product['nombre'], 40) ?>
    </div>
    <div class="cols-container">
      <div class="cols-9-md">
        <div class="cols-container">
          <div class="cols-5-md"> <!-- photo and gallery -->
            <a class="fancy" data-fancybox-group="visor" href="<?= $photo['file_url'] ?>">
              <!--<img src="<?= $photo['file_url'] ?>" alt="imagen" />-->
              <div class="product-cover-image">
                <img src="<?= $photo['file_url'] ?>" alt="imagen" />
              </div>
            </a>
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
          <div class="cols-7-md"> <!-- price -->
            <div class="product-info">
              <h3><?= $product['nombre'] ?></h3>
              <div class="product-price-info">
                <?php
                if($product['descuento']>0):
                ?>
                <div class="cols-container"> <!-- normal -->
                  <div class="cols-6-md">
                    <strong>Precio normal:</strong>
                  </div>
                  <div class="cols-6-md">
                    <span style="text-decoration:line-through"><?= G_COIN ?> <?= number_format($product['precio'], 2) ?></span>
                  </div>
                </div>
                <?php
                endif;
                ?>
                <div class="cols-container"> <!-- oferta -->
                  <div class="cols-6-md">
                    <strong>Precio final:</strong>
                  </div>
                  <div class="cols-6-md">
                    <?php
                    if($product['descuento']>0):
                    ?>
                    <span class="highlight"><?= G_COIN ?> <?= number_format($product['precio_oferta'], 2) ?></span>
                    <?php
                    else:
                    ?>
                    <span class="highlight"><?= G_COIN ?> <?= number_format($product['precio'], 2) ?></span>
                    <?php
                    endif;
                    ?>
                  </div>
                </div>
                <?php if($product['descuento']>0): ?>
                <div class="cols-container"> <!-- descuento -->
                  <div class="cols-6-md">
                    <strong>Ahorras:</strong>
                  </div>
                  <div class="cols-6-md">
                    <span class="highlight"><?= G_COIN ?> <?= number_format($product['precio']-$product['precio_oferta'], 2) ?></span> (<?= $product['descuento'] ?>%)
                  </div>
                </div>
                <?php endif ?>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="cols-3-md"><!-- calculate total -->
        <div class="product-calculate">
          <form class="frm_cart" method="post" id="frm_cart">
            <input type="hidden" value="<?= $product['id'] ?>" name="product_id">
            <?php
            if($product['precio_oferta']>0):
              $precio_format = number_format($product['precio_oferta'], 2);
              $precio = $product['precio_oferta'];
            else:
              $precio_format = number_format($product['precio'], 2);
              $precio = $product['precio'];
            endif;
            ?>
            <input type="hidden" id="product_price" value="<?= $precio ?>" />
            <?php
            if($product['estado']==1):
            ?>
            <div class="cols-container line-price">
              <div class="cols-5-md">
                <h3>Precio total:</h3>
              </div>
              <div class="cols-7-md">
                <span class="product-total"><?= G_COIN ?> <span id="product_total"><?= $precio_format ?></span></span>
              </div>
            </div>
            <div class="cols-container line-quantity">
              <div class="cols-5-md">
                <h3>Cantidad:</h3>
              </div>
              <div class="cols-7-md">
                <a id="btnmenos" class="cantidad-botton" href="#">-</a>
                <input type="text" id="txtCantidad" value="1" name="cantidad">
                <a id="btnmas" class="cantidad-botton" href="#">+</a>
              </div>
            </div>
            <button class="btnaddcart" type="button"><i class="fas fa-shopping-cart"></i> Añadir al carrito</button>
            <?php else: ?>
            <h3>Agotado</h3>
            <?php endif ?>
            <ul class="payment-feat">
              <li><i class="fas fa-globe-americas"></i> Gratis Envío a todo el mundo</li>
              <li><i class="fas fa-check-circle"></i> 100% Garantía de devolución de dinero</li>
              <li><i class="fas fa-lock"></i> 100% Pagos seguros</li>
            </ul>
          </form>
        </div>
      </div>
    </div>
    <div class="product-security-info">
      <img src="<?= G_DIR_MODULES_URL ?>plm/proteccion-comprador.jpg" alt="proteccion al comprador" />
    </div>
    <div class="cols-container">
      <div class="cols-9-md cover-tabs"><!-- descripcion and comments -->
        <div class="product-tabs">
          <a class="selected" href="#">Detalles del producto</a>
        </div>
        <div class="product-description">
          <?= $product['descripcion'] ?>
        </div>
      </div>
      <div class="cols-3-md side-related"><!-- related products -->
        <h4>Productos relacionados</h4>
        <?php
        $products = products_related($product['id'], 3);
        if(!$products){
          echo "No se encontraron relacionados";
        }else{
          foreach ($products as $product) {
            ?>
            <div class="product-item">
              <a href="<?= $product['url'] ?>">
              <?php if($product['descuento']>0): ?>
                <div class="product-discount">-<?= $product['descuento'] ?>%</div>
              <?php endif ?>
              <div class="product-item-cover-img" style="background-image:url('<?= $product['image_url'] ?>')">
              </div>
              <div class="product-item-desc">
                <h3><?= $product['nombre'] ?></h3>
                <div class="product-item-price">
                  <?php if($product['precio_oferta']>0): ?>
                    <span class="product-item-price-before">Normal: <?= G_COIN ?> <?= number_format($product['precio'], 2) ?></span>
                    <span class="product-item-price-now"><?= G_COIN ?> <?= number_format($product['precio_oferta'], 2) ?></span>
                  <?php else: ?>
                    <span class="product-item-price-before"></span>
                    <span class="product-item-price-now"><?= G_COIN ?> <?= number_format($product['precio'], 2) ?></span>
                  <?php endif ?>
                </div>
              </div>
              </a>
            </div>
            <?php
          }
        }
        ?>
      </div>
    </div>
  </div> <!--- inner-content end -->
</div>
<script>
$(document).ready(function() {
  function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
  }

  // Boton Mas
  $('#btnmas').click( function(event){
    event.preventDefault();
    var cant = $('#txtCantidad').val();
    if(cant.length==0) cant = 0;
    cant++;
    $('#txtCantidad').val(cant);
    calcular();
  });

  // Boton Menos
  $('#btnmenos').click( function(event){
    event.preventDefault();
    var cant = $('#txtCantidad').val();
    if(cant>1){
      cant--;
      $('#txtCantidad').val(cant);
    }
    calcular();
  });

  // Cambiar text input
  $('#txtCantidad').keyup(function(event) {
    calcular();
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

  // Funcion calcular totales
  function calcular(){
    var cant = $('#txtCantidad').val();
    var price = $('#product_price').val();
    console.log(cant);
    console.log(price);
    if(cant=="" || cant==0){
      cant = 1;
    }
    $('#product_total').html(numberWithCommas( (cant * price).toFixed(2) ));
  }
});
</script>
<?php rb_footer(['footer-allpages.php'], false) ?>
