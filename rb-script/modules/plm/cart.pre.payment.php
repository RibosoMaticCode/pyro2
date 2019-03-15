<?php rb_header(['header-allpages.php'], false) ?>
<div class="wrap-content">
	<div class="inner-content inner-cart cover-prepayment">
    <h3>Informacion de contacto <span style="font-size:.8em">[<a href="<?= G_SERVER ?>/?pa=panel">Editar</a>]</span></h3>
		<div class="user-info">
			<div class="cols-container">
				<div class="cols-6-md">
					<p><strong>Nombres y apellidos</strong></p>
					<p><span><?= $user['nombrecompleto']?></span></p>
				</div>
				<div class="cols-6-md">
					<p><strong>Correo electrónico</strong></p>
					<p><span><?= $user['correo']?></span></p>
				</div>
			</div>
			<div class="cols-container">
				<div class="cols-6-md">
					<p><strong>Telefono</strong></p>
					<p><span><?= $user['telefono_movil']?></span></p>
					<p><span><?= $user['telefono_fijo']?></span></p>
				</div>
				<div class="cols-6-md">
				</div>
			</div>
		</div>
		<h3>Direccion de envio <span style="font-size:.8em">[<a href="<?= G_SERVER ?>/?pa=panel">Editar</a>]</span></h3>
		<div class="user-info">
			<div class="cols-container">
				<div class="cols-6-md">
					<p><strong>Dirección</strong></p>
					<p><span><?= $user['direccion']?></span></p>
				</div>
				<div class="cols-6-md">
					<p><strong>Código postal</strong></p>
					<p><span><?= $user['codigo_postal']?></span></p>
				</div>
			</div>
			<div class="cols-container">
				<div class="cols-6-md">
					<p><strong>Ciudad</strong></p>
					<p><span><?= $user['ciudad']?></span></p>
				</div>
				<div class="cols-6-md">
					<p><strong>País</strong></p>
					<p><span><?= $user['pais']?></span></p>
				</div>
			</div>
		</div>
		<h3>Detalle de su pedido</h3>
		<div class="cover-cart-items">
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
								<td><a href="<?= $product['url'] ?>"><?= $product['nombre'] ?></a></td>
								<td class="col_right"><?= G_COIN." ".number_format($product['precio'], 2) ?></td>
								<td class="col_center"><?= $product['cantidad'] ?></td>
								<td class="col_right"><?= G_COIN." ".number_format($tot, 2) ?></td>
							</tr>
						<?php
						$totsum += $tot;
					}
					?>
				</tbody>
				<tfoot>
					<tr>
						<td><a href="<?= $cart_url ?>">Editar mi pedido</a></td>
						<td></td>
						<td></td>
						<td>TOTAL</td>
						<td class="col_right"><?= G_COIN." ".number_format(round($totsum, 2), 2) ?></td>
					</tr>
				</tfoot>
			</table>
		</div>
		<div class="cover-btn-cart">
			<?php
			if($user['pais']=='0' || $user['direccion']=="" || $user['ciudad']=""){
				?>
				<div class="plm_warning">Debe completar la siguiete informacion para continuar con su compra: direccion, ciudad, pais y codigo postal (opcional)</div>
				<?php
			}else{
				if(get_option('plm_charge')=="0"){
					?>
					<script>
						$(document).ready(function() {
					    // Boton Realizar el pago
					    $('.cart_button').click(function(event){
					      event.preventDefault();
					  		$.ajax({
					  			method: "get",
					  			url: "<?= G_SERVER ?>/rb-script/modules/plm/payment.success.php"
					  		})
					  		.done(function( data ) {
					  			if(data.resultado){
										setTimeout(function(){
						          window.location.href = '<?= $panel_user ?>';
						        }, 1000);
					  	  	}else{
					  				console.log(data.contenido);
					  	  	}
					  		});
					    });
					  });
					</script>
					<a class="btn-cart-next" href="#">Realizar el pedido de <?= G_COIN ?> <?= number_format(round($totsum, 2), 2) ?></a>
					<?php
				}else{
					?>
					<button class="btn-cart-next" id="buyButton">Realizar el pago de <?= G_COIN ?> <?= number_format(round($totsum, 2), 2) ?></button>
					<?php
				}
				?>
				<p>IMPORTANTE: No interrumpir el siguiente proceso.</p>
				<?php
			}
		?>
		</div>
		<div class="block_wait" style="display:none">
			<img class="block_wait_img" src="<?= G_DIR_MODULES_URL ?>plm/load.gif" alt="wait" />
			<div class="block_wait_message"></div>
		</div>
  </div>
</div>
<script src="https://checkout.culqi.com/js/v3"></script>
<script>
    // Configura tu llave pública
    Culqi.publicKey = '<?= get_option('key_public') ?>';
    // Configura tu Culqi Checkout
    Culqi.settings({
        title: '<?= G_TITULO ?>',
        currency: 'PEN',
        description: 'Todas las transacciones son seguras y encriptadas.',
        amount: <?= number_format( round($totsum, 2), 2, '', '') ?>
    });
    // Usa la funcion Culqi.open() en el evento que desees
    $('#buyButton').on('click', function(e) {
        // Abre el formulario con las opciones de Culqi.settings
        Culqi.open();
        e.preventDefault();
    });

		function culqi() {
		  if (Culqi.token) { // ¡Objeto Token creado exitosamente!
		      var token = Culqi.token.id;
					var email = '<?= $user['correo']?>';
					var amount = '<?= number_format( round($totsum, 2), 2, '', '') ?>';
		      //alert('Se ha creado un token:' + token);

					//Pantalla oscura y poner espere por favor
					$('.bg, .block_wait').show();
					$('.block_wait_message').html("Espera por favor...");
					// Send data ajax
					$.ajax({
		  			method: "get",
		  			url: "<?= G_SERVER ?>/rb-script/modules/plm/create.charge.php?token="+token+"&email="+email+"&amount="+amount
		  		})
		  		.done(function( data ) {
							console.log(data);
							//return false;

							// Si se exitosa
							if(data.object=="charge"){
								if(data.outcome.type=="venta_exitosa"){
									$('.block_wait_img').hide();
									$('.block_wait_message').html("Proceso exitoso.");
									var charge_id = data.id;
									// Crear pedido y direccionar al cliente
									$.ajax({
						  			method: "get",
						  			url: "<?= G_SERVER ?>/rb-script/modules/plm/payment.success.php?charge_id="+charge_id
						  		})
						  		.done(function( data ) {
						  			if(data.resultado){
											setTimeout(function(){
							          window.location.href = '<?= $panel_user ?>';
							        }, 1000);
						  	  	}else{
						  				console.log(data.contenido);
						  	  	}
						  		});
								}else{
									console.log(data);
									alert("Hubo error en el proceso. Recargue la página e intente nuevamente.");
								}
							}
							// Si da error
							if(data.object=="error"){
								$('.block_wait_img').hide();
								$('.block_wait_message').html(data.merchant_message+"<br /><a class='close_reload' href='#'>Intentar nuevamente</a>");
							}
		  		});

		  } else { // ¡Hubo algún problema!
		      // Mostramos JSON de objeto error en consola
		      console.log(Culqi.error);
		      alert(Culqi.error.user_message);
		  }

			// Cerrar y recargar en caso de error
			$(document).on('click', '.close_reload', function (event){
			//$('.close_reload').click(function(event){
				setTimeout(function(){
					window.location.href = '<?= G_SERVER ?>/pre-payment/';
				}, 1000);
			});
		};
</script>
<?php rb_footer(['footer-allpages.php'], false) ?>
