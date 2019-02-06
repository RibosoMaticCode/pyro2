<?php rb_header(['header-allpages.php'], false) ?>
<div class="wrap-content">
  <div class="inner-content clear">
    <?php if(isset($CountResult)): ?>
      <h1><?= $CountResult ?> resultados encontrados</h1>
    <?php endif ?>
    <div class="cols-container products">
        <?php
        foreach($products as $product){
        ?>
        <div class="cols-3-md">
          <div class="item_cat">
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
          </div>
        </div>
        <?php
        }
        ?>
    </div>
  </div>
</div>
<?php rb_footer(['footer-allpages.php'], false) ?>
