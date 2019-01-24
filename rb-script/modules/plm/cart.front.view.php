<?php rb_header(['header-allpages.php'], false) ?>
<div class="wrap-content">
	<div class="inner-content inner-cart">
		<h2>Mi carrito</h2>
		<table class="tables">
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
							<td><a href="<?= $product['url'] ?>"><?= $product['nombre'] ?></a><br /><a href="<?= G_SERVER ?>/rb-script/modules/plm/cart.del.php?id=<?= $product['id'] ?>">Eliminar</a></td>
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
					<td><a href="<?= get_option('link_continue_purchase') ?>">Seguir comprando</a></td>
					<td></td>
					<td></td>
					<td>TOTAL</td>
					<td class="col_right"><?= G_COIN." ".number_format(round($totsum, 2),2) ?></td>
				</tr>
			</tfoot>
		</table>
		<div>
			<?php
			if(count($products)>0):
				if(G_ACCESOUSUARIO==0): ?>
					<a class="btn" href="<?= G_SERVER ?>/login.php?redirect=<?= $pre_payment_url ?>">Continuar con mi compra</a>
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
