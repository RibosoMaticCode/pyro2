<div class="cols-container products">
        <?php
        foreach($products as $product){
        ?>
        <div class="cols-3-md">
            <div class="product-item">
              
                <?php if($product['descuento']>0): ?>
                <div class="product-discount">-<?= $product['descuento'] ?>%</div>
                <?php endif ?>
                <a href="<?= $product['url'] ?>">
                <div class="product-item-cover-img" style="background-image:url('<?= $product['image_url'] ?>')">
                </div>
                </a>
                <div class="product-item-desc">
                    <h3><a href="<?= $product['url'] ?>"><?= $product['nombre'] ?></a></h3>
                    <?php
                    $response = product_have_variants($product['id']);
                    if( $response['result'] ){
                      ?>
                      <div class="product-item-price">
                        <!--<span class="product-item-before">Desde / Hasta</span>-->
                        <span class="product-item-price-now"><?= G_COIN ?> 
                        <?php if($response['price_min'] > 0): ?>
                        <?= number_format($response['price_min'], 2) ?> - 
                        <?php endif ?>
                        <?= number_format($response['price_max'], 2) ?></span>
                      </div>
                      <?php
                    }else{
                      ?>
                      <div class="product-item-price">
                        <?php if($product['precio_oferta']>0): ?>
                          <!--<span class="product-item-price-before">Normal: <?= G_COIN ?> <?= number_format($product['precio'], 2) ?></span>-->
                          <span class="product-item-price-now"><?= G_COIN ?> <?= number_format($product['precio_oferta'], 2) ?></span>
                        <?php else: ?>
                          <!--<span class="product-item-price-before"></span>-->
                          <span class="product-item-price-now"><?= G_COIN ?> <?= number_format($product['precio'], 2) ?></span>
                        <?php endif ?>
                      </div>
                      <?php
                    }
                    ?>
                    <div class="product-item-btns">
                      <a href="<?= $product['url_archivo'] ?>">Leer ahora</a>
                      <a href="<?= $product['url'] ?>">Ver detalles</a>
                    </div>
                    
                </div>
              
            </div>
        </div>
        <?php
        }
        ?>
    </div>