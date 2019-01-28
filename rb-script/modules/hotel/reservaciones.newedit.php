<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

require_once ABSPATH.'global.php';
require_once 'funcs.php';

/* parametros inciales */
$file_prefix = "reservaciones";
$table_name = "hotel_reservacion";
$key = "hotel_reservaciones";
$module_dir = "hotel";
$save_path = G_DIR_MODULES_URL.$module_dir."/".$file_prefix.".save.php";
$urlreload=G_SERVER.'/rb-admin/module.php?pag='.$key;

/* customers */
$qc = $objDataBase->Ejecutar("SELECT * FROM crm_customers");

/* start */
if( isset($_GET['res_id']) && $_GET['res_id'] > 0 ){
  $id=$_GET['res_id'];
  $q = $objDataBase->Ejecutar("SELECT * FROM $table_name WHERE id=$id");
  $row = $q->fetch_assoc();
	$hab_id = $row['habitacion_id'];
}else{
  $id = 0;
	$hab_id = $_GET['hab'];
}
?>
<form id="frmNewEdit" class="form" style="max-width:800px">
	<?php
		/* habitaciones */
		$qh = $objDataBase->Ejecutar("SELECT * FROM hotel_habitacion WHERE id=$hab_id");
		$habitacion = $qh->fetch_assoc();
	?>
	<h3 class="title_center">Reservacion <?php if(isset($row)) echo $row['codigo_unico']; else echo "Nueva"; ?></h3>
	<div class="cols-container">
		<div class="cols-6-md">
			<input type="hidden" name="id" value="<?= $id ?>" required />
			<!-- campos inicio -->
			<label>
				Habitacion seleccionada
				<input type="text" readonly value="<?= $habitacion['numero_habitacion'] ?>" />
				<input type="hidden" name="habitacion_id" value="<?= $hab_id ?>" required />
			</label>
			<label>
				Huesped (<a target="_blank" href="<?= G_SERVER ?>/rb-admin/module.php?pag=customers">Nuevo</a>)
				<select name="cliente_id" <?php if($id>0) echo "disabled" ?>>
					<?php
					while($cliente = $qc->fetch_assoc()):
					?>
						<option value="<?= $cliente['id'] ?>" <?php if(isset($row) && $cliente['id']==$row['cliente_id']) echo " selected " ?>><?= $cliente['nombres'] ?></option>
					<?php
					endwhile;
					?>
				</select>
			</label>
			<div class="cols-container">
				<div class="cols-6-md">
					<label>
						<?php
						$today = $_GET['date'] ? $_GET['date'] : date('Y-m-d');
						?>
				  	Fecha Desde
				    <input type="date" name="fecha_llegada" required value="<?php if(isset($row)) echo rb_sqldate_to($row['fecha_llegada'], 'Y-m-d'); else echo $today ?>" <?php if($id>0) echo "readonly" ?> />
				  </label>
					<label><strong>Check in: <?= get_option('hora_llegada')?></strong></label>
				</div>
				<div class="cols-6-md">
					<label>
				    Fecha Hasta
						<?php
						$tomorrow = date('Y-m-d', strtotime($today . ' +1 day'));
						?>
				    <input type="date" name="fecha_salida" required value="<?php if(isset($row)) echo rb_sqldate_to($row['fecha_salida'], 'Y-m-d'); else echo $tomorrow; ?>" />
				  </label>
					<label><strong>Check out: <?= get_option('hora_salida')?></strong></label>
				</div>
			</div>
			<?php if($id>0): ?>
			<label>
				Estado habitacion
				<span class="info">Cambiar cuando el huesped llegue a ocupar su habitacion</span>
				<select name="estado">
					<option value="1">Reservado</option>
					<option value="2">Ocupado</option>
				</select>
			</label>
		<?php endif; ?>
			<div class="detalles_reservacion">
				<div class="cols-container">
					<div class="cols-6-md">
						Total habitacion
					</div>
					<div class="cols-6-md">
						<?= G_COIN ?> <span id="total_habitacion_visible"><?= $habitacion['precio'] ?></span>
						<input id="total_habitacion" type="hidden" name="total_habitacion" value="<?= $habitacion['precio'] ?>" />
					</div>
				</div>
				<div class="cols-container">
					<div class="cols-6-md">
						Total extras
					</div>
					<div class="cols-6-md">
						<?= G_COIN ?> <span id="total_extras_visible"><?php if(isset($row)) echo $row['total_adicionales'] ?></span>
						<input id="total_extras" type="hidden" name="total_extras" value="<?php if(isset($row)) echo $row['total_adicionales'] ?>" />
					</div>
				</div>
				<div class="cols-container">
					<div class="cols-6-md">
						Total Final
					</div>
					<div class="cols-6-md">
						<?= G_COIN ?> <span id="total_final_visible"><?php if(isset($row)) echo $row['total_reservacion'] ?></span>
						<input id="total_final" type="hidden" name="total_final" value="<?php if(isset($row)) echo $row['total_reservacion'] ?>" />
					</div>
				</div>
			</div>
		</div>
		<div class="cols-6-md">
			<!-- productos adicionales -->
			<input type="hidden" id="plato_id_temp" />
			<input type="hidden" id="plato_prec_temp" />
			<input type="hidden" name="productos_json" id="productos_json" />
			<div class="cols-container container_plato_filter">
				<div class="cols-8-md">
					<label class="cover_plato_filter">
				    Producto / Servicio extra
				    <input id="plato_nombre" type="text" name="plato_nombre" placeholder="Escriba nombre del plato" autocomplete="off" />
						<span class="error_msg" id="err_plato"></span>
						<div class="cover_platos_list">
							<ul class="platos_list">
								<?php
								$qp = $objDataBase->Ejecutar("SELECT * FROM hotel_producto ORDER BY nombre");
								while($plato = $qp->fetch_assoc()){
									$photo = rb_get_photo_details_from_id($plato['foto_id']);
									?>
									<li>
										<a class="plato" data-id="<?= $plato['id'] ?>" data-precio="<?= $plato['precio'] ?>" href="#">
											<img style="max-width:50px" src="<?= $photo['thumb_url'] ?>" alt="imagen" /><?= $plato['nombre'] ?> : S/ <?= $plato['precio'] ?>
										</a>
									</li>
									<?php
								}
								?>
							</ul>
						</div>
					</label>
				</div>
				<div class="cols-2-md">
					<label>
				    Cantidad
				    <input id="plato_cantidad" type="number" name="plato_cantidad" autocomplete="off" />
						<span class="error_msg" id="err_cant"></span>
				  </label>
				</div>
				<div class="cols-2-md">
					<button class="btnAdd" type="button">Añadir</button>
				</div>
			</div>
			<div class="pedido_detalles">
				<?php
				//if(isset($pedido)){
					$qpd = $objDataBase->Ejecutar("SELECT * FROM hotel_extras WHERE reservacion_id=".$id);
					while ($pedido_detalle = $qpd->fetch_assoc()) {
						$qpl = $objDataBase->Ejecutar("SELECT * FROM hotel_producto WHERE id=".$pedido_detalle['producto_id']);
						$plato = $qpl->fetch_assoc();
						?>
						<div class="cols-container plato-item" data-id="<?= $pedido_detalle['plato_id'] ?>" data-prec="<?= $pedido_detalle['precio'] ?>" data-cant="<?= $pedido_detalle['cantidad'] ?>">
							<div class="cols-7-md"><?= $plato['nombre'] ?></div>
							<div class="cols-2-md"><?= $pedido_detalle['cantidad'] ?></div>
							<div class="cols-2-md"><?= $pedido_detalle['precio'] ?></div>
							<div class="cols-1-md"><a class="delete" title="Quitar" href="#">x</a></div>
						</div>
						<?php
					}
				//}
				?>
			</div>
		</div>
	</div>
	<!-- campos final -->
  <div class="cols-container">
    <div class="cols-6-md cols-content-left">
			<?php if ($id==0): ?>
      	<button type="submit">Realizar reservacion</button>
			<?php else: ?>
				<button type="submit">Actualizar datos</button>
			<?php endif ?>
    </div>
    <div class="cols-6-md cols-content-right">
      <button type="button" class="CancelFancyBox">Cancelar</button>
    </div>
  </div>
</form>
<script>
	$(document).ready(function() {
    // Boton Cancelar
    $('.CancelFancyBox').on('click',function(event){
			$.fancybox.close();
		});

		// GENERAR RESERVACION
		// =======================================
		$('#frmNewEdit').submit(function(event){
			event.preventDefault();
			var platos = {};
			$(".plato-item").each(function(index, element){
					plato_id = $(element).attr("data-id");
					plato_prec = $(element).attr("data-prec");
					plato_cant = $(element).attr("data-cant");

					//JavaScript does not support arrays with named indexes.
					//plato = new Array( plato_id,  plato_cant, plato_prec);
					plato = {};
					plato['producto_id'] = plato_id;
					plato['cant'] = plato_cant;
					plato['prec'] = plato_prec;

					//platos.push(plato);
					platos[plato_id] = plato;
			});
			var platosJson = JSON.stringify(platos);
			console.log(platos);
			console.log(platosJson);
			$('#productos_json').val(platosJson);

			$.ajax({
				method: "post",
				url: "<?= $save_path ?>",
				data: $( this ).serialize()
			})
			.done(function( data ) {
				if(data.resultado){
					$.fancybox.close();
					notify(data.contenido);
					setTimeout(function(){
						window.location.href = '<?= $urlreload ?>&date=<?= $today ?>';
					}, 1000);
				}else{
					notify(data.contenido);
				}
			});
		});

		// BUSCAR PLATO ESCRIBIENDO SU NOMBRE
		// =======================================
		$('#plato_nombre').keyup(function(event){
			text_search = $(this).val();
			if(text_search.length == 0){
				$('#plato_id_temp').val("");
				$('.cover_platos_list').hide();
			}else{
				$('.cover_platos_list').show();
			}
			$(".platos_list > li").each(function() {
				if ($(this).text().search(new RegExp(text_search, "i")) > -1) { // No sensible a Mayus-Minusc
					$(this).show();
				}else{
					$(this).hide();
				}
			});
		});

		// CLICK EN EL PLATO
		// =======================================
		$('.plato').click(function(event){
			var text_item = $(this).closest('li').text().trim();
			//console.log(text_item);
			$('#plato_nombre').val(text_item);
			$('#plato_cantidad').focus();
			$('.cover_platos_list').hide();
			$('#plato_id_temp').val( $(this).attr( "data-id" ) );
			$('#plato_prec_temp').val( $(this).attr( "data-precio" ) );
		});

		// AÑADIR PUBLICACION
		// =======================================
		//var total_extras = 0;
		$('.btnAdd').click(function (event){
			event.preventDefault();

			// validaciones
			var plato_id = $('#plato_id_temp').val();
			var plato_prec = $('#plato_prec_temp').val();
			var plato_name = $('#plato_nombre').val();
			var plato_cant = $('#plato_cantidad').val();

			/*
			// Calcular total extras
			total_extras += plato_prec * plato_cant;
			console.log("extras"+total_extras);
			$('#total_extras').val(total_extras);
			$('#total_extras_visible').html(total_extras);

			// Calcular total reservacion
			total_habitacion = $('#total_habitacion').val();
			total_final = parseFloat(total_habitacion) + parseFloat(total_extras);
			$('#total_final').val(total_final);
			$('#total_final_visible').html(total_final);
			*/


			if(plato_id == "" || plato_name == ""){
				$('#plato_nombre').addClass('error');
				$('#err_plato').text("El plato no se reconoce");
				return false;
			}else{
				$('#plato_nombre').removeClass('error');
				$('#err_plato').text("");
			}
			if(plato_cant == "" || plato_cant == 0 || plato_cant < 0){
				$('#plato_cantidad').addClass('error');
				$('#err_cant').text("Ingresa cantidad correctamente");
				return false;
			}else{
				$('#plato_cantidad').removeClass('error');
				$('#err_cant').text("");
			}

			// Buscar repetido
			if( $(".plato-item").length > 0){
				// Buscar repetido
				var repetido = false;
				$(".pedido_detalles .plato-item").each(function(){
    	    // Si existe reemplazar
					if( $(this).attr("data-id") == plato_id ){
						console.log("repetido");
						$(this).replaceWith(
							'<div class="cols-container plato-item" data-id="'+plato_id+'" data-prec="'+plato_prec+'" data-cant="'+plato_cant+'"><div class="cols-7-md">'+plato_name+'</div><div class="cols-2-md">'+plato_cant+'</div><div class="cols-2-md">'+plato_prec+'</div><div class="cols-1-md"><a class="delete" title="Quitar" href="#">x</a></div></div>'
						);
						repetido = true;
					}
    		});
				if(repetido==false) add(plato_id, plato_name, plato_cant, plato_prec);
			}else{
				add(plato_id, plato_name, plato_cant, plato_prec);
				$('.btnSend').show();
			}

			calcular_totales();
			// limpiar datos y poner cursor
			$('#plato_nombre').val("");
			$('#plato_cantidad').val("");
			$('#plato_id_temp').val("");
			$('#plato_nombre').focus();
		});

		// ELIMINAR PLATO DE LISTA TEMPORAL
		// =======================================
		$('.pedido_detalles').on('click', '.delete', function(event){
			$(this).closest('.plato-item').remove();
			if( $(".plato-item").length == 0){
				$('.btnSend').hide(); // ocultar boton submit sino hay elementos a guardar
			}
			calcular_totales();
		});

		// FUNCION AÑADIR PLATO AL PEDIDO
		// =====================================
		function add(plato_id, plato_name, plato_cant, plato_prec){
			$('.pedido_detalles').append(
				'<div class="cols-container plato-item" data-id="'+plato_id+'" data-prec="'+plato_prec+'" data-cant="'+plato_cant+'"><div class="cols-7-md">'+plato_name+'</div><div class="cols-2-md">'+plato_cant+'</div><div class="cols-2-md">'+plato_prec+'</div><div class="cols-1-md"><a class="delete" title="Quitar" href="#">x</a></div></div>'
			);
		}


		function calcular_totales(){
			//return "hola";
			var total_extras=0;
			var platos = {};

			$(".plato-item").each(function(index, element){
					//plato_id = $(element).attr("data-id");
					plato_prec = $(element).attr("data-prec");
					plato_cant = $(element).attr("data-cant");

					//JavaScript does not support arrays with named indexes.
					//plato = new Array( plato_id,  plato_cant, plato_prec);
					subtotal = plato_prec * plato_cant;
					console.log(subtotal);
					total_extras += subtotal;
			});

			// Calcular total extras
			console.log("extras"+total_extras);
			$('#total_extras').val(total_extras);
			$('#total_extras_visible').html(total_extras);

			// Calcular total reservacion
			total_habitacion = $('#total_habitacion').val();
			total_final = parseFloat(total_habitacion) + parseFloat(total_extras);
			$('#total_final').val(total_final);
			$('#total_final_visible').html(total_final);
		}

  });
</script>
