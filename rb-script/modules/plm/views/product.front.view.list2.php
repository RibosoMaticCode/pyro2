<?php rb_header(['header-allpages.php'], false) ?>
<div class="wrap-content">
  <div class="inner-content clear">
    <div class="products-category-title">
      <?php if(isset($CountResult)): ?>
        <h1><?= $CountResult ?> resultados encontrados</h1>
      <?php endif ?>
      <?php if(isset($category_info)): ?>
        <h1><?= $category_info['nombre'] ?></h1>
      <?php endif ?>
    </div>
    <div class="category-pagination">
			<ul>
        <li<?php if($CurrentPage==1) echo " class='page-disabled'" ?>>
					<a href="<?= url_page($term, 1, $type) ?>">«</a>
				</li>
				<li<?php if($PrevPage==0) echo " class='page-disabled'" ?>>
					<a href="<?= url_page($term, $PrevPage, $type) ?>">‹</a>
				</li>
				<?php
				for ($i = 1; $i <= $TotalPage; $i++):
				?>
				<li>
					<a <?php if($CurrentPage==$i) echo " class='page-resalt'" ?>href="<?= url_page($term, $i, $type) ?>"><?= $i ?></a>
				</li>
				<?php
				endfor;
				?>
				<li<?php if($NextPage==0) echo " class='page-disabled'" ?>>
					<a href="<?= url_page($term, $NextPage, $type) ?>">›</a>
				</li>
				<li<?php if($LastPage==0) echo " class='page-disabled'" ?>>
					<a href="<?= url_page($term, $LastPage, $type) ?>">»</a>
				</li>
			</ul>
		</div>
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
                    <div class="product-item-btns">
                      <a href="<?= $product['url_archivo'] ?>">Leer ahora</a>
                      <a href="<?= $product['url'] ?>">Ver detalles</a>
                    </div>
                    <?php
                    $response = product_have_variants($product['id']);
                    /*if( $response['result'] ){
                      ?>
                      <div class="product-item-price">
                        <span class="product-item-before">Desde / Hasta</span>
                        <span class="product-item-price-now"><?= G_COIN ?> <?= number_format($response['price_min'], 2) ?> - <?= number_format($response['price_max'], 2) ?></span>
                      </div>
                      <?php
                    }else{
                      ?>
                      <div class="product-item-price">
                        <?php if($product['precio_oferta']>0): ?>
                          <span class="product-item-price-before">Normal: <?= G_COIN ?> <?= number_format($product['precio'], 2) ?></span>
                          <span class="product-item-price-now"><?= G_COIN ?> <?= number_format($product['precio_oferta'], 2) ?></span>
                        <?php else: ?>
                          <span class="product-item-price-before"></span>
                          <span class="product-item-price-now"><?= G_COIN ?> <?= number_format($product['precio'], 2) ?></span>
                        <?php endif ?>
                      </div>
                      <?php
                    }*/
                    ?>
                </div>
              
            </div>
        </div>
        <?php
        }
        ?>
    </div>
    <div class="category-pagination" style="margin-bottom:60px">
			<ul>
        <li<?php if($CurrentPage==1) echo " class='page-disabled'" ?>>
					<a href="<?= url_page($term, 1, $type) ?>">«</a>
				</li>
				<li<?php if($PrevPage==0) echo " class='page-disabled'" ?>>
					<a href="<?= url_page($term, $PrevPage, $type) ?>">‹</a>
				</li>
				<?php
				for ($i = 1; $i <= $TotalPage; $i++):
				?>
				<li>
					<a <?php if($CurrentPage==$i) echo " class='page-resalt'" ?>href="<?= url_page($term, $i, $type) ?>"><?= $i ?></a>
				</li>
				<?php
				endfor;
				?>
				<li<?php if($NextPage==0) echo " class='page-disabled'" ?>>
					<a href="<?= url_page($term, $NextPage, $type) ?>">›</a>
				</li>
				<li<?php if($LastPage==0) echo " class='page-disabled'" ?>>
					<a href="<?= url_page($term, $LastPage, $type) ?>">»</a>
				</li>
			</ul>
		</div>
  </div>
</div>
<?php rb_footer(['footer-allpages.php'], false) ?>
