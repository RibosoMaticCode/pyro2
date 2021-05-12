<?php rb_header(['header-allpages.php'], false) ?>
<div class="wrap-content">
	<div class="inner-content inner-cart">
		<h3>Mi carrito</h3>
		<div class="cover-cart-items">
			<table class="tables">
				<thead>
					<tr>
						<th colspan="2">Producto</th>
						<th>Precio</th>
						<th>Cantidad</th>
						<th>Sub-Total</th>
					</tr>
				</thead>
				<tbody>
					<?php
					if(isset($_SESSION['carrito']) && count($_SESSION['carrito'])>0):
						$totsum = 0;
						foreach($products as $product):
							$tot = round($product['precio'] * $product['cantidad'],2);
							?>
								<tr>
									<td style="width:120px"><img style="max-width:100px;" src="<?= $product['image_url'] ?>" alt="img" /></td>
									<td><a href="<?= $product['url'] ?>"><?= $product['nombre'] ?></a>
										<span><?= $product['variant'] ?></span>
										<br /><br /><a href="<?= G_SERVER ?>/rb-script/modules/plm/cart.del.php?id=<?= $product['id'] ?>&variant_id=<?= $product['variant_id'] ?>">Eliminar</a></td>
									<td class="col_right"><?= G_COIN." ".number_format($product['precio'],2) ?></td>
									<td class="col_center"><?= $product['cantidad'] ?></td>
									<td class="col_right"><?= G_COIN." ".number_format($tot,2) ?></td>
								</tr>
							<?php
							$totsum += $tot;
						endforeach;
					else:
						?>
						<tr><td colspan="5"><p style="text-align: center">Tu carrito de compra esta vacio</p></td></tr>
						<?php
					endif;
					?>
				</tbody>
				<tfoot>
				
					<?php if(isset($_SESSION['carrito']) && count($_SESSION['carrito'])>0): ?>
						<?php if(isset($_SESSION['discount']) && count($_SESSION['discount'])>0): $discount = $_SESSION['discount']; $totsum = $discount['tot_update']; 
						?>
							<tr>
								<td colspan="4">
									<div>
										<span id="coupon_detalle">Cupón aplicado</span>
										<input type="text" id="coupon_code" placeholder="<?= $_SESSION['discount']['coupon']['code'] ?>" readonly />
										<a id="coupon_retire" href="#">Retirar cupón</a>
									</div>
									<div id="coupon_detail" class="coupon_detail">
										<?=  nl2br($_SESSION['discount']['coupon']['description']) ?>
									</div>
								</td>
								<td class="tot_discount">
									<span id="tot_discount">
										<?= G_COIN ?> <?=  number_format(round($_SESSION['discount']['tot_discount'], 2),2) ?>
									</span>
								</td>
							</tr>
							<tr>
								<td><a href="<?= get_option('link_continue_purchase') ?>">Ver mas productos</a></td>
								<td></td>
								<td></td>
								<td>TOTAL</td>
								<td class="col_right"><?= G_COIN ?> <span id="total"><?= number_format(round($totsum, 2),2) ?></span></td>
							</tr>
						<?php else: ?>
							<?php if( get_option('show_cupons_form') == 1 ): ?>
							<tr>
								<td colspan="4">
									<div>
										<span id="coupon_detalle">Aplicar cupón de descuento</span>
										<input type="text" id="coupon_code" placeholder="Ej. VERANO21" />
										<button id="coupon_apply">Aplicar</button>
									</div>
									<div id="coupon_detail">
									</div>
								</td>
								<td class="tot_discount">
									<span id="tot_discount">
									</span>
								</td>
							</tr>
							<?php endif ?>
							<tr>
								<td><a href="<?= get_option('link_continue_purchase') ?>">Ver mas productos</a></td>
								<td></td>
								<td></td>
								<td>TOTAL</td>
								<td class="col_right"><?= G_COIN ?> <span id="total"><?= number_format(round($totsum, 2),2) ?></span></td>
							</tr>
						<?php endif ?>				
					<?php endif ?>
				</tfoot>
			</table>
		</div>
		<div class="cover-btn-cart">
			<?php
			if(count($products)>0):
				if(G_ACCESOUSUARIO==0): ?>
					<?php if( get_option('allow_buy_without_login') == 1 ): ?>
						<?php include_once 'order.form.client.php' ?>
						<a class="btn" id="btnShowClientForm" href="#">Continuar con mi compra</a>
					<?php else: ?>
						<a class="btn" href="<?= G_SERVER ?>/login.php?redirect=<?= $pre_payment_url ?>">Continuar con mi compra</a>
					<?php endif ?>
				<?php else: ?>
					<a class="btn" href="<?= $pre_payment_url ?>">Continuar con mi compra</a>
				<?php
				endif;
			endif;
			?>
		</div>
	</div>
</div>
<?php rb_footer(['footer-allpages.php'], false) ?>
