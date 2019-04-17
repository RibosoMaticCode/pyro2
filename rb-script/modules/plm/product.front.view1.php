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
                // VERIFICAMOS SI HAY VARIANTES
                $qv = $objDataBase->Ejecutar("SELECT * FROM plm_products_variants WHERE product_id=".$product['id']);
                if($qv->num_rows > 0){
                  // SI HAY VARIANTES DE PRODUCTOS
                  ?>
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
                  <?php
                }
                ?>
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
          <a href="#review_list">Reseñas</a>
        </div>
        <div class="product-description">
          <?= $product['descripcion'] ?>
        </div>
        <!--<div class="product-tabs">
          <a class="selected" href="#">Reseñas</a>
        </div>-->
        <div id="review_list" class="product-review-list">
          <?php
          $comments = review_list($product['id']);
          if(count($comments)>0){
            ?>
            <ul class="product-review-detail">
              <li class="review-detail-headers">
                <div class="cols-container">
                  <div class="cols-3-md user-nickname">
                    Comprador
                  </div>
                  <div class="cols-9-md user-review">
                    Reseña
                  </div>
                </div>
              </li>
            <?php
            foreach ($comments as $comment) {
              $user = rb_get_user_info($comment['user_id']);
              ?>
              <li>
                <div class="cols-container">
                  <div class="cols-3-md review-user">
                    <img src="<?= $user['url_img']?>" alt="user icon" />
                    <span class="review-nickname">
                      <?= $user['nickname'] ?>
                    </span>
                  </div>
                  <div class="cols-9-md review-detail">
                    <span class="review-date"><?= rb_sqldate_to($comment['date_register'],'d') ?> de <?= rb_mes_nombre(rb_sqldate_to($comment['date_register'],'m')) ?>, <?= rb_sqldate_to($comment['date_register'],'Y H:i') ?></span>
                    <div class="review-comment"><strong><?= $comment['title'] ?></strong> <?= $comment['comment'] ?></div>
                    <div class="review-imgs">
                    <?php
                    if($comment['img_ids']!=""):
                      $img_ids = explode(",", $comment['img_ids']);
                      foreach ($img_ids as $img_id) {
                        $photo = rb_get_photo_details_from_id($img_id);
                        ?>
                        <a class="fancy" data-fancybox-group="gallery_<?= $comment['id']?>" href="<?= $photo['file_url']?>"><img src="<?= $photo['thumb_url'] ?>" alt="thumb" /></a>
                        <?php
                      }
                    endif;
                    ?>
                    </div>
                    <span class="review-score"><?= $comment['score'] ?> <i class="fas fa-star"></i></span>
                  </div>
                </div>
              </li>
              <?php
            }
            ?>
            </ul>
          <?php
          }
          ?>
        </div>
        <?php
        if(G_ACCESOUSUARIO){
          ?>
          <div id="review-form" class="product-review-form">
            <h3>Escribe tu reseña</h3>
            <form id="review_form" class="form">
              <input type="hidden" name="img_ids" value="" />
              <input type="hidden" name="comment_id" value="0" />
              <input type="hidden" name="product_url" value="<?= $product['url'] ?>" />
              <input type="hidden" name="product_review_id" value="<?= $product['id'] ?>" />
              <label>Califica (requerido)</label>
                <ul class="review-core-list">
                  <li>
                    <input id="score1" type="radio" name="review_score" value="1" required /><label title="No me gustó" class="score1" for="score1"><i class="fas fa-star"></i></label>
                  </li>
                  <li>
                    <input id="score2" type="radio" name="review_score" value="2" /><label title="Regular" class="score2" for="score2"><i class="fas fa-star"></i></label>
                  </li>
                  <li>
                    <input id="score3" type="radio" name="review_score" value="3" /><label title="Está bien" class="score3" for="score3"><i class="fas fa-star"></i></label>
                  </li>
                  <li>
                    <input id="score4" type="radio" name="review_score" value="4" /><label title="Me gustó" class="score4" for="score4"><i class="fas fa-star"></i></label>
                  </li>
                  <li>
                    <input id="score5" type="radio" name="review_score" value="5" /><label title="Me encantó" class="score5" for="score5"><i class="fas fa-star"></i></label>
                  </li>
                </ul>
              <label>Título (opcional)
                <input type="text" name="review_title" />
              </label>
              <label>Comentario (requerido)
                <textarea name="review_comment" required rows="6"></textarea>
              </label>
            </form>
            <?php
              include_once 'plugin.upload.php';
            ?>
            <div class="cover-preview-imgs">
              <ul id="preview-imgs">
              </ul>
            </div>
            <div class="form">
              <button form="review_form" type="submit">Publicar</button>
            </div>
          </div>
          <?php
        }else{
          ?>
          <div class="review-login-before">
            <h4>Escribe tu reseña</h4>
            <a href="<?= G_SERVER ?>/login.php?redirect=<?= urlencode($product['url']) ?>#review-form">Iniciar sesion</a>
          </div>
          <?php
        }
        ?>
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

  // Check available
  $('.check_available').click( function(event){
    event.preventDefault();
    if($(this).hasClass('isSelected')){
      $(this).removeClass('isSelected');
      console.log(create_combo_string());
      return false;
    }
    var cover = $(this).closest('.variants');
    cover.find('.check_available').removeClass('isSelected');
    $(this).addClass('isSelected');
    var combo_string = create_combo_string();
    console.log(create_combo_string());

    if(!combo_string==""){
      $.ajax({
        method: "get",
        url: "<?= G_DIR_MODULES_URL ?>plm/product.front.variants.price.php?combo="+combo_string
      })
      .done(function( data ) {
        console.log(data);
      });
    }
    /*
    if($(this).hasClass('isDisabled')){
      return false;
    }
    $('.check_available').removeClass('isSelected isDisabled');
    $(this).addClass('isSelected');
    var id = $(this).attr('data-id');
    //console.log(id);
    event.preventDefault();
    $.ajax({
      method: "get",
      url: "<?= G_DIR_MODULES_URL ?>plm/front.end.verify.options.php?option="+id+"&product_id=<?= $product['id']?>"
    })
    .done(function( data ) {
      var size = Object.keys(data['elements_hidden']).length;
      for (var i = 0; i < size; i++) {
        console.log(data.elements_hidden[i]);
        $('#'+data.elements_hidden[i]).addClass('isDisabled');
      }
    });*/
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
      url: "<?= G_SERVER ?>/rb-admin/core/files/file-del.php?id="+photo_id
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
