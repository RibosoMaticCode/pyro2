<?php rb_header(['header-allpages.php'], false) ?>
<?php
include_once ABSPATH.'rb-script/modules/plm/ordermail/order.form.php';
?>
<div class="clear page_header" style="background-image:url(https://www.cienpharma.com/rb-media/gallery/bg-breadcrumb-scaled.jpg);background-position:center;background-size:cover;">
  <div class="inner-content inner_page_header clear" style="">
    <div class="cols">
      <div class="col ">
        <div class="">
          <h1>MI CARRITO</h1>
        </div>
      </div><!--end col or coverwidgets-->
      <div class="col ">
        <div class="">
          <p><i class="fas fa-home"></i> <a href="https://www.cienpharma.com/">INICIO</a> <span class="separador">&nbsp;<i class="fas fa-chevron-right"></i></span> MI CARRITO</p>
        </div>
      </div><!--end col or coverwidgets-->
    </div><!--end cols-->
  </div><!--end inner box-->
</div>
<div class="wrap-content">
	<div class="inner-content inner-cart">
		<h3>Mi carrito</h3>
		<div class="cover-cart-items">
			<table class="tables" id="order_details">
				<thead>
					<tr>
						<th colspan="2">Producto</th>
						<th>Precio</th>
						<th>Cantidad</th>
						<th>Total</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$totsum = 0;
					foreach($products as $product){
						$tot = round($product['precio'] * $product['cantidad'],2);
						?>
							<tr>
								<td style="width:120px"><img style="max-width:100px;" src="<?= $product['image_url'] ?>" alt="img" /></td>
								<td><a href="<?= $product['url'] ?>"><?= $product['nombre'] ?></a>
									<span><?= $product['variant'] ?></span>
									<br /><br /><a class="sapi_cart_del" href="<?= G_SERVER ?>rb-script/modules/plm/cart.del.php?id=<?= $product['id'] ?>&variant_id=<?= $product['variant_id'] ?>">Eliminar</a></td>
								<td class="col_right"><?= G_COIN." ".number_format($product['precio'],2) ?></td>
								<td class="col_center"><?= $product['cantidad'] ?></td>
								<td class="col_right"><?= G_COIN." ".number_format($tot,2) ?></td>
							</tr>
						<?php
						$totsum += $tot;
					}
					?>
				</tbody>
				<tfoot>
					<tr>
						<td><a class="sapi_cart_prod" href="<?= get_option('link_continue_purchase') ?>">Ver mas productos</a></td>
						<td></td>
						<td></td>
						<td>TOTAL</td>
						<td class="col_right"><?= G_COIN ?> <span class="product_price"><?= number_format(round($totsum, 2),2) ?><span></td>
					</tr>
				</tfoot>
			</table>
		</div>
		<div class="cover-btn-cart">
			<?php if(count($products)>0): ?>
				<?php if ( get_option('plm_charge') == 0 ): ?>
					<a class="frmSapiensShowFisico btn-cart-next" href="#">Realizar mi pedido</a>
				<?php else: ?>
					<!-- SOLO PAGO CON TARJETAS -->
					<a class="btn-cart-next" href="#">Continuar con el pago</a>
				<?php endif; ?>
			<?php endif; ?>
		</div>
	</div>
</div>
<?php rb_footer(['footer-allpages.php'], false) ?>
