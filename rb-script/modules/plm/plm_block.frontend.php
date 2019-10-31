<?php
$estilo = $widget['widget_values']['estilo'];
$tipo = $widget['widget_values']['tipo'];
$class = $widget['widget_class'];
$limite = 8; // default
global $objDataBase;
// I. Consulta sql

switch($tipo){
  case 1;
    // mas vendidos - sold
    $q = "SELECT * FROM plm_products WHERE mostrar=1 ORDER BY salidas DESC LIMIT $limite";
  break;
  case 2:
    // mejores ofertas - discount
    $q = "SELECT * FROM plm_products WHERE mostrar=1 ORDER BY descuento DESC LIMIT $limite";
  break;
  case 3:
    // recientes - recents
    $q = "SELECT * FROM plm_products WHERE mostrar=1 ORDER BY id DESC LIMIT $limite";
  break;
  case 4:
    // antiguos - olds
    $q = "SELECT * FROM plm_products WHERE mostrar=1 ORDER BY id ASC LIMIT $limite";
  break;
}

$qr = $objDataBase->Ejecutar($q);

$num_products = $qr->num_rows;
$products = [];
$i=0;
while($product = $qr->fetch_assoc()):
  $products[$i]['id'] = $product['id'];
  $products[$i]['nombre'] = $product['nombre'];
  $products[$i]['precio_oferta'] = $product['precio_oferta'];
  $products[$i]['precio'] = $product['precio'];
  $products[$i]['descuento'] = $product['descuento'];
  if(G_ENL_AMIG) $products[$i]['url'] = G_SERVER."products/".$product['nombre_key']."/";
  else $products[$i]['url'] = G_SERVER."?products=".$product['id'];
  $photo = rb_get_photo_details_from_id($product['foto_id']);
  $products[$i]['image_url'] = $photo['file_url'];
  $i++;
endwhile;

// II. Estilo visual
switch($estilo){
  case 1:
    ?>
    <div class="cols-container <?= $class ?>">
    <?php
    $i = 1;
    foreach($products as $product){
      $css_block_list = "";
      if($i==2 || $i==6) $css_block_list = "view-vertical";
      if($i==1 || $i==2 || $i==5 || $i==6) echo '<div class="cols-3-md '.$css_block_list.'">';
      ?>
      <div id="<?= $i ?>" class="product-item">
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
      if($i==1 || $i==4 || $i==5 || $i==8 || $num_products==$i) echo '<!--cerrando'.$i.'--></div>';
      $i++;
    }?>
    </div>
    <?php
  break;
}
?>
