<?php rb_header(['header-allpages.php'], false) ?>
<div class="wrap-content">
  <div class="inner-content clear">
    <!--<div class="product-nav">
      <a href="<?= G_SERVER ?>">Inicio</a> > <a href="<?= $category['url']?>"><?= $category['nombre']?></a> > <?= rb_fragment_letters($product['nombre'], 40) ?>
    </div>-->
    <div class="cols-container product_page">
      <div class="cols-6-md"> <!-- photo and gallery -->
            <a id="product_image_url" class="fancy" data-fancybox-group="visor" href="<?= $photo['file_url'] ?>">
              <!--<img src="<?= $photo['file_url'] ?>" alt="imagen" />-->
              <div class="product-cover-image">
                <img id="product_image" src="<?= $photo['file_url'] ?>" alt="imagen" />
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
      <div class="cols-6-md"> <!-- price -->
        <div class="product-info">
          <?php
          if($product['nombre_largo']!=""){
            $product_name = $product['nombre_largo'];
          }else{
            $product_name = $product['nombre'];
          }
          ?>
            <h1 class="product_name"><?= $product_name ?></h1>
            <!--<div class="product-link-digital">
              <a href="<?= $product['url_archivo'] ?>">Leer libro</a>
            </div>-->
            <div class="product-description">
              <?= $product['descripcion'] ?>
            </div> 
            <div class="product-price-info">
                <?php
                $have_variants = false;
                if($product['estado']==0){
                  echo "Próximamente";
                }else{
                  // VERIFICAMOS SI HAY VARIANTES
                  $qv = $objDataBase->Ejecutar("SELECT * FROM plm_products_variants WHERE product_id=".$product['id']);

                  if($qv->num_rows > 0){
                    $have_variants = true;
                    // SI HAY VARIANTES DE PRODUCTOS
                    ?>
                    <div class="cover_prices_range">
                      <?php $response = product_have_variants($product['id']) ?>
                      <span class="price_range"><?= G_COIN ?> 
                        <?php if($response['price_min'] > 0): ?>
                        <?= number_format($response['price_min'], 2) ?> - 
                        <?php endif ?>
                        <?= number_format($response['price_max'], 2) ?></span> / unidad
                    </div>
                    <div class="prices">
                      <div class="notice">Seleccione las alternativas disponibles</div>
                    </div>
                    <div class="options_variants">
                    <?php
                    $options = json_decode($product['options_variants'], true);
                    foreach ($options as $key => $value) {
                      ?>
                      <div class="cols-container variants">
                        <div class="cols-3-md">
                          <?= $key ?>
                        </div>
                        <div class="cols-9-md">
                          <?php
                          foreach ($options[$key] as $alternativa => $valor) {
                            ?>
                            <a class="check_available" id="<?= $valor ?>" data-id="<?= $valor ?>" href="#"><?= $valor ?></a>
                            <?php
                          }
                          ?>
                        </div>
                      </div>
                      <?php
                    }
                    ?>
                    </div>
                    <?php
                  }else{
                    // SINO HAY VARIANTES DE PRODUCTOS
                    ?>
                    <div class="prices">
                      <?php
                      if($product['descuento']>0):
                      ?>
                      <div class="cols-container">
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
                      <div class="cols-container">
                        <div class="cols-6-md">
                          <strong>Precio final:</strong>
                        </div>
                        <div class="cols-6-md">
                          <?php
                          if($product['descuento']>0):
                          ?>
                          Precio: <span class="product_currency"><?= G_COIN ?></span> <span class="product_price"><?= number_format($product['precio_oferta'], 2) ?></span>
                          <?php
                          else:
                          ?>
                          Precio: <span class="product_currency"><?= G_COIN ?></span> <span class="product_price"><?= number_format($product['precio'], 2) ?></span>
                          <?php
                          endif;
                          ?>
                        </div>
                      </div>
                      <?php if($product['descuento']>0): ?>
                      <div class="cols-container">
                        <div class="cols-6-md">
                          <strong>Ahorras:</strong>
                        </div>
                        <div class="cols-6-md">
                          <span class="highlight"><?= G_COIN ?> <?= number_format($product['precio']-$product['precio_oferta'], 2) ?></span> (<?= $product['descuento'] ?>%)
                        </div>
                      </div>
                      <?php endif ?>
                    </div>
                    <?php
                  }
                }
                ?>
              </div>
            <!--<div class="product-buttons">
              <ul class="btn_links">
                <?php if($product['formato_fisico']==1): ?>
                  <li><a class="frmSapiensShowFisico" href="#">Físico</a></li>
                <?php endif ?>
                <?php if($product['formato_digital']==1): ?>
                  <li><a class="frmSapiensShowDigital" href="#" style="background: gray!important">Digital</a></li>
                <?php endif ?>
              </ul>
            </div> -->
              
        </div>
        <!-- calculate total -->
        <div class="product-calculate">
          <form class="frm_cart" method="post" id="frm_cart">
            <input type="hidden" value="" id="variant_name" name="variant_name">
            <input type="hidden" value="" id="variant_id" name="variant_id">
            <input type="hidden" value="<?= $product['id'] ?>" name="product_id">
            <?php
            if($have_variants){
              $precio = 0.00;
            }else{
              if($product['precio_oferta']>0):
                $precio_format = number_format($product['precio_oferta'], 2);
                $precio = $product['precio_oferta'];
              else:
                $precio_format = number_format($product['precio'], 2);
                $precio = $product['precio'];
              endif;
            }
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
                <?php if($have_variants){ ?>
                  <span class="product-total"><?= G_COIN ?> <span id="product_total">0.00</span></span>
                <?php }else{ ?>
                  <span class="product-total"><?= G_COIN ?> <span id="product_total"><?= $precio_format ?></span></span>
                <?php } ?>
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
            <button <?php if($have_variants) echo "disabled" ?> class="btnaddcart" type="button"><i class="fas fa-shopping-cart"></i> Añadir al carrito</button>
            <?php else: ?>
            <h3>Próximamente</h3>
            <?php endif ?>
          </form>
        </div>
      </div>
    </div>
  </div> <!--- inner-content end -->
</div>
<?php
$products = products_related($product['id'], 5);
  if($products){
    ?>
    <div class="wrap-content wrap_related">
      <div class="inner-content clear">
        <div class="side-related"><!-- related products -->
            <h4>Productos relacionados</h4>
            <?php
            $products = products_related($product['id'], 6);
            /*if(!$products){
              echo "No se encontraron relacionados";
            }else{*/
              foreach ($products as $product_rel) {
                ?>
                <div class="product-item">
                  <a href="<?= $product_rel['url'] ?>">
                  <?php if($product_rel['descuento']>0): ?>
                    <div class="product-discount">-<?= $product_rel['descuento'] ?>%</div>
                  <?php endif ?>
                  <div class="product-item-cover-img" style="background-image:url('<?= $product_rel['image_url'] ?>')">
                  </div>
                  <div class="product-item-desc">
                    <h3><?= $product_rel['nombre'] ?></h3>
                    
                    <!--<div class="product-item-price">
                      <?php if($product_rel['precio_oferta']>0): ?>
                        <span class="product-item-price-before">Normal: <?= G_COIN ?> <?= number_format($product_rel['precio'], 2) ?></span>
                        <span class="product-item-price-now"><?= G_COIN ?> <?= number_format($product_rel['precio_oferta'], 2) ?></span>
                      <?php else: ?>
                        <span class="product-item-price-before"></span>
                        <span class="product-item-price-now"><?= G_COIN ?> <?= number_format($product_rel['precio'], 2) ?></span>
                      <?php endif ?>
                    </div>-->
                  </div>
                  </a>
                </div>
                <?php
              }//
            ?>
        </div>
      </div> <!--- inner-content end -->
    </div>
    <?php
  }
?>
<script>
$(document).ready(function() {
  function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
  }

  // Check available
  $('.check_available').click( function(event){
    event.preventDefault();
    if($(this).hasClass('isSelected')){
      $(this).removeClass('isSelected');
      //console.log(create_combo_string());
      $('.prices').empty().append('<div class="notice">Seleccione las alternativas disponibles</div>');
      $('.cover_prices_range').show();
      $('#product_total').empty().append('0.00');
      $('#product_price').val('0.00');
      $('.btnaddcart').attr('disabled',true);
      return false;
    }
    var cover = $(this).closest('.variants');
    cover.find('.check_available').removeClass('isSelected');
    $(this).addClass('isSelected');
    var combo_string = create_combo_string();
    $('#variant_name').val(combo_string);
    //console.log(create_combo_string());

    if(!combo_string==""){
      $.ajax({
        method: "get",
        url: "<?= G_DIR_MODULES_URL ?>plm/product.front.variants.price.php?combo="+combo_string+"&product_id=<?= $product['id'] ?>"
      })
      .done(function( data ) {
        //console.log(data);
        if(data.result){
          if(data.state==0){
            $('.prices').empty().append('<div class="notice"><h2>Próximamente</h2></div>');
            $('.cover_prices_range').show();
            $('#product_total').empty().append('0.00');
            $('#product_price').val('0.00');
            $('.btnaddcart').attr('disabled',true);
          }else{
            $('.cover_prices_range').hide();
            $('.btnaddcart').attr('disabled',false);
            $('.prices').empty().append(data.html);
            $('#product_image_url').attr('href', data.image_url);
            $('#product_image').attr('src', data.image_url);
            if(data.discount>0){
              $('#product_price').val(data.price_discount);
              $('#product_total').empty().append(data.price_discount);
            }else{
              $('#product_price').val(data.price);
              $('#product_total').empty().append(data.price);
            }
            $('#txtCantidad').val('1');
            $('#variant_id').val(data.variant_id);
          }
        }
        if(data.result==false){
          $('.prices').empty().append('<div class="notice">Seleccione las alternativas disponibles</div>');
          $('.cover_prices_range').show();
          $('#product_total').empty().append('0.00');
          $('#product_price').val('0.00');
          $('.btnaddcart').attr('disabled',true);
        }
      });
    }
    if(combo_string==""){
      $('.prices').empty().append('<div class="notice">Seleccione las alternativas disponibles</div>');
      $('.cover_prices_range').show();
      $('#product_total').empty().append('0.00');
      $('#product_price').val('0.00');
      $('.btnaddcart').attr('disabled',true);
    }
  });

  function create_combo_string(){
    var separator = "";
    var combo = "";
    $(".options_variants .variants").each(function(index, element) {
      var option = $(this).find(".isSelected").text();
      if(!option==""){
        combo = combo + separator + option;
        separator = " | ";
      }
    });
    // Buscar en la base de datos
    return combo.trim();
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
        if($('.plm_cart_count').length>0){
          $('.plm_cart_count').html(data.cant_new);
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

  var img_ids = [];
  // Save review
  $('#review_form').submit( function(event){
    event.preventDefault();
    product_url = $('input[name=product_url]').val();
    // Recorrer la lista y capturar los ids

    $("#preview-imgs li").each(function(){
      img_ids.push( $(this).attr('data-id') );
    });
    console.log(img_ids);
    $('input[name=img_ids]').val(img_ids);

    $.ajax({
      method: "post",
      url: "<?= G_DIR_MODULES_URL ?>plm/review.save.php",
      data: $( '#review_form' ).serialize()
    })
    .done(function( data ) {
      if(data.resultado){
        alert("Comentario añadido");
        setTimeout(function(){
  				window.location.href = product_url;
  			}, 500);
      }else{
        alert(data.contenido);
      }
    });
  });

  // Remove imagen in form
  $( "#preview-imgs" ).on( "click", ".remove-img", function(event) {
    event.preventDefault();
    var photo_id = $(this).closest('li').attr('data-id');
    $.ajax({
      method: "get",
      url: "<?= G_SERVER ?>rb-admin/core/files/file-del.php?id="+photo_id
    })
    .done(function( data ) {
      if(data.result){
        $('#previmg_'+photo_id).fadeOut().remove();
      }else{
        alert(data.message);
      }
    });
  });
});
</script>
<?php rb_footer(['footer-allpages.php'], false) ?>
